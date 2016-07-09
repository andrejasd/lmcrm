<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model {

    protected $table="customers";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone'
    ];


    public function lead(){
        return $this->hasMany('App\Models\Lead','customer_id', 'id');
    }
}
