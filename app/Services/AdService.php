<?php

namespace App\Services;

use App\Http\Requests\Ad\StoreAdRequest;
use App\Models\Ad;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use PragmaRX\Countries\Package\Countries;

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
     * @param array $storeData
     * @return int|mixed
     */
    public function createAd(array $storeData)
    {
        if (isset($storeData['img_src'])) {
            $fileName = $this->prepareFile($storeData['img_src']);
            $storeData['img_src'] = $fileName;
            $storeData['user_id'] = Auth::id();
        }
        $ad = Ad::create($storeData);
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
     * @param $file
     * @return string|null
     */
    private function prepareFile($file): ?string
    {
        $fileName = $file->getClientOriginalName();
        $this->saveFile($file, $fileName);
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

    /**
     * @param StoreAdRequest $request
     * @param int $id
     * @return mixed
     */
    public function updateAd(StoreAdRequest $request, int $id)
    {
        include(app_path('/Common/convertCountry.php'));
        $coordination = $this->prepareCoordination($request);
        $ad = Ad::where('id', '=', $id);
        $ad->update([
            'title' => $request->title,
            'user_id' => Auth::id(),
            'description' => $request->description,
            'phone_number' => $request->fullPhoneNumber,
            'end_date' => $request->endDate,
            'img_src' => $request->adFile ? $this->prepareFile($request) : $ad->first()->img_src,
            'country_code' => Countries::where('name.common', $request->country)->first()->iso_3166_1_alpha2,
            'latitude' => $coordination['lat'],
            'longitude' => $coordination['lng'],
        ]);
    }
}
