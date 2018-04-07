var cookie_data = "";
function getCookie(url) {
	var name = url + "=";
	console.log(name);
	var decodedCookie = decodeURIComponent(document.cookie);
	console.log("decodedCookie : " + decodedCookie);
	var ca = decodedCookie.split(';');
	for(var i = 0; i <ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') {
			c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
			if (c.substring(name.length, c.length)=="")
				return "";	
			else return c.substring(name.length, c.length);
		}
	}
	return "";
}
/* function for get cookie information */
function setCookie(curl,cvalue) {

	var d = new Date();
	d.setTime(d.getTime() + (48*60*60*1000));
	var expires = "expires="+ d.toUTCString();
	cookie_data = cookie_data + cvalue + ",";
	if (cvalue === "")
		document.cookie = curl + "=" + ";"  + expires + ";path=/";
	else 
		document.cookie = curl + "=" + cookie_data + ";"  + expires + ";path=/";
}


// Ensure the document is fully rendered before firing any of our jQuery code
$(document).ready(function () {
	var actionCount = 0;
	var clickedCount = $('#clickCount').val();
	var urls = window.location.href.split('/');
	var url = urls[urls.length-1];
	cookie_data = getCookie(url);
	var checked = '<svg id="symbol" style="float: right;" class="svg-inline--fa fa-check-circle fa-w-16 fa-2x" aria-hidden="true" data-prefix="fas" data-icon="check-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z"></path></svg>';
	var unchecked = '<svg id="symbol" style="float: right;" class="svg-inline--fa fa-angle-right fa-w-8 fa-2x" aria-hidden="true" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg>';
	$('.action-button').each(function () {
		actionCount++;
	});

	if (clickedCount == actionCount) {
		$('#link-success-button').prop('disabled', false);
	};

	// Bind to the action button click events
	$('.action-button').on('click', processActionClick);

	// Open a link in a new window
	function processActionClick()
	{
		// Open the URL in a new window
		var actionUrl = $(this).data('url');
		window.open(actionUrl);
		

		// Disable the action button
		// $(this).prop('disabled', true);
		console.log($(this).attr('data-url'));
		// Increment the click counter
		clickedCount++;
		if (!cookie_data.includes($(this).attr('data-url')))
			setCookie(url, $(this).attr('data-url'));
		$(this).find("#symbol").remove();
		$(this).append(checked);
		console.log(cookie_data);
		// Check if the button is unlocked
		if (clickedCount == actionCount) {
			$('#link-success-button').prop('disabled', false);
		};
	}

	// Bind to the action button click events
	$('#link-success-button').click(function () {
		var successUrl = $(this).data('url');
		// setCookie(url , $(this).attr('id'));
		$('#link-success-button').prop('disabled', true);
		window.open(successUrl);
	});
});