<?php
class EM_Testimonials_Block_Allreviews extends Mage_Core_Block_Template
{
	public function getAllProductReviews(){
       if ($this->getParam('website')) {
            $storeIds = Mage::app()->getWebsite($this->getParam('website'))->getStoreIds();
            $storeId = array_pop($storeIds);
        } else if ($this->getParam('group')) {
            $storeIds = Mage::app()->getGroup($this->getParam('group'))->getStoreIds();
            $storeId = array_pop($storeIds);
        } else {
            $storeId = (int)$this->getParam('store');
        }
        $_reviews = Mage::getModel('review/review')
					->getResourceCollection()
					->addStoreFilter($storeId)
					->addStatusFilter(Mage_Review_Model_Review::STATUS_APPROVED)
					->addRateVotes()
					->setPageSize(5);	
		$testimonials = $_reviews->getItems();
		usort($testimonials, array('EM_Testimonials_Block_Allreviews'));
		return $testimonials;
    }
	public function getAllReviews(){ 
		if ($this->getParam('website')) {
            $storeIds = Mage::app()->getWebsite($this->getParam('website'))->getStoreIds();
            $storeId = array_pop($storeIds);
        } else if ($this->getParam('group')) {
            $storeIds = Mage::app()->getGroup($this->getParam('group'))->getStoreIds();
            $storeId = array_pop($storeIds);
        } else {
            $storeId = (int)$this->getParam('store');
        }	
        $_reviews = Mage::getModel('review/review')
					->getResourceCollection()
					->addStoreFilter($storeId)
					->addStatusFilter(Mage_Review_Model_Review::STATUS_APPROVED)
					->addRateVotes();	
		$testimonials = $_reviews->getItems();
		usort($testimonials, array('EM_Testimonials_Block_Allreviews'));
		return $testimonials;
    }	
}