<?php

class Subject extends UuidModel {
	protected $fillable = [];

	public function year()
    {
        return $this->belongsTo('YearLevel', 'year_level_id');
    }

    public function department()
    {
        return $this->belongsTo('Department', 'department_id');
    }
}