// Ensure the document is fully rendered
$(document).ready( function() {

	var showChangeUsernameButton = $('#showChangeUsername');
	var changeUsernameContainer = $('#changeUsernameContainer');
	var showChangePasswordButton = $('#showChangePassword');
	var changePasswordContainer = $('#changePasswordContainer');

	showChangeUsernameButton.click(function () {
		showChangeUsernameButton.prop('disabled', true);
		showChangePasswordButton.prop('disabled', false);
		changePasswordContainer.hide();
		changeUsernameContainer.fadeIn();
	});

	showChangePasswordButton.click(function () {
		showChangeUsernameButton.prop('disabled', false);
		showChangePasswordButton.prop('disabled', true);
		changeUsernameContainer.hide();
		changePasswordContainer.fadeIn();
	});

});