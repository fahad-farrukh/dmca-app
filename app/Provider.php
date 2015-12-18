<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    public $timestamps = false;// remove default "created_at" & "updated_at" timestamps
    
    protected $fillable = [
        'name',
        'copyright_email'
    ];
}
