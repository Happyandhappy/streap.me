// Ensure the document is fully rendered before firing any of our jQuery code
$(document).ready(function(){
	
	// Declare jQuery objects
	var providerSelect = $("#provider");
	var providerSocialSelect = $('#social');
	var providerLabelSelect = $("#label");
	var nameInput = $("#name");

	// First, hide necessary items
	if (nameInput.is(":visible")) {
		nameInput.hide();
	};

	// Populate the provider select and show it
	populateSelect(providerSelect, providers);
	populateSelect(providerSocialSelect, social);
	providerSelect.show();

	// Calculate the number of elements in the providers array
	var providersCount = provider.length - 2;

	// Bind to the "change" event of the provider select
	providerSelect.change(function () {
		var selectedProviderIndex = $(this).val();
		if (selectedProviderIndex == "") {
			if (providerLabelSelect.is(":visible")) {
				providerLabelSelect.hide();
			};
			if (nameInput.is(":visible")) {
				nameInput.hide();
				nameInput.val("");
			};
			if(providerSocialSelect.is(":visible")){
				providerSocialSelect.hide();
			}
		} else if (selectedProviderIndex == 1) {
			providerSocialSelect.empty();
			populateSelect(providerSocialSelect, social);
			if(providerSocialSelect.is(":hidden"))
				providerSocialSelect.fadeIn();
			if (providerLabelSelect.is(":visible"))
				providerLabelSelect.hide();
			if (nameInput.is(":visible")){
				nameInput.hide();
				nameInput.val("");
			}
		} else if (selectedProviderIndex == 2){
			providerSocialSelect.empty();
			populateSelect(providerSocialSelect, music);
			if(providerSocialSelect.is(":hidden"))
				providerSocialSelect.fadeIn();
			if (providerLabelSelect.is(":visible"))
				providerLabelSelect.hide();
			if (nameInput.is(":visible")){
				nameInput.hide();
				nameInput.val("");
			}
		}
		else if (selectedProviderIndex >= 0 && selectedProviderIndex != 1 && selectedProviderIndex < providersCount){
			providerLabelSelect.empty();
			populateSelect(providerLabelSelect, providerLabels[selectedProviderIndex], false);
			if(providerLabelSelect.is(":hidden")) {
				providerLabelSelect.fadeIn();
			};
			if (providerSocialSelect.is(":visible"))
				providerSocialSelect.hide();
			if(nameInput.is(":visible")) {
				nameInput.hide();
				nameInput.val("");
			};
		} else if (selectedProviderIndex == providersCount) {
			if (providerSocialSelect.is(":visible"))
				providerSocialSelect.hide();

			if (providerLabelSelect.is(":visible")) {
				providerLabelSelect.hide();
			};
			if (nameInput.is(":hidden")) {
				nameInput.val("");
				nameInput.fadeIn();
			};
		}
	});

	providerSocialSelect.change(function(){
		var selectedProviderIndex = $(this).val();
		if (selectedProviderIndex == ""){
			if(providerLabelSelect.is(":visible"))
				providerLabelSelect.hide();
			if(nameInput.is(":visible")){
				nameInput.hide();
				nameInput.val("");
			}
		}else{
			providerLabelSelect.empty();
			if (providerSelect.val() == 1) populateSelect(providerLabelSelect, socialLabels[selectedProviderIndex], true);
			else populateSelect(providerLabelSelect, musicLabels[selectedProviderIndex], true);
			if(providerLabelSelect.is(":hidden")) {
				providerLabelSelect.fadeIn();
			};
			if(nameInput.is(":visible")) {
				nameInput.hide();
				nameInput.val("");
			};
		}
	});

	$("button[type=submit]").click(function(e){
		e.preventDefault();
		var platform = providerSelect.val();
		if (platform == 1 ){
			platform = social[providerSocialSelect.val()];
		}
		else if(platform == 2){
			platform = music[providerSocialSelect.val()];
		}
		else {
			platform = providers[providerSelect.val()];
		}

		var url = $("#url").val();
		console.log(platform + " : " + url);

		if (platform == "ASKfm") platform = "ask.fm";
		if (platform == "Vkontakte") platform = "vk.com";
		platform = platform.toLowerCase();
		console.log(url.includes(platform));
		if (url.includes(platform)|| providerSelect.val() >= 2){
			$("#url_alert").removeClass('show');
			console.log($("select[name=label]").val());
			console.log(type[$("select[name=label]").val()]);
			$('form[name=addform]').append("<input type='hidden' name='type' value=" + type[$("select[name=label]").val()] + ">");
			$('form[name=addform]').submit();
		}
		else 
			$("#url_alert").addClass('show');
	});

	$('#close_alert').click(function(){
		$("#url_alert").removeClass('show');
	});

	/* "plattform(youtube) -> youtube.com type(subscribe) -> /channel/ $socialMediaId"
		platform (snapchat) -> snapchat.com type(add) -> /add/ $socialMediaId
		platform (youtube) -> youtube.com type(like or subscribe-like) -> watch?v= $socialMediaId
	*/
});
