<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use ActionAttributeTrait;
    private $action;
    protected $fillable = [
        'name',
        'username',
        'email',
        'password'
    ];

    public function __construct()
    {
        $this->action = config('admin.globals.users.action');
        //dd(config('admin.globals.permission.action'));
    }
}
