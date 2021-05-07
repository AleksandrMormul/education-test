<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateAdRequest
 * @property string title
 * @property string description
 * @property string phone
 * @property string email
 * @property string endDate
 * @property \File adFile
 * @package App\Http\Requests
 */
class CreateAdRequest extends FormRequest
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
            'description' => 'required|string|max:255',
            'phone' => 'required|string',
            'email' => 'required|email:rfc,dns',
            'endDate' => 'required|string',
            'country' => 'required|string',
            //'adFile' => 'file|nullable',
        ];
    }
}
