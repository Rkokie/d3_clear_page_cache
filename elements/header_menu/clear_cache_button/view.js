$(function() {
	ccm_sitemapClearCache = function(searchInstance) {
		$("#ccm-" + searchInstance + "-clear-cache-form").ajaxSubmit(function(resp) {
			
			ccm_parseJSON(resp, function() {
				resp = jQuery.parseJSON(resp);
				
				if (resp.success.length >0) {
					ccmAlert.hud(resp.success,2000,'success');
				}

				jQuery.fn.dialog.closeTop();
				
				ccm_activateSearchResults(searchInstance);
				$("#ccm-" + searchInstance + "-advanced-search").ajaxSubmit(function(resp) {
					ccm_parseAdvancedSearchResponse(resp, searchInstance);
				});
			});
		});
	}
	
	$("#ccm-page-edit-nav-clear_cache_button").dialog();
});