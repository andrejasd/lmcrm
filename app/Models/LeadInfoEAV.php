<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class LeadInfoEAV extends Model {

    protected $table="lead_info";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lead_id','lead_attr_id', 'value',
    ];

}
