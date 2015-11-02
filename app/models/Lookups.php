<?php

class Lookups extends BaseModel {
	protected $fillable = [];

  public static function scopeKey($query, $key)
  {
    return $query->whereKey($key);
  }
}
