<?php
class EM_Testimonials_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
		$this->loadLayout();     
		$this->renderLayout();
    }
	public function getloadMoreReviewsAction(){
		$this->loadLayout();
		$id = $_POST['tot'];		
		$block = Mage::app()->getLayout()->createBlock('testimonials/allreviews');		
		$getReviewsOnProducts = $block->getAllReviews();	
		$countReview=0;
		$getDatareviews=array();
		$getReviewsOnProductss=array();
		foreach($getReviewsOnProducts as $item) {
			$productId = $item->getData('entity_pk_value');
			$getDatareviews[$countReview]['productId']=$productId;
			$_product = Mage::getModel("catalog/product")->load($productId);
			if($productId){
			
				foreach( $item->getRatingVotes() as $vote ) {
					$percentage = $vote->getPercent();
					$getDatareviews[$countReview]['percentage']=$percentage;
				}				
				$name = $item ->getNickname();
				$getDatareviews[$countReview]['name']=$name;
				$date = $item->getCreatedAt();
				$getDatareviews[$countReview]['date']=$date;
				$details = $item->getDetail();
				$getDatareviews[$countReview]['details']=$details;
				$url = $_product->getProductUrl();
				$getDatareviews[$countReview]['url']=$url;
				$productName = $_product->getName();
				$getDatareviews[$countReview]['productName']=$productName;
			} 
			if($date) {
				$date = new DateTime($date);
				$timezone = Mage::app()->getStore()->getConfig('general/locale/timezone');
				$date->setTimezone(new DateTimeZone($timezone));	
			}
			$countReview++;
		}
		$getReviewsOnProductss=$getDatareviews;
		$count=count($getReviewsOnProductss);
		echo '<pre>';print_r($getReviewsOnProductss);exit;	
	}
}
?>