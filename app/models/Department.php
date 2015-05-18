<?php

class Department extends UuidModel {
	protected $fillable = [];

	public function curriculum()
    {
        return $this->belongsTo('Curriculum', 'curriculum_id');
    }

    public function head()
    {
        return $this->belongsTo('Teacher', 'teacher_id');
    }
}