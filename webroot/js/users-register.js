// Ensure the document is fully rendered before firing any of our jQuery code
$(document).ready(function(){

	// Bind click events
	$('#terms-of-service-button').click(function (event) {
		event.preventDefault();
		$('#termsOfServiceModalLong').modal();
	});

	$('#privacy-policy-button').click(function (event) {
		event.preventDefault();
		$('#privacyPolicyModalLong').modal();
	});

});