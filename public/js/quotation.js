function showQuotationList(options) {
  $('#quotation_list_wrapper').html(ajaxLoader);
  $.get(options.url,{},function(o) {
    $('#quotation_list_wrapper').html(o);
  });
}

function hasValue(variable) {
	return ($.trim(variable).length > 0 ? true : false);
}