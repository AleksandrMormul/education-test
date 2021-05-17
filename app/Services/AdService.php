<?php

namespace App\Services;

use App\Models\Ad;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

/**
 * AdService
 */
class AdService
{

    const DEFAULT_IMAGE = 'temp.png';

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
        $storeData['user_id'] = Auth::id();
        $ad = Ad::create($storeData);
        return $ad->id;
    }

    /**
     * @param UploadedFile $file
     * @return string|null
     */
    public function storeAdImage(UploadedFile $file): ?string
    {
        $fileName = uniqid(rand(), true) . '.' . $file->getClientOriginalExtension();
        $this->saveFile($file, $fileName);
        return $fileName;
    }

    /**
     * @param UploadedFile $file
     * @param string $fileName
     */
    private function saveFile(UploadedFile $file, string $fileName): void
    {
        Storage::disk(Config::get('filesystems.default'))->putFileAs('/public/ads', $file, $fileName);
    }

    /**
     * @param array $storeData
     * @param Ad $ad
     * @return void
     */
    public function updateAd(array $storeData, Ad $ad)
    {
        $storeData['user_id'] = Auth::id();
        $ad->update($storeData);
    }

    /**
     * @return string
     */
    public function getImagePath(): string
    {
        return asset('storage/ads/');
    }

    /**
     * @return string
     */
    public function getDefaultImage(): string
    {
        return asset('images/' . self::DEFAULT_IMAGE);
    }
}
