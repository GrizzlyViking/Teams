<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'owner_id'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
