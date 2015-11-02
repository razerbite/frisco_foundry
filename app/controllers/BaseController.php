<?php

class BaseController extends \Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	// public $layout = 'layouts/master';

	/**
	 * Get values from lookups table
	 *
	 * @return array
	 * @author Gat
	 **/
	protected function lookupSelect($key)
	{
		return Lookups::key($key)->lists('value', 'key_id');
	}

}
