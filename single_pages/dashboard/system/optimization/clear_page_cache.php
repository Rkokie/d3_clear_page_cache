<?php  defined('C5_EXECUTE') or die('Access Denied'); ?>
<script type="text/javascript">
CCM_LAUNCHER_SITEMAP = 'search'; // we need this for when we are moving and copying
CCM_SEARCH_INSTANCE_ID = '<?php echo $searchInstance?>';
</script>

<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Clear Cache Per Page'), t('Search pages of your site and clear the cache of all selected pages'), false, false);?>

	<?php 
	$dh = Loader::helper('concrete/dashboard/sitemap');
	if ($dh->canRead()) { ?>
	
		<div class="ccm-pane-options" id="ccm-<?php echo $searchInstance?>-pane-options">
			<?php  Loader::PackageElement('search_form_advanced', 'd3_clear_page_cache', array('columns' => $columns, 'searchInstance' => $searchInstance, 'searchRequest' => $searchRequest, 'searchType' => 'DASHBOARD')); ?>
		</div>
	
		<?php  Loader::PackageElement('search_results', 'd3_clear_page_cache', array('columns' => $columns, 'searchInstance' => $searchInstance, 'searchType' => 'DASHBOARD', 'pages' => $pages, 'pageList' => $pageList, 'pagination' => $pagination)); ?>
	
	<?php  } else { ?>
		<div class="ccm-pane-body">
			<p><?php echo t("You must have access to the dashboard sitemap to search pages.")?></p>
		</div>	
	
	<?php  } ?>

<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false); ?>