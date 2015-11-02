<?php
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;

class Customer extends BaseModel implements StaplerableInterface {
  use EloquentTrait;

  protected $guarded = [];

  protected $attributes = array(
    'status' => 1
  );

  protected static $logActivities = true;


  public function contactInfo()
  {
    return $this->morphOne('ContactInfo', 'contact');
  }

  /**
   * Parse industry type field to display proper value from lookups table
   *
   * @return string
   * @author Gat
   **/
  public function getIndustryTypeValueAttribute()
  {
    return $this->getLookupValue('industry_type', $this->industry_type);
  }

  public function getStatusValueAttribute()
  {
    return $this->getLookupValue('customer_status', $this->status);
  }

  public function getAddressAttribute()
  {
    // Get contact info
    $contactInfo = $this->contactInfo;

    if (!isset($contactInfo))
      return null;

    $address = $contactInfo->address_1;

    if (isset($contactInfo->address_2))
      $address .= ', ' . $contactInfo->address_2;

    return $address;
  }

  /**
   * Extending save method to add encoder before save
   *
   * @return void
   * @author Gat
   **/
  public function save(array $options = array())
   {
      // Add encoder if not set
      if (!isset($this->secretary_id))
        $this->secretary_id = Auth::user()->id;

      parent::save($options);
   }

   public function quotations()
   {
    return $this->hasMany('Quotation');
   }

   public function representatives()
   {
    return $this->hasMany('CustomerRepresentative');
   }

   public function secretary()
   {
    return $this->belongsTo('User');
   }

   public function __construct(array $attributes = array()) {
    $this->hasAttachedFile('logo', [
        'styles' => [
          'medium' => '300x300',
          'thumb' => '100x100'
        ]
      ]);

    parent::__construct($attributes);
  }
}
