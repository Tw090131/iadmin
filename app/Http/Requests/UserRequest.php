<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        $rules = [
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|unique:users,email',
            'password' => 'required',
        ];
        if (request('id','')) {
            $rules['username'] = 'required|unique:users,username,'.$this->id;//第三个参数是，排除 post 过来的id
            $rules['email'] = 'required|unique:users,email,'.$this->id;//第三个参数是，排除 post 过来的id
        }else{
            $rules['username'] = 'required|unique:users,username';
            $rules['email'] = 'required|unique:users,email';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => '姓名不能为空',
            'username.required' => '用户名不能为空',
            'username.unique' => '用户名不能重复',
            'email.required' => '用户名不能为空',
            'email.unique' => '用户名不能重复',
            'password.required' => '用户名不能为空',
        ];
    }
}
