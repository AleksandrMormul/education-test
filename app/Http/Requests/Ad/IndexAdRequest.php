<?php

namespace App\Http\Requests\Ad;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class IndexAdRequest
 * @package App\Http\Requests\Ad
 */
class IndexAdRequest extends FormRequest
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
            'favorites' => 'nullable|in:0,1',
        ];
    }

    /**
     * @return bool
     */
    public function getFavorites(): bool
    {
        return (bool)$this->input('favorites', 0);
    }
}
