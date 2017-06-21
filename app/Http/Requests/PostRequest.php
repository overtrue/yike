<?php

namespace App\Http\Requests;

use App\Post;
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

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => '文章标题必填。',
            'title.unique'   => [
                'error' => '文章标题已存在。',
                'slug' => $this->title ? Post::where('title', $this->title)->where('user_id', auth()->id())->first()->slug ?? '' : '',
            ],
            'content.required' => '文章内容必填。',
        ];
    }
}
