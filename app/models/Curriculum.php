<?php

class Curriculum extends UuidModel {
	protected $fillable = [];
	protected $table = 'curriculums';
	public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }

    public function year_levels()
    {
        return $this->hasMany('YearLevel','curriculum_id');
    }
}