<?php

namespace App\ModelsView;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ViewUsers extends Model
{
    protected $table = 'vw_ms_users';
    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'created_at'  => 'datetime:Y-m-d H:i:s',
        'updated_at' =>     'datetime:Y-m-d H:i:s',
    ];
}
