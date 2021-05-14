<?php

namespace App\Http\Requests\Ad;

use Illuminate\Foundation\Http\FormRequest;

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
            'email' => 'required|email:rfc,dns',
            'endDate' => 'required|string',
            'country' => 'required|string',
            'lat' => 'numeric|nullable',
            'lng' => 'numeric|nullable',
            'adFile' => 'file|nullable',
        ];
    }
}
