<?php

/**
* Base model to add model methods
*/
class BaseModel extends \Eloquent
{
	public static $rules = [];

  protected static $logActivities = false;

	/**
	 * Get values from lookups table
	 * and store it in cache to fix N+1 problem
	 *
	 * @return string
	 * @author Gat
	 **/
	public static function getLookupValue($key, $id)
	{

		if (Cache::has("{$key}_{$id}")) {
			return Cache::get("{$key}_{$id}");
		}

		$lookupValue = Lookups::whereKey($key)
									->whereKeyId($id)->first()
									->value;

		// Set expiry for 1 day
		$duration = Carbon::now()->addDay();

		// Store in cache
		Cache::put("{$key}_{$id}", $lookupValue, $duration);

		return $lookupValue;
	}

  /**
   * Get validation rules and take care of own id on update
   * @param null $id
   * @return array
   */
  public static function getValidationRules($id = null)
  {
      $rules = static::$rules;

      if($id === null)
      {
          return $rules;
      }

      array_walk($rules, function(&$rules, $field) use ($id)
      {
          if(!is_array($rules))
          {
              $rules = explode("|", $rules);
          }

          foreach($rules as $ruleIdx => $rule)
          {
              // get name and parameters
              @list($name, $params) = explode(":", $rule);

              // only do someting for the unique rule
              if(strtolower($name) != "unique") {
                  continue; // continue in foreach loop, nothing left to do here
              }

              $p = array_map("trim", explode(",", $params));

              // set field name to rules key ($field) (laravel convention)
              if(!isset($p[1])) {
                  $p[1] = $field;
              }

              // set 3rd parameter to id given to getValidationRules()
              $p[2] = $id;

              $params = implode(",", $p);
              $rules[$ruleIdx] = $name.":".$params;
          }
      });

      return $rules;
  }

    // Load events
  public static function boot()
  {
    parent::boot();

    if (! static::$logActivities) return true;

    // Attach to created event
    static::created(function($model){
      Activity::log([
        'contentId' => $model->id,
        'contentType' => get_class($model),
        'action' => 'Created',
        'description' => 'Created ' . get_class($model)
      ]);
    });

    static::deleted(function($model){
      Activity::log([
        'contentId' => $model->id,
        'contentType' => get_class($model),
        'action' => 'Deleted',
        'description' => 'Deleted ' . get_class($model)
      ]);
    });

    static::updating(function($model){
      $details = '';

      // Get changes in model
      foreach($model->getDirty() as $attribute => $value){
          $original = $model->getOriginal($attribute);
          $details .= "$attribute: from '$original' to '$value'\r\n";
      }

      // Do not log if there's no changes
      if (! empty($details)) {
        Activity::log([
          'contentId' => $model->id,
          'contentType' => get_class($model),
          'action' => 'Updated',
          'description' => 'Updated ' . get_class($model),
          'details' => trim($details)
        ]);
      }

    });

  }

}
