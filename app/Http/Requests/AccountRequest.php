<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AccountRequest extends Request
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
        $rules = [
            'openid'=>'required',
            'cid' => 'required',
            'create_of_area'=>'required',
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'openid.required' => config('admin.code.inituser.20001'),
            'cid.required' => config('admin.code.inituser.20002'),
            'create_of_area.required' => config('admin.code.inituser.20003'),
        ];
    }
}
