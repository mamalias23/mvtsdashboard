<?php

class Department extends UuidModel {
	protected $fillable = [];

	public function curriculum()
    {
        return $this->belongsTo('Curriculum', 'curriculum_id');
    }
}