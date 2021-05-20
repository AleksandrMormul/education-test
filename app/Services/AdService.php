<?php

namespace App\Services;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * AdService
 */
class AdService
{
    public const DEFAULT_IMAGE_FILENAME = 'temp.png';

    public const ADS_IMAGES_PATH = 'ads';

    public const COMMON_IMAGES_PATH = 'images';

    /**
     * Get all ads
     *
     * @return Builder
     */
    public function getAds()
    {
        return Ad::query()->visibleForDate();
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
        $filePathName = Storage::disk('public')->putFile(self::ADS_IMAGES_PATH, $file);
        $fileName = basename($filePathName);
        return is_string($fileName) ? $fileName : null;
    }

    /**
     * @param Ad $ad
     * @param array $storeData
     * @return void
     */
    public function updateAd(Ad $ad, array $storeData)
    {
        $storeData['user_id'] = Auth::id();
        $ad->update($storeData);
    }

    /**
     *
     * @param Ad $ad
     * @return string
     */
    public function getImageUrl(Ad $ad): string
    {
        if ($ad->img_src) {
            return asset('storage/' . self::ADS_IMAGES_PATH . '/' . $ad->img_src);
        } else {
            return $this->getDefaultImageUrl();
        }
    }

    /**
     * @return string
     */
    public function getDefaultImageUrl(): string
    {
        return asset(self::COMMON_IMAGES_PATH . '/' . self::DEFAULT_IMAGE_FILENAME);
    }

    /**
     * @param int $adId
     * @return int
     */
    public function deleteAd(int $adId): int
    {
        return Ad::destroy($adId);
    }

    /**
     * @param int $adId
     * @return bool
     */
    public function isFavorite(int $adId): bool
    {
        $user = User::find(Auth::id());
        $favorite = $user->favorite(Ad::class, $adId);
        if (count($favorite) === 1) {
            return true;
        }
        return false;
    }
}
