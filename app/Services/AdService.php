<?php

namespace App\Services;

use App\Models\Ad;
use App\Models\Favorite;
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
    public static function getAds()
    {
        return Ad::query()->visibleForDate();
    }

    /**
     * Get Ad
     *
     * @return Ad
     */
    public static function getAd(int $id): Ad
    {
        return Ad::with('user')->find($id);
    }

    /**
     * @param array $storeData
     * @return int|mixed
     */
    public static function createAd(array $storeData)
    {
        $storeData['user_id'] = Auth::id();
        $ad = Ad::create($storeData);

        return $ad->id;
    }

    /**
     * @param UploadedFile $file
     * @return string|null
     */
    public static function storeAdImage(UploadedFile $file): ?string
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
    public static function updateAd(Ad $ad, array $storeData)
    {
        $storeData['user_id'] = Auth::id();
        $ad->update($storeData);
    }

    /**
     *
     * @param Ad $ad
     * @return string
     */
    public static function getImageUrl(Ad $ad): string
    {
        if ($ad->img_src) {
            return asset('storage/' . self::ADS_IMAGES_PATH . '/' . $ad->img_src);
        } else {
            return self::getDefaultImageUrl();
        }
    }

    /**
     * @return string
     */
    public static function getDefaultImageUrl(): string
    {
        return asset(self::COMMON_IMAGES_PATH . '/' . self::DEFAULT_IMAGE_FILENAME);
    }

    /**
     * @param Ad $ad
     * @return int
     */
    public static function deleteAd(Ad $ad): int
    {
        return Ad::destroy($ad->id);
    }

    /**
     * @param int $adId
     * @return bool
     */
    public static function isFavorite(int $adId): bool
    {
        $user = User::find(Auth::id());
        if ($user) {
            $favorite = $user->favorite(Ad::class, $adId);
            return count($favorite) === 1;
        }
        return false;
    }

    /**
     * @param int $adId
     */
    public static function deleteFavorite(int $adId)
    {
        $user = User::find(Auth::id());
        $favorite = $user->favorite(Ad::class, $adId);
        Favorite::destroy($favorite[0]->id);
    }
}
