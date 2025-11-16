<?php

namespace App\Http\Requests\Citizen;

use Illuminate\Foundation\Http\FormRequest;

class StoreIncidentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'category_id' => 'required|exists:categories,id',

            'address_line1' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'sometimes|string|max:100',

            // Correct media rules
            'media' => 'nullable',
            'media.*' => 'file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:20480',
        ];
    }
}
