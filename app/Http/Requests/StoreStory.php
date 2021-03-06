<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStory extends FormRequest
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
        $rules = [];

        if($this->input('fileType') =='video'){
            $rules['story'] = ['mimetypes:video/avi,video/mpeg,video.quicktime'];
        } else{
            $rules['story'] = ['required', 'image'];
        }

        return $rules;
    }
}
