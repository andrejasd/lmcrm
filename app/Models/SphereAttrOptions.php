<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SphereAttrOptions extends Model
{
    protected $table = 'sphere_attribute_options';

    protected $fillable = ['sphere_attr_id','ctype','_type', 'name','value', 'icon','position' ];

    public function attribute() {
        return $this->belongsTo('App\Models\SphereAttr','id','sphere_attr_id');
    }
}