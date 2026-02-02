<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyTask extends Model
{
    // These match the columns we created in your database migration
    protected $fillable = [
        'user_id', 
        'title', 
        'description', 
        'status', 
        'deadline'
    ];
    public function user()
{
    return $this->belongsTo(User::class);
}

}