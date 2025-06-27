<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoogleSheetSubmission extends Model
{

    protected $connection = 'greyzone_consulting';
    protected $table = 'google_sheet_submissions';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $fillable = [
        'fullname',
        'email',
        'phone',
        'inquiry_type',
        'country',
        'accept_privacy',
        'date_now',
    ];

    protected $casts = [
        'accept_privacy' => 'integer',
        'date_now' => 'datetime',
    ];
}
