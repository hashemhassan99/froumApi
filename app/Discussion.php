<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    protected $fillable =[
        'title','contentt','user_id','channel_id','slug'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function channel(){
        return $this->belongsTo(Channel::class);
    }
    public function replies(){
      return $this->hasMany(Reply::class);
    }
}
