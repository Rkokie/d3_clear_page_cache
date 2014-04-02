<?php           

defined('C5_EXECUTE') or die(_("Access Denied."));

class D3ClearPageCachePackage extends Package {

	protected $pkgHandle = 'd3_clear_page_cache';
	protected $appVersionRequired = '5.6.0';
	protected $pkgVersion = '1.0';
	
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

}