<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Request;
use Illuminate\Foundation\Http\FormRequest;

class StoreMoviePost extends FormRequest
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
            'title' => 'required|max:255',
            'director' => 'required|max:255',
            'duration' => 'required|max:10',
            'classification' => 'required|max:5',
            'start_exhibition' => 'required|date',
            'finish_exhibition' => 'required|date',
            'image' => 'required|dimensions:min_width=1024,min_height=720|mimes:jpeg,png,jpg,gif|max:10240', //10MB
        ];
    }
}
