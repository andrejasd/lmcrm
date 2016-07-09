<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentInfo extends Model {

    protected $table="agent_info";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lead_revenue','payment_revenue',/*'sphere_id'*/
    ];


    public function agent(){
        return $this->hasOne('App\Models\Agent','id','agent_id');
    }

}
