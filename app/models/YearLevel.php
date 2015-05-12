<?php

class YearLevel extends UuidModel {
    
    protected $table = 'year_levels';

    public function curriculum()
    {
        return $this->belongsTo('Curriculum', 'curriculum_id');
    }

}