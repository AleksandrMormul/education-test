<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SubscriptionRequest
 * @package App\Http\Requests\Api
 */
class SubscriptionRequest extends FormRequest
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
            'is_subscribe' => 'nullable|in:0,1',
        ];
    }

    /**
     * @return bool
     */
    public function addSubscribe(): bool
    {
        return (bool)$this->input('is_subscribe', 0);
    }
}
