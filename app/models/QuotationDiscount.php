<?php

class QuotationDiscount extends \BaseModel {
	protected $guarded = [];

  protected static $logActivities = true;
  protected $attributes = [ 'amount'=> 0.00 ];

  public function quotation()
  {
      $this->belongsTo('Quotation');
  }

  public function quotationMaterials()
  {
    return $this->hasManyThrough('QuotationMaterial', 'Quotation',
      'id', 'quotation_id');
  }

  public function getModificationAttribute()
  {
    return $this->getLookupValue('discount_modification', $this->modification_id);
  }

  public function getTypeAttribute()
  {
    return $this->getLookupValue('discount_type', $this->type_id);
  }

  public function getAmountAttribute($value)
  {
    return (float) $value;
  }

  public function getDiscount($value, $lot = false)
  {
    // Percent
    if ($this->type_id == 1)
      return $value * ($this->amount / 100);

    if ($lot)
      return 0;

    return (float) $this->amount;
  }

  public function applyDiscount($value)
  {
    return $value - $this->getDiscount($value);
  }

}
