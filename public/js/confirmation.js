function showCallbackMessage(options) {

	var alert_type  = options['alert_type'] || "";
	var message		= options['message'] || "No Message";
	var wrapper 	= options['wrapper'];

	$(wrapper).fadeIn(500);
	var content = '<div class="alert '+alert_type+'"><button type="button" class="close" data-dismiss="alert">&times;</button><b>'+message+'</b></div>';
	$(wrapper).html(content);
	$('html,body').animate({scrollTop: $(wrapper).offset().top},200);
}
