function showUsersList(options) {
  $('#users_list_wrapper').html(ajaxLoader);
  $.get(options.url,{},function(o) {
    $('#users_list_wrapper').html(o);
  });
}

function showUserRoleList(options) {
  $('#user_roles_list_wrapper').html(ajaxLoader);
  $.get(options.url,{},function(o) {
    $('#user_roles_list_wrapper').html(o);
  });
}

function showUserAccessList(options) {
  $('#user_access_list_wrapper').html(ajaxLoader);
  $.get(options.url,{},function(o) {
    $('#user_access_list_wrapper').html(o);
  });
}
