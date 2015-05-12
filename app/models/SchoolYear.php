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

    public function teachers()
    {
        return $this->hasMany('Teacher', 'school_year_id');
    }

    public function registrars()
    {
        return $this->hasMany('Registrar', 'school_year_id');
    }

    public function guards()
    {
        return $this->hasMany('Guard', 'school_year_id');
    }

    public function staffs()
    {
        return $this->hasMany('Staff', 'school_year_id');
    }
}