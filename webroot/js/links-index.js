// Ensure the document is fully rendered before firing any of our jQuery code

$(document).ready(function () {

	// Set some URL's
	const STATS_BLOCK_URL = '/links/index-stats-block';
	const LINKS_TABLE_URL = '/links/index-links-table';

	// Show the Newly created link alert if in the dom
	$('#linkCreationModal').modal();

	// Bind a click event to the copy button
	$('#alert-link-copy-button').click(function () {
		$('#alert-link-share-url-input').select();
		document.execCommand("Copy");
		$('#linkCreationModal').modal('hide');
	})

	// Get an updated table based on a given cake pagination url
	function getStatsBlock()
	{
		$.ajax({
			type: 'get',
			url: STATS_BLOCK_URL,
			beforeSend: function (xhr) {
				xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			},
			success: function (response) {
				if (response) {
					$('#stats-container').html(response);
				};
			},
			error: function (error) {
				console.log(error);
			}
		});
	};

	// Update the values on document ready a single time
	getStatsBlock();

	// Set the timer to refresh the stats
	setInterval(getStatsBlock, 10000);

	// Get an updated table based on a given cake pagination url
	function getLinksTable(targetUrl)
	{
		$.ajax({
			type: 'get',
			url: targetUrl,
			beforeSend: function (xhr) {
				xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			},
			success: function (response) {
				if (response) {
					unBindClickEvents();
					$('#link-table-container div.hidden').addClass('loading');
					$('#link-table-container').html(response);
					$('#link-table-container div.hidden').fadeIn('fast');
					bindClickEvents();
				};
			},
			error: function (error) {
				console.log(error);
			}
		});
	};

	function bindClickEvents() {
		$('.ajax-link').on('click', function (event) {
			event.preventDefault();
			$('#dynamic-table-container').fadeTo('fast', 0.35);
			getLinksTable($(this).attr('rel'));
		});
		$('.share-button').on('click', function (event) {
			event.preventDefault();
			$('#share-url-input').val($(this).data('share-url'));
			$('#shareModal').modal();
		});
	}

	function unBindClickEvents() {
		$('.ajax-link').off();
		$('.share-button').off();
	}

	// Generate the table on document load
	getLinksTable(LINKS_TABLE_URL);

	// Bind a click event to the copy button
	$('#copy-button').click(function () {
		$('#share-url-input').select();
		document.execCommand("Copy");
		$('#shareModal').modal('hide');
	})

});