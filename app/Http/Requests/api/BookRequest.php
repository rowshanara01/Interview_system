<?php

namespace App\Http\Requests\api;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'max:255'],
            'author'      => ['required', 'max:255'],
            'description' => ['required'],
        ];
    }
}
