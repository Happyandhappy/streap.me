// Ensure the document is fully rendered before firing any of our jQuery code
$(document).ready( function() {

	// Available globals
	// const MIN_ACTIONS = 1;
	// const MAX_ACTIONS = 8;

	// Set some basic variables and constants
	var currentActionCount = 1;
	var currentActionIndex = 0;
	var addActionButton = $('#add-action-button');
	var removeActionButton = $('#remove-action-button');

	$('.provider-select').each(function () {
		populateSelect($(this), providers);
    });
    
    $('#action-0').fadeIn();
    $('.provider-select').on('change', function () {
        var providerId = $(this).attr('id').replace("actions-","");
        providerId = providerId.replace("-provider","");
        var provider = $(this);
        var providerSocialSelect = $("#actions-"+ providerId + "-social");
        var providerLabelSelect = $("#actions-" + providerId + "-label");
        var nameInput = $("#actions-" + providerId + "-name");
        console.log($(this).val());
        var selectedProviderIndex = $(this).val();
		if (selectedProviderIndex == "") {
			providerLabelSelect.addClass('hidden');
            nameInput.addClass('hidden');
            nameInput.val("");
            providerSocialSelect.addClass('hidden');
		} else if (selectedProviderIndex == 1) {
			providerSocialSelect.empty();
            populateSelect(providerSocialSelect, social);
            providerSocialSelect.removeClass('hidden');
            providerLabelSelect.addClass('hidden');
            nameInput.addClass('hidden');
            nameInput.val("");
			
		} else if (selectedProviderIndex == 2){
			providerSocialSelect.empty();
			populateSelect(providerSocialSelect, music);
			providerSocialSelect.removeClass('hidden');
			providerLabelSelect.addClass('hidden');
            nameInput.addClass('hidden');
    		nameInput.val("");
		}
		else if (selectedProviderIndex == 0){
			providerLabelSelect.empty();
			populateSelect(providerLabelSelect, providerLabels[selectedProviderIndex], false);
            providerLabelSelect.removeClass('hidden');
            providerSocialSelect.addClass('hidden');
			nameInput.addClass('hidden');
    		nameInput.val("");
			
		} else if (selectedProviderIndex == 3) {
			providerSocialSelect.addClass('hidden');
			providerLabelSelect.addClass('hidden');
            nameInput.val("");
            nameInput.removeClass('hidden');
		}
    });

    $('.social-select').on('click', function(){
        var socialId = $(this).attr('id').replace("-social","");
        socialId = socialId.replace("actions-","");
        var providerSelect = $('#actions-'+ socialId + "-provider");
        var socialLabelSelect = $(this);
        var providerLabelSelect = $("#actions-" + socialId + "-label");
        var nameInput = $("#actions-" + socialId + "-name");
        
        var selectedProviderIndex = $(this).val();
		if (selectedProviderIndex == ""){
            providerLabelSelect.addClass('hidden');
            nameInput.addClass('hidden');
            nameInput.val("");
		}else{
			providerLabelSelect.empty();
			if (providerSelect.val() == 1) populateSelect(providerLabelSelect, socialLabels[selectedProviderIndex], false);
			else populateSelect(providerLabelSelect, musicLabels[selectedProviderIndex], false);
            providerLabelSelect.removeClass('hidden');
            nameInput.addClass('hidden');
            nameInput.val("");
        }
    });


	// Bind a click listener to the add action button
	addActionButton.click(function () {
		currentActionCount++;
		currentActionIndex++;
		if (currentActionCount == MAX_ACTIONS) {
			addActionButton.prop('disabled', true);
		} else {
			removeActionButton.prop('disabled', false);
		};
		$('#action-'+currentActionIndex).fadeIn();
	});

	// Bind a click event listener to the remove action button
	removeActionButton.click(function () {
		$('#action-'+currentActionIndex).fadeOut();
		$('#action-'+currentActionIndex+'-provider').val('');
		$('#action-'+currentActionIndex+'-label').hide();
		$('#action-'+currentActionIndex+'-social').hide();
		$('#action-'+currentActionIndex+'-social').empty();
		$('#action-'+currentActionIndex+'-name').empty();
		$('#action-'+currentActionIndex+'-name').hide();
		$('#action-'+currentActionIndex+'-url').val('');
		currentActionCount--;
		currentActionIndex--;
		if (currentActionCount == MIN_ACTIONS) {
			removeActionButton.prop('disabled', true);
		} else {
			addActionButton.prop('disabled', false);
		};
	});


	$('button[type=submit]').click(function(event){
		event.preventDefault();
		var flag = true;
		for (var i = 0 ; i<8 ; i++){
			var providerSelect = $('#actions-'+ i + "-provider");
			var providerSocialSelect = $("#actions-"+ i + "-social");
			var providerLabelSelect = $("#actions-" + i + "-label");
			var nameInput = $("#actions-" + i + "-name");
			if (providerSelect.val()=="") continue;

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

			var url = $("#actions-" + i + "-url").val();
			console.log(platform + " : " + url);

			if (platform == "ASKfm") platform = "ask.fm";
			if (platform == "Vkontakte") platform = "vk.com";
			platform = platform.toLowerCase();
			
			console.log(url.includes(platform));


			if (url.includes(platform)|| providerSelect.val() >= 2){
				$("#url_alert").removeClass('show');
				console.log($("#actions-"+i+"-label").val());
				console.log(type[$("#actions-"+i + "-name").val()]);
				$('#action-' + i).append("<input type='hidden' name='actions[" + i + "][type]' value=" +type[$("#actions-"+i+"-label").val()] + ">");
			}else {
				$("#url_alert").addClass('show');
				flag = false;
			}
		}

		if (flag) $("form").submit();
	});

	$('#close_alert').click(function(){
		$("#url_alert").removeClass('show');
	});

});