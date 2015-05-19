<?php

class Section extends UuidModel {
	protected $fillable = [];

	public function year()
    {
        return $this->belongsTo('YearLevel', 'year_level_id');
    }

    public function curriculum()
    {
        return $this->belongsTo('Curriculum', 'curriculum_id');
    }

    public function adviser()
    {
    	return $this->belongsTo('Teacher', 'teacher_id');
    }

    public function students()
    {
        return $this->hasMany('Student', 'section_id');
    }
}