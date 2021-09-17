<?php

namespace App\Services;

use App\Models\Ad;
use App\Models\Favorite;
use App\Models\Currency;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

/**
 * AdService
 */
class AdService
{
    public const DEFAULT_IMAGE_FILENAME = 'temp.png';
    public const ADS_IMAGES_PATH = 'ads';
    public const COMMON_IMAGES_PATH = 'images';

    public const PAID = 'PAID';
    public const FREE = 'FREE';
    public const RESERVATION = 'RESERVATION';
    public const FAILED = 'FAILED';


    private const CACHE_PREFIX = 'currency_';

    /**
     * Get all ads
     *
     * @return Builder
     */
    public static function getAds(): Builder
    {
        return Ad::query()->visibleForDate()->notPaid();
    }

    /**
     * Get Ad
     *
     * @param int $id
     * @return Builder|Builder[]|Collection|Model
     */
    public static function getAd(int $id)
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
     * @throws Exception
     */
    public static function deleteAd(Ad $ad): int
    {
        return $ad->delete();
    }

    /**
     * @return Ad|Favorite|Model|null
     * @param array $ids
     * @param User $user
     * @return \Illuminate\Support\Collection
     */
    public static function isFavoriteForUser(array $ids, User $user): \Illuminate\Support\Collection
    {
        return UserService::userAdFavorite($user, $ids);
    }

    /**
     * @param User $user
     * @return Builder
     */
    public static function getFavoritesForUser(User $user): Builder
    {
        return Ad::visibleForDate()->favoritesForUser($user);
    }

    /**
     * @param Ad $ad
     * @param string $currency
     * @return float
     */
    public static function convertCurrency(Ad $ad, string $currency): float
    {
        $currencyRate = self::getCurrencyRate($currency);

        return round($ad->price / $currencyRate[0]->rate, 2);
    }

    /**
     * @param string $currency
     * @return mixed
     */
    private static function getCurrencyRate(string $currency)
    {
        $key = self::CACHE_PREFIX . $currency;
        $ttl = Carbon::now()->hour()->diffInSeconds();

        return Cache::remember($key, $ttl, function () use ($currency) {
            return Currency::whereCode($currency)->get();
        });
    }
}
