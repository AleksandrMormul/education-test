<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateInvoiceRequest
 * @package App\Http\Requests\Api
 * @property string currency_code
 * @property numeric value
 * @property integer ad_id
 */
class CreateInvoiceRequest extends FormRequest
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
            'value' => 'required|numeric',
            'ad_id' => 'required|integer',
        ];
    }
}
