<?php

class Section extends UuidModel {
	protected $fillable = [];

	public function year()
    {
        return $this->belongsTo('YearLevel', 'year_level_id');
    }
}