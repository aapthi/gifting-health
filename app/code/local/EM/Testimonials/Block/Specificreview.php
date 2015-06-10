<?php
// include_once('Mage/Review/Block/Product/View/List.php');
class EM_Testimonials_Block_Specificreview extends Mage_Core_Block_Template
{
    public function getReviewsCollection($productId)
    {
        $this->_reviewsCollection = Mage::getModel('review/review')->getCollection()
                ->addStoreFilter(Mage::app()->getStore()->getId())
                ->addStatusFilter(Mage_Review_Model_Review::STATUS_APPROVED)
                ->addEntityFilter('product', $productId)
                ->setDateOrder()
                ->addRateVotes();
        return $this->_reviewsCollection;
    }
}
