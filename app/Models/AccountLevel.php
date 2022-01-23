<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SecPermission;
class AccountLevel extends Model
{
    //

    public function Roles()
    {
      return $this->belongsToMany('App\Models\SecGroup','account_levels_sec_groups_relationship');
    }
    public function hasRole($role)
    {
      return $this->Roles()->where('name',$role)->count()>0;
    }
    public function hasRoles($arrRoles)
    {
        return $this->Roles()->whereIn('groupkey',(array)$arrRoles)->count();
    }
    public function Accounts()
    {
        return $this->hasMany('App\User')->withTrashed();
    }
    public function allow($ctrl,$action)
    {
        $ids=$this->Roles()->pluck('sec_groups.id')->toArray();
        return SecPermission::whereIn('sec_group_id',$ids)->where('controller',$ctrl)->where('action','Like','%'.$action.'%')->get();
    }
}
