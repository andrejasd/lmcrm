<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentSphere extends Model {

    protected $table="agent_sphere";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'agent_id','sphere_id'
    ];


    public function lead(){
        return $this->hasMany('App\Models\Lead','id','agent_id');
    }

    public function sphere(){
        return $this->hasMany('App\Models\Sphere','id','sphere_id');
    }

}
