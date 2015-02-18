<?php            

defined('C5_EXECUTE') or die(_("Access Denied."));

class D3ClearPageCachePackage extends Package {

	protected $pkgHandle = 'd3_clear_page_cache';
	protected $appVersionRequired = '5.6.0';
	protected $pkgVersion = '1.1';
	
	public function getPackageDescription() {
		return t("Clears the cache for only a selected group of pages'");
	}
	
	public function getPackageName() {
		return t("Clear Page Cache");
	} 
	
	public function install() {
		$pkg = parent::install();
		
		Loader::model('single_page');
		
		//Page under optimization section
		$dsp0 = SinglePage::add('/dashboard/system/optimization/clear_page_cache/', $pkg);
		$dsp0->update(array(
			'cName' => t('Clear Page Cache'),
			'cDescription' => t('Clear cache per page')
		));
	}
	
	public function on_start() {
		$ihm = Loader::helper('concrete/interface/menu');
		$uh = Loader::helper('concrete/urls');
		$req = Request::get(); 
		$cID = $req->getRequestCollectionID();
		
		$tool_url = $uh->getToolsURL('clear_cache', 'd3_clear_page_cache');
		$tool_url .= '?cID=' . $cID . '&searchInstance=button';
		$ihm->addPageHeaderMenuItem('clear_cache_button', t('Clear cache'), 'right', array(
			'dialog-title' => t('Clear cache'),
			'href' => $tool_url,
			'dialog-on-open' => "$(\'#ccm-page-edit-nav-clear_cache_button\').removeClass(\'ccm-nav-loading\')",
			'dialog-width' => '500px',
			'dialog-height' => "200px",
			'dialog-modal' => "false",
			'class' => 'ccm-menu-icon ccm-icon-delete dialog-launch'
		), 'd3_clear_page_cache');
	}

}