<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Credits extends Model {

    protected $table="credits";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'agent_id','buyed','earned'
    ];

    public function agent(){
        return $this->belongsTo('App\Models\Agent', 'id', 'agent_id');
    }

    public function getBalanceAttribute(){
        return $this->attributes['buyed']+$this->attributes['earned'];
    }

    public function setPaymentAttribute($value){
        if($this->attributes['buyed'] < $value) {
            $this->attributes['earned'] -= ($value - $this->attributes['buyed']);
            $this->attributes['buyed'] = 0;
        } else {
            $this->attributes['buyed'] -= $value;
        }
    }
}
