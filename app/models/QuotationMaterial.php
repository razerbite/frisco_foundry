<?php
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;

class QuotationMaterial extends BaseModel implements StaplerableInterface {
  use EloquentTrait;

	protected $guarded = [];

  protected static $logActivities = true;

  protected $attributes = [
    'quantity' => 0,
    'price_per_unit' => 0
  ];

  public function quotation()
  {
    return $this->belongsTo('Quotation');
  }

  public function quotationDiscounts()
  {
    return $this->hasManyThrough('QuotationDiscount', 'Quotation',
      'id', 'quotation_id');
  }

  public function getQuantityAttribute($value)
  {
    return (float) $value;
  }

  public function getPricePerUnitAttribute($value)
  {
    // Price can't get lower when discounted
    if ($value < 0)
      $value = 0;

    return (float) $value;
  }

  public function getTotalAmountAttribute()
  {
    // Validate if there is amount
    $rules = [
      'quantity' => 'required',
      'price_per_unit' => 'required|numeric'
    ];

    $validator = Validator::make($this->toArray(), $rules);

    if ($validator->fails()) {
      return Redirect::route('quotations.approval', ['rfq'=>Str::slug($this->quotation->rfq_id)])
                ->with('materialMessage', 'Insufficient material data')
                ->with('alert-class', 'danger');
    }

    return $this->quantity * $this->price_per_unit;
  }

  public function __construct(array $attributes = array()) {
    $this->hasAttachedFile('file', [
        'styles' => [
          'medium' => '300x300',
          'thumb' => '100x100'
        ]
      ]);

    parent::__construct($attributes);
  }

}
