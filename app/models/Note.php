<?php

class Note extends BaseModel {
	protected $guarded = [];

	public function notable()
	{
		return $this->morphTo();
	}

	/**
	* Extending save method to add author before save
	*
	* @return void
	* @author Gat
	**/
	public function save(array $options = array())
	{
	  // Add author if not set
	  if (!isset($this->author_id))
	    $this->author_id = Auth::user()->id;

	  parent::save($options);
	}

	public function author()
	{
		return $this->belongsTo('User', 'author_id');
	}
}
