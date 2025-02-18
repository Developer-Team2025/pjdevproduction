<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OurTeam extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['team_id', 'fullname', 'job_position'];

    /**
     * Define a relationship between OurTeam and FileUpload.
     * 
     * This method establishes a one-to-one (or many-to-one) relationship 
     * where each team member may have an associated profile image stored in the FileUpload model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teamProfileImages()
    {
        return $this->belongsTo(FileUpload::class, 'team_id', 'target_id');
    }
}
