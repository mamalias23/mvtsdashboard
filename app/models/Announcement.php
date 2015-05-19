<?php

class Announcement extends UuidModel {
	protected $fillable = [];

    public function receivers()
    {
        return $this->belongsToMany('User');
    }

}