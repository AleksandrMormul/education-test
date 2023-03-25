<?php

namespace App\Http\Requests\Ad;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreAdRequest
 * @property string title
 * @property string description
 * @property integer price
 * @property string phone_number
 * @property string email
 * @property string endDate
 * @property string country_code
 * @property \File adFile
 * @property numeric latitude
 * @property numeric longitude
 * @package App\Http\Requests\Ad
 */
class UpdateAdRequest extends FormRequest
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
            'price' => 'required|integer',
            'phone_number' => 'required|string|regex:/\(?\+[0-9]{1,3}\)? ?-?[0-9]{1,3} ?-?[0-9]{3,5} ?-?[0-9]{4}( ?-?[0-9]{3})? ?(\w{1,10}\s?\d{1,6})?/',
            'email' => 'required|email:rfc',
            'end_date' => 'required|date|after_or_equal:today',
            'country_code' => 'required|string|max:2',
            'latitude' => 'numeric|between:-90,90',
            'longitude' => 'numeric|between:-180,180',
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
            'price',
            'phone_number',
            'end_date',
            'email',
            'country_code',
            'latitude',
            'longitude',
        ]);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'price' => (int)$this->price,
        ]);
    }
}
