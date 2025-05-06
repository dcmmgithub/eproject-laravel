<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArtistReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Since login is optional for reviews, we can return true here.
     * Authentication will be checked conditionally in the controller.
     */
    public function authorize(): bool
    {
        return true; // Anyone can attempt to submit (auth checked later if needed)
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Renamed field, adjust rules
            'comment' => ['required', 'string', 'min:1', 'max:2000'],
            // Added rating validation (e.g., must be integer between 1 and 5)
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'name' => ['required', 'string', 'max:255'], // <-- Add validation for name
        ];
    }

    /**
     * Get custom messages for validator errors.
     * Optional but helpful.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'rating.integer' => 'The rating must be a whole number.',
            'rating.min' => 'The rating must be at least 1.',
            'rating.max' => 'The rating cannot be greater than 5.',
        ];
    }
}