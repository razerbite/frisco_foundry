<?php

class ContactNumber extends BaseModel {
	protected $guarded = [];

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'contact_nos';


  public function getTypeValueAttribute()
  {
    return $this->getLookupValue('contact_no_type', $this->type);
  }

  public function contactInfo()
  {
  	return $this->belongsTo('ContactInfo');
  }
}
