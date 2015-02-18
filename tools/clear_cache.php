<?php  
defined('C5_EXECUTE') or die("Access Denied.");
$u = new User();
$form = Loader::helper('form');
$sh = Loader::helper('concrete/dashboard/sitemap');
if (!$sh->canRead()) {
	die(t('Access Denied'));
}

if ($_POST['task'] == 'clear_cache') {
	$json['error'] = "false";
	$json['success'] = "false";
	
	$i=0;
	if (is_array($_POST['cID'])) {
		foreach($_POST['cID'] as $cID) {
			$c = Page::getByID($cID);
			$cp = new Permissions($c);
			if ($cp->canEditPageSpeedSettings()){
				$blocks = $c->getBlocks();
				foreach($blocks as $block) $block->refreshCache();
				$c->refreshCache();
				$c->reindex();
				$i++;
			} else {
				$json['error'] = t('Unable to clear the cache');
			}
		}
	}
	
	if($i >0){
		$json['success'] = 'The cache of '.$i .' pages has been flushed';
	}
	
	$js = Loader::helper('json');
	print $js->encode($json);
	exit;
} 

$form = Loader::helper('form');

$pages = array();
if (is_array($_REQUEST['cID'])) {
	foreach($_REQUEST['cID'] as $cID) {
		$pages[] = Page::getByID($cID);
	}
} else {
	$pages[] = Page::getByID($_REQUEST['cID']);
}

$pcnt = 0;
foreach($pages as $c) { 
	$cp = new Permissions($c);
	if ($cp->canDeletePage()) {
		$pcnt++;
	}
}

$searchInstance = Loader::helper('text')->entities($_REQUEST['searchInstance']);

?>
<div class="ccm-ui">

<?php   if ($pcnt == 0) { ?>
	<?php  echo t("You do not have permission to clear the cache of the selected pages."); ?>
<?php   } else { ?>

	<?php  echo t('Are you sure you want to clear the cache of the following pages?')?><br/><br/>

	<form id="ccm-<?php  echo $searchInstance?>-clear-cache-form" method="post" action="<?php  echo Loader::helper('concrete/urls')->getToolsURL('clear_cache', 'd3_clear_page_cache'); ?>">
	<?php  echo $form->hidden('task', 'clear_cache')?>
	<table border="0" cellspacing="0" cellpadding="0" width="100%" class="table table-striped">
	<tr>
		<th><?php  echo t('Name')?></th>
		<th><?php  echo t('Page Type')?></th>
		<th><?php  echo t('Date Added')?></th>
		<th><?php  echo t('Author')?></th>
	</tr>
	
	<?php   foreach($pages as $c) { 
		$cp = new Permissions($c);
		$c->loadVersionObject();
		?>
		
		<?php  echo $form->hidden('cID[]', $c->getCollectionID())?>		
		
		<tr>
			<td class="ccm-page-list-name"><?php  echo $c->getCollectionName()?></td>
			<td><?php  echo $c->getCollectionTypeName()?></td>
			<td><?php  echo date(DATE_APP_DASHBOARD_SEARCH_RESULTS_PAGES, strtotime($c->getCollectionDatePublic()))?></td>
			<td><?php  
				$ui = UserInfo::getByID($c->getCollectionUserID());
				if (is_object($ui)) {
					print $ui->getUserName();
				}
			}?></td>
		
		</tr>
	</table>
	</form>
	<div class="dialog-buttons">
	<?php   $ih = Loader::helper('concrete/interface')?>
	<?php  echo $ih->button_js(t('Cancel'), 'jQuery.fn.dialog.closeTop()', 'left', 'btn')?>	
	<?php  echo $ih->button_js(t('Clear Cache'), 'ccm_sitemapClearCache(\'' . $searchInstance . '\')', 'right', 'btn error')?>
	</div>		
		
	<?php  
	
}
?>
</div>