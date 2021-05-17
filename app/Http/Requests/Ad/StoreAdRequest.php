<?php

namespace App\Http\Requests\Ad;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreAdRequest
 * @property string title
 * @property string description
 * @property string phone_number
 * @property string email
 * @property string endDate
 * @property string country_code
 * @property \File adFile
 * @property numeric latitude
 * @property numeric longitude
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
            'phone_number' => 'required|string',
            'email' => 'required|email:rfc',
            'end_date' => 'required|date|after:yesterday',
            'country_code' => 'required|string|max:2',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'adFile' => 'file|nullable|mimes:jpeg,png|max:10240',
        ];
    }

    /**
     * @return array
     */
    public function getPayload(): array
    {
        return $this->only([
            'title',
            'description',
            'phone_number',
            'end_date',
            'country_code',
        ]);
    }
}
