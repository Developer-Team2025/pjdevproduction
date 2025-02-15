<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['target_id', 'filename', 'file_location'];

    /**
     * Define a relationship between FileUpload and OurTeam.
     * 
     * This method establishes a one-to-one relationship where
     * each file upload may be associated with a specific team member.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ourTeams()
    {
        return $this->hasOne(OurTeam::class, 'target_id', 'team_id');
    }
}
