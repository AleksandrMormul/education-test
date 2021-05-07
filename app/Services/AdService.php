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
        $file = $request->adFile;
        $this->saveFile($file);
    }

    /**
     * @param UploadedFile $file
     */
    private function saveFile(UploadedFile $file): void
    {
        $userId = Auth::id();
        $fileName = $file->getClientOriginalName();
        Storage::disk(Config::get('filesystems.default'))->putFileAs('/' . $userId, $file, $fileName);
    }
}
