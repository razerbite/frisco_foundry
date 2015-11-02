<?php

class CustomerRepresentative extends BaseModel {
	protected $guarded = [];
  //protected $table = 'customer_representatives';
  public function customer()
  {
    $this->belongsTo('Customer');
  }


  public function contactInfo()
  {
    return $this->morphOne('ContactInfo', 'contact');
  }


  public function getFullNameAttribute()
  {
    $fullName = $this->first_name . ' ';

    if (isset($this->middle_initial))
      $fullName .= $this->middle_initial . ' ';

    $fullName .= $this->last_name;

    return trim($fullName);
  }

}
