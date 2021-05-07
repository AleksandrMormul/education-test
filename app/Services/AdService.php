<?php

namespace App\Services;

use App\Http\Requests\CreateAdRequest;
use App\Models\Ad;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;

/**
 * AdService
 */
class AdService
{

    /**
     * Get all ads
     *
     * @return Builder
     */
    public function getAds()
    {
        return Ad::query();
    }

    /**
     * Get Ad
     *
     * @return Ad
     */
    public function getAd(int $id)
    {
        return Ad::with('user')->find($id);
    }

    /**
     * @param CreateAdRequest $request
     */
    public function createAd(CreateAdRequest $request)
    {
        include(app_path('/Common/convertCountry.php'));
        $coordination = $this->prepareCoordination($request);
        $ad = Ad::create([
            'title' => $request->title,
            'user_id' => Auth::id(),
            'description' => $request->description,
            'phone_number' => $request->phone,
            'end_date' => $request->endDate,
            'img_src' => $this->prepareFile($request),
            'country_code' => countryNameToISO3166($request->country, Lang::getLocale()),
            'latitude' => $coordination['lat'],
            'longitude' => $coordination['lng'],
        ]);
        return $ad->id;
    }

    /**
     * @param $request
     * @return array|null[]
     */
    private function prepareCoordination($request): array
    {
        $latitude = null;
        $longitude = null;
        if ($request->lat && $request->lng) {
            $longitude = $request->lng;
            $latitude = $request->lat;
        }
        return ['lat' => $latitude, 'lng' => $longitude];
    }

    /**
     * @param $request
     * @return string|null
     */
    private function prepareFile($request): ?string
    {
        $fileName = null;
        if ($request->adFile) {
            $file = $request->adFile;
            $fileName = $file->getClientOriginalName();
            $this->saveFile($file, $fileName);
        }

        return $fileName;
    }

    /**
     * @param UploadedFile $file
     * @param string $fileName
     */
    private function saveFile(UploadedFile $file, string $fileName): void
    {
        $userId = Auth::id();
        Storage::disk(Config::get('filesystems.default'))->putFileAs('/public/' . $userId, $file, $fileName);
    }
}
