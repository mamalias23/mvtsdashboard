<?php

class Activity extends UuidModel {
	protected $fillable = [];
    protected $dates = ['starts_at','ends_at'];

//    public function getStartsAtAttribute()
//    {
//        return $this->startsAt->toRfc3339String();
//    }
}