<?php

class Announcement extends UuidModel {
	protected $fillable = [];

    public function receivers()
    {
        return $this->belongsToMany('User');
    }

    public function created_by()
    {
        return User::find($this->sender_id);
    }

}