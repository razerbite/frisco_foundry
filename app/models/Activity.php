<?php

class Activity extends BaseModel {

  protected $table = 'activity_log';

  /**
   * Get the user that the activity belongs to.
   *
   * @return object
   */
  public function user()
  {
    return $this->belongsTo('User');
  }

  /**
   * Create an activity log entry.
   *
   * @param  mixed
   * @return boolean
   */
  public static function log($data = array())
  {
    if (is_object($data)) $data = (array) $data;
    if (is_string($data)) $data = array('action' => $data);

    $activity = new static;
    $user = Auth::user();
    $activity->user_id = isset($user->id) ? $user->id : 0;

    if (isset($data['userId']))
      $activity->user_id = $data['userId'];

    $activity->content_id   = isset($data['contentId'])   ? $data['contentId']   : 0;
    $activity->content_type = isset($data['contentType']) ? $data['contentType'] : "";
    $activity->action       = isset($data['action'])      ? $data['action']      : "";
    $activity->description  = isset($data['description']) ? $data['description'] : "";
    $activity->details      = isset($data['details'])     ? $data['details']     : "";


    $activity->ip_address = Request::getClientIp();
    $activity->user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'No UserAgent';
    $activity->save();

    return true;
  }

  /**
   * Get the name of the user.
   *
   * @return string
   */
  public function getName()
  {
    $user = $this->user;
    if (empty($user))
      return "Unknown User";

    return $user->username;
  }

  /**
   * Get a shortened version of the user agent with title text of the full user agent.
   *
   * @return string
   */
  public function getUserAgentPreview()
  {
    return substr($this->user_agent, 0, 42) . (strlen($this->user_agent) > 42 ? '<strong title="'.$this->user_agent.'">...</strong>' : '');
  }


}
