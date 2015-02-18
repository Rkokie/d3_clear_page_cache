<?php 
defined('C5_EXECUTE') or die("Access Denied.");
class ClearCacheButtonConcreteInterfaceMenuItemController extends ConcreteInterfaceMenuItemController {
	
	public function displayItem() {
		global $c;
		$cp = new Permissions($c);
		if ($cp->canEditPageSpeedSettings()) {
			return true;
		}
		return false;
	}

}