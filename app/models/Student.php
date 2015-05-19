<?php

class Student extends UuidModel {
	protected $fillable = [];

    public function user()
    {
        return $this->belongsTo('User', 'user_id')->orderBy('last_name');
    }

    public function school_year()
    {
        return $this->belongsTo('SchoolYear', 'school_year_id');
    }

    public function section()
    {
        return $this->belongsTo('Section', 'section_id');
    }
}