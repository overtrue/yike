<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MeRequest extends FormRequest
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
            //
        ];
    }

    /**
     * Get a subset containing the provided keys with values from the input data.
     *
     * @param  array|mixed  $keys
     * @return array
     */
    public function onlyThem($keys)
    {
        $keys = is_array($keys) ? $keys : func_get_args();

        return array_only($this->all(), $keys);
    }
}
