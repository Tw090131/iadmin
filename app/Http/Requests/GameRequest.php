<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class GameRequest extends Request
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
            'game_name'=>'required|unique:game,game_name',
          //  'cp_uid' => 'required',
        ];
        if (request('id','')) {
            $rules['game_name'] = 'required|unique:game,game_name,'.$this->id;//第三个参数是，排除 post 过来的id
        }else{
            $rules['game_name'] = 'required|unique:game,game_name';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'game_name.required' => '游戏名称不能为空',
            'game_name.unique' => '游戏名称不能重复',

        ];
    }
}
