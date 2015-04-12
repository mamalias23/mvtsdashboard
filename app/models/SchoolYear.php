<?php

class SchoolYear extends UuidModel {
	
    protected $table = 'school_year';

    public static function getActivated()
    {
        $_this = new self;
        $year = $_this->where('activated',1)->get();
        if(!$year)
            return 0;
        return $year->first();
    }

    public function records_personel()
    {
        return $this->hasMany('SchoolRecordPersonel', 'school_year_id');
    }
}