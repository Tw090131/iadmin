<?php

namespace App\Models;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    use ActionAttributeTrait;
    protected $table = 'roles';
    private $action;
    protected $fillable = [
        'name',
        'display_name',
        'description',

    ];

    public function __construct()
    {
        $this->action = config('admin.globals.roles.action');
        //dd(config('admin.globals.permission.action'));
    }

    public function permission()
    {
        return $this->belongsToMany('App\Models\Permission','permission_role','role_id','permission_id')->withTimestamps();
    }
}
