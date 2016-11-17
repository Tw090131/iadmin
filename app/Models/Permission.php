<?php

namespace App\Models;
use App\Models\ActionAttributeTrait;
use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    use ActionAttributeTrait;
    private $action;
    protected $fillable = [
        'name',
        'display_name',
        'description'
    ];

    public function __construct()
    {
        $this->action = config('admin.globals.permissions.action');
        //dd(config('admin.globals.permission.action'));
    }

    public function role()
    {
        return $this->belongsToMany('App\Models\Role');
    }
}
