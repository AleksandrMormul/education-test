<?php

namespace App\Services;

use App\Http\Requests\CreateAdRequest;
use App\Models\Ad;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
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
    public function createAd(CreateAdRequest $request): void
    {
        $fileName = null;
        if ($request->adFile) {
            $file = $request->adFile;
            $fileName = $file->getClientOriginalName();
            $this->saveFile($file, $fileName);
        }
        Ad::create([
            'title' => $request->title,
            'description' => $request->description,
            'phone' => $request->phone,
            'endDate' => $request->endDate,
            'img_src' => $fileName,
            /*'latitude' => $latitude,
            'longitude' => $longitude,*/
        ]);
    }

    /**
     * @param UploadedFile $file
     * @param string $fileName
     */
    private function saveFile(UploadedFile $file, string $fileName): void
    {
        $userId = Auth::id();
        Storage::disk(Config::get('filesystems.default'))->putFileAs('/' . $userId, $file, $fileName);
    }
}
