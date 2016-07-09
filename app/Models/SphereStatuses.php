<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SphereStatuses extends Model
{
    protected $table = 'sphere_statuses';
    protected $fillable = ['stepname', 'minmax','percent', 'position' ];

    public function sphere() {
        return $this->belongsTo('App\Models\Sphere','id','sphere_id');
    }

}