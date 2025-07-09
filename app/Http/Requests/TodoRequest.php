<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'email' => 'required|email',
            'due_date' => 'required|date|after:now',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Todo title is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'due_date.required' => 'Due date is required.',
            'due_date.after' => 'Due date must be in the future.',
        ];
    }
}