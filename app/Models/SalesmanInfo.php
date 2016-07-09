<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesmanInfo extends Model {

    protected $table="salesman_info";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lead_revenue','payment_revenue','sphere_id','agent_id','bill_id'
    ];


    public function salesman(){
        return $this->belongsTo('App\Model\Salesman','id','salesman_id');
    }

    public function agent(){
        return $this->hasOne('App\Models\Agent','id','agent_id');
    }

    public function sphere(){
        return $this->hasOne('App\Models\Sphere','id','sphere_id');
    }
}
