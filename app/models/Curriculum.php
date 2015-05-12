<?php

class Curriculum extends UuidModel {
	protected $fillable = [];
	protected $table = 'curriculums';
	public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }
}