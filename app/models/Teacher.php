<?php

class Teacher extends UuidModel {
	protected $fillable = [];

	public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }

    public function school_year()
    {
        return $this->belongsTo('SchoolYear', 'school_year_id');
    }

    public function subjects() 
    {
    	return $this->belongsToMany('Subject');
    }

    public function advisory()
    {
    	return $this->hasOne('Section');
    }

    public function department()
    {
        return $this->hasOne('Department');
    }
}