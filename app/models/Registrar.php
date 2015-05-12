<?php

class Registrar extends UuidModel {
	protected $fillable = [];

	public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }

    public function school_year()
    {
        return $this->belongsTo('SchoolYear', 'school_year_id');
    }
}