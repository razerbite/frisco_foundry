<?php
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;

class Quotation extends BaseModel implements StaplerableInterface {
  use EloquentTrait;

	protected $guarded = [];

  protected static $logActivities = true;

  /**
   * Set default attributes
   *
   * @var array
   */
  protected $attributes = [
    'status' => 1
  ];

  protected $appends = ['materials_price'];

  public function customer()
  {
    return $this->belongsTo('Customer');
  }

  public function secretary()
  {
    return $this->belongsTo('User');
  }

  public function technical()
  {
    return $this->belongsTo('User');
  }

  public function executive()
  {
    return $this->belongsTo('User');
  }

  public function notes()
  {
    return $this->morphMany('Note', 'notable');
  }

  public function attns()
  {
    return $this->belongsToMany('CustomerRepresentative',
      'quotation_attns', 'quotation_id', 'customer_representative_id'
      )->withTimestamps();
  }

  public function scopes()
  {
    return $this->hasMany('QuotationScope');
  }

  public function materials()
  {
    return $this->hasMany('QuotationMaterial');
  }

  public function discounts()
  {
    return $this->hasMany('QuotationDiscount');
  }

  public function getAttnAttribute()
  {
    if (!$this->attns->isEmpty())
      return $this->attns->first()->id;
  }

  public function getStatus($status)
  {
    if ($status == 0)
      return 'Cancelled';

    return $this->getLookupValue('quotation_status', $status);
  }

  public function getStatusValueAttribute()
  {
    return $this->getStatus($this->status);
  }

  public function getUnitOfMeasurementValueAttribute()
  {
    return $this->getLookupValue('unit_of_measurement', $this->unit_of_measurement);
  }

  public function getTypeOfWorkValueAttribute()
  {
    return $this->getLookupValue('type_of_work', $this->type_of_work_id);
  }

  public function getMaterialsPriceAttribute()
  {
    if ($this->materials->isEmpty())
      return null;

    $total = 0;

    foreach ($this->materials as $material) {
      $total += $material->total_amount;
    }

    return $total;
  }

  public function getLotDiscountAttribute()
  {
    $amount = $this->materials_price + $this->price;

    if (!$this->vat_excempt)
      $amount = $this->materials_price_with_tax;

    $lotDiscount = 0;
    foreach ($this->discounts as $discount) {
      // lot price discount
      if ($discount->modification_id == 1)
        $lotDiscount += $discount->getDiscount($amount);
    }

    return $lotDiscount;
  }

  public function getMaterialsPriceWithTaxAttribute()
  {
    return $this->materials_price /*+ $this->materials_tax*/;
  }

  protected function getTax($price)
  {
    return ($price * 0.12);
  }

  public function getMaterialsTaxAttribute()
  {
    
      // Add price; for quick total computation
      $price = /*$this->materials_price +*/ $this->price;
      return $this->getTax($price);
    

    return 0;
  }

  public function __construct(array $attributes = array()) {
    $this->hasAttachedFile('signature', [
      'styles' => [
        'medium' => '300x300',
        'thumb' => '100x100'
      ]
    ]);

    parent::__construct($attributes);
  }

}
