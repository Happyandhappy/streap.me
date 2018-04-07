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
	var _clicked = cookie_data.split(",");

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
		$(this).prop('disabled', true);
		console.log($(this).attr('data-url'));
		// Increment the click counter
		clickedCount++;
		setCookie(url, $(this).attr('data-url'));
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