<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PermissionRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;//一定要return true  不然不会验证的
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'display_name' => 'required',
        ];
        if (request('id','')) {
            $rules['name'] = 'required|unique:permissions,name,'.$this->id;//修改
        }else{
            $rules['name'] = 'required|unique:permissions,name';//添加
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => '权限不能为空',
            'name.unique' => '权限不能重复',
            'display_name.required' => '权限名称不能为空',
        ];
    }
}
