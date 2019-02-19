<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DatasetNotification extends Model
{
    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'sent' => false,
    ];
    
    protected $fillable = ['dataset_id','user_id','email'];
    
    //
}
