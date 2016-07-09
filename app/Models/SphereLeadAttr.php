<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SphereLeadAttr extends Model
{
    protected $table = 'sphere_lead_attributes';
    protected $fillable = ['_type', 'label','icon','required', 'position' ];

    public function options() {
        return $this->hasMany('App\Models\SphereAttrOptions','sphere_attr_id','id')->where('ctype','=','lead')->where('_type','=','option')->orderBy('position');
    }
    public function validators() {
        return $this->hasMany('App\Models\SphereAttrOptions','sphere_attr_id','id')->where('ctype','=','lead')->where('_type','=','validate')->orderBy('position');
    }

    public function validatorRules() {
        $validators=array();
        $rules=$this->validators()->get();
        foreach($rules as $rec){
            $validators[$rec->name]=($rec->value)?$rec->value:true;
        }
        return $validators;
    }

    public function sphere() {
        return $this->belongsTo('App\Models\Sphere','id','sphere_id');
    }

}