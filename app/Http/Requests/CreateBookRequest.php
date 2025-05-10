<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Book;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class CreateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'collector_id' => 'required|exists:collectors,id',
            'title' => 'required|string|max:255',
            'type' => 'required|in:' . implode(',', Book::getTypes()),
        ];
    }
}
