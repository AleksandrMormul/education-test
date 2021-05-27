<?php

namespace App\Services;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
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
    public static function getAds(): Builder
    {
        return Ad::query()->visibleForDate();
    }

    /**
     * Get Ad
     *
     * @param int $id
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
        return Ad::create($storeData)->id;
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
        }

        return self::getDefaultImageUrl();
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
     * @param Ad $ad
     * @param User|null $user
     * @return bool
     */
    public static function isFavoriteForUser(Ad $ad, ?User $user): bool
    {
        if ($user) {
            $favorite = UserService::userAdFavorite($user, $ad, Ad::class);
            return count($favorite) === 1;
        }
        return false;
    }

    /**
     * @param User $user
     * @return Builder
     */
    public static function getFavoritesForUser(User $user): Builder
    {
        return Ad::visibleForDate()->favoritesForUser($user);
    }
}
