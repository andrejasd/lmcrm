<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpenLeads extends Model {

    protected $table="open_leads";


    public function lead(){
        return $this->hasMany('App\Models\Lead','id', 'lead_id');
    }

    public function agent(){
        return $this->hasMany('App\Models\Agent','id', 'agent_id');
    }

}
