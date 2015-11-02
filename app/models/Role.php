<?php

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
	protected $guarded = [];

  /**
   * Check permission
   *
   * @return boolean
   * @author Gat
   **/
  public function can($permission)
  {
    return in_array($permission->id, $this->perms->lists('id'));
  }

}
