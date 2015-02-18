$(document).ready(function() {
	$("#btn-d3-clear-page-cache").live('click', function() {
		var instance_id = $(this).attr('data-instance-id');
		cIDstring = '';
		
		
		$("td.ccm-" + instance_id + "-list-cb input[type=checkbox]:checked").each(function() {
			cIDstring=cIDstring+'&cID[]='+$(this).val();
		});
		
		if(cIDstring.length == 0){
			return false;
		}
		
		jQuery.fn.dialog.open({
			width: 500,
			height: 400,
			modal: false,
			appendButtons: true,
			href: CCM_TOOLS_PATH + '/../packages/d3_clear_page_cache/clear_cache?' + cIDstring + '&searchInstance=' + instance_id,
			title: 'Clear Page Cache'				
		});
		
		$(this).get(0).selectedIndex = 0;
	});
	
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
});