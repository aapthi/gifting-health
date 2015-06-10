<?php 
class Natv_Questions_Helper_Question extends Mage_Core_Helper_Abstract{	
	public function getUseBreadcrumbs(){
		return Mage::getStoreConfigFlag('questions/question/breadcrumbs');
	}
}