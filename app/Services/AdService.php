<?php

namespace App\Services;

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
     * @param array $storeData
     * @param Ad $ad
     * @return void
     */
    public function updateAd(array $storeData, Ad $ad)
    {
        if (isset($storeData['img_src'])) {
            $fileName = $this->prepareFile($storeData['img_src']);
            $storeData['img_src'] = $fileName;
            $storeData['user_id'] = Auth::id();
        }
        $ad->update($storeData);
    }
}
