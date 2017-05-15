<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
                return [];
            case 'POST':
                return [
                    'title' => 'required|unique:posts,title,NULL,id,user_id,' . auth()->id(),
                    'content' => 'required|min:1',
                ];
            case 'PUT':
            case 'PATCH':
                return [
                    'title' => 'required|unique:posts,title,' . $this->id . ',id,user_id,' . auth()->id(),
                    'content' => 'required|min:1',
                ];
            default:break;
        }
    }
}
