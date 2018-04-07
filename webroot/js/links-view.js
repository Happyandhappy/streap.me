// Ensure the document is fully rendered before firing any of our jQuery code

$(document).ready(function () {
	var urls = window.location.href.split('/');
	var url = urls[urls.length-1];

	function clearCookie(url) {
		var d = new Date();
		d.setTime(d.getTime() + (48*60*60*1000));
		var expires = "expires="+ d.toUTCString();
		document.cookie = curl + "=" + ";"  + expires + ";path=/";
	}

	$('.btn-danger').click(function(e){
		clearCookie(url);
	});
	
	$('#linkNameModalSubmitButton').click(function (event) {
		clearCookie(url)
		$('#linkNameModalForm').submit();
	});

	$('#linkNameModalTrigger').click(function (event) {
		event.preventDefault();
		$('#linkNameModal').modal();
	});


	$('#linkHeadingModalSubmitButton').click(function (event) {
		clearCookie(url)
		$('#linkHeadingModalForm').submit();
	});

	$('#linkHeadingModalTrigger').click(function (event) {
		event.preventDefault();
		$('#linkHeadingModal').modal();
	});


	$('#linkButtonLabelModalSubmitButton').click(function (event) {
		clearCookie(url)
		$('#linkButtonLabelModalForm').submit();
	});

	$('#linkButtonLabelModalTrigger').click(function (event) {
		event.preventDefault();
		$('#linkButtonLabelModal').modal();
	});


	$('#actionName0ModalSubmitButton').click(function (event) {
		clearCookie(url)
		$('#actionName0ModalForm').submit();
	});

	$('#actionName0ModalTrigger').click(function (event) {
		event.preventDefault();
		$('#actionName0Modal').modal();
	});


	$('#actionName1ModalSubmitButton').click(function (event) {
		clearCookie(url)
		$('#actionName1ModalForm').submit();
	});

	$('#actionName1ModalTrigger').click(function (event) {
		event.preventDefault();
		$('#actionName1Modal').modal();
	});


	$('#actionName2ModalSubmitButton').click(function (event) {
		clearCookie(url)
		$('#actionName2ModalForm').submit();
	});

	$('#actionName2ModalTrigger').click(function (event) {
		event.preventDefault();
		$('#actionName2Modal').modal();
	});


	$('#actionName3ModalSubmitButton').click(function (event) {
		clearCookie(url)
		$('#actionName3ModalForm').submit();
	});

	$('#actionName3ModalTrigger').click(function (event) {
		event.preventDefault();
		$('#actionName3Modal').modal();
	});


	$('#actionReorderModalSubmitButton').click(function (event) {
		clearCookie(url)
		$('#actionReorderModalForm').submit();
	});

	$('#actionReorderModalTrigger').click(function (event) {
		event.preventDefault();
		$('#actionReorderModal').modal();
	});


	$('#sortable-action-list').sortable({
		axis: 'y'
	});
	$('#sortable-action-list').disableSelection();

});