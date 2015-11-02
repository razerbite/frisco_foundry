<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;

use Zizaco\Entrust\HasRole;

class User extends BaseModel implements UserInterface, RemindableInterface, StaplerableInterface {
  use UserTrait, RemindableTrait, HasRole, EloquentTrait;

  protected $attributes = ['status'=> 1];

  protected $appends = ['full_name'];

  protected $fillable = [
    'username',
    'email',
    'password',
    'first_name',
    'middle_initial',
    'last_name',
    'company_name',
    'company_position',
    'status',
    'photo'
  ];

  public static $rules = [
    'username' => 'required|unique:users',
    'password' => 'required|confirmed',
    'email' => 'required|email|unique:users',
    'first_name' => 'required',
    'last_name' => 'required',
    'role' => 'required'
  ];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = array('password', 'remember_token');

  public function contactInfo()
  {
    return $this->morphOne('ContactInfo', 'contact');
  }

  public function getMiddleInitialAttribute($value)
  {
    // Append period if there isn't
    if (!empty($value) && !preg_match('/(\w+)\.$/', $value))
      return $value.'.';

    return $value;
  }

  public function getFullNameAttribute()
  {
    $fullName = $this->first_name . ' ';

    if (isset($this->middle_initial))
      $fullName .= $this->middle_initial . ' ';

    $fullName .= $this->last_name;

    return trim($fullName);
  }

  public function getStatusValueAttribute()
  {
    if ($this->status == 0)
      return 'Inactive';

    return 'Active';
  }

  public function getRoleAttribute()
  {
    return $this->roles()->first()->id;
  }

  public function __construct(array $attributes = array()) {
      $this->hasAttachedFile('photo', [
          'styles' => [
              'medium' => '300x300',
              'thumb' => '60x60'
          ],
          'default_url' => asset('images/photo.png')
      ]);

      parent::__construct($attributes);
  }

}
