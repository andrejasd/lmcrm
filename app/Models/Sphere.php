<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sphere extends Model
{
    protected $table = 'spheres';

    protected $fillable = ['name','openLead','minLead','table_name' ,'status'];

    public function scopeActive($query,$status = true) {
        return $query->where('status','=',($status)?true:false);
    }

    public function attributes() {
        return $this->hasMany('App\Models\SphereAttr','sphere_id','id')->orderBy('position');
    }

    public function leadAttr() {
        return $this->hasMany('App\Models\SphereLeadAttr','sphere_id','id')->orderBy('position');
    }

    public function leads(){
        return $this->hasMany('App\Models\Lead','sphere_id', 'id');
    }

    public function statuses() {
        return $this->hasMany('App\Models\SphereStatuses','sphere_id','id')->orderBy('position');
    }

    public function agents(){
        return $this->hasManyThrough('\App\Models\Agent','\App\Models\AgentSphere','sphere_id','agent_id');
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($group) { // before delete() method call
            $group->attributes()->delete();
            $group->leadAttr()->delete();
        });
    }
}