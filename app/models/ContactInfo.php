<?php

class ContactInfo extends BaseModel {
  protected $guarded = [];

  public function contact()
  {
    return $this->morphTo();
  }

  public function contactNumbers()
  {
  	return $this->hasMany('ContactNumber');
  }


}
