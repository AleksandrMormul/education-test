<?php

namespace App\Http\Requests\Ad;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Countries\Package\Countries;

/**
 * Class StoreAdRequest
 * @property string title
 * @property string description
 * @property string fullPhoneNumber
 * @property string email
 * @property string endDate
 * @property string country
 * @property \File adFile
 * @property numeric lat
 * @property numeric lng
 * @package App\Http\Requests\Ad
 */
class StoreAdRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string|max:1000',
            'fullPhoneNumber' => 'required|string',
            'email' => 'required|email:rfc',
            'endDate' => 'required|date|after:yesterday',
            'country' => 'required|string',
            'lat' => 'required|numeric|between:-90,90',
            'lng' => 'required|numeric|between:-180,180',
            'adFile' => 'file|nullable|mimes:jpeg,png|max:10240',
        ];
    }

    /**
     * @return array
     */
    public function prepareRequest()
    {
        $data = parent::all();
        return [
            'title' => $data['title'],
            'user_id' => Auth::id(),
            'description' => $data['description'],
            'phone_number' => $data['fullPhoneNumber'],
            'end_date' => $data['endDate'],
            'img_src' => isset($data['adFile']) ? $data['adFile'] : null,
            'country_code' => Countries::where('name.common', $data['country'])->first()->iso_3166_1_alpha2,
            'latitude' => isset($data['lat']) ? $data['lat'] : null,
            'longitude' => isset($data['lng']) ? $data['lng'] : null,
        ];
    }
}
