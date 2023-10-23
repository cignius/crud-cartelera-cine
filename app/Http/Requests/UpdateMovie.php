<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMovie extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'max:255',
            'director' => 'max:255',
            'duration' => 'max:10',
            'classification' => 'max:5',
            'start_exhibition' => 'date',
            'finish_exhibition' => 'date',
            'image' => 'dimensions:min_width=1024,min_height=720|mimes:jpeg,png,jpg,gif|max:10240', //10MB
        ];
    }
}
