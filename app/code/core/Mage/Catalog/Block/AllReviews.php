<?php
class Mage_Catalog_Block_AllReviews extends Mage_Core_Block_Abstract
{
    protected $_blnReviewCount = false;
    protected $_blnStarCount = false;
   
	private static function dateSort($a, $b)
	{
	    $t1 = strtotime($a->getCreatedAt());
	    $t2 = strtotime($b->getCreatedAt());
	    return $t2 - $t1;
	}

    public function getReviewAttributes($productId){
        $reviews = Mage::getModel('review/review') 
            ->getResourceCollection() 
            ->addStoreFilter(Mage::app()->getStore()->getId()) 
            ->addEntityFilter('product', $productId) 
            ->addStatusFilter(Mage_Review_Model_Review::STATUS_APPROVED)
            ->setDateOrder() 
            ->addRateVotes();       
        $count = count($reviews);
        $result = new stdClass();
        if($this->_blnReviewCount){
            $this->_blnReviewCount = false;
            return $count;
        }

        $date = null;
        $details = null;
        $name = null;
        $starCount = array(
                        5 => 0,
                        4 => 0,
                        3 => 0,
                        2 => 0,
                        1 => 0
                    );
        $avgRating = 0;
        $ratings = array();
        $avgRatingPercentage = null;
        $avgRatingValue = null;
        if ($count > 0) { 
            foreach ($reviews->getItems() as $review) {
                $date = $review->getCreatedAt();
                $details = $review->getDetail();
                $name = $review->getNickname();
                $avgReview = 0;
                foreach( $review->getRatingVotes() as $vote ) { 
                    $avgReview += number_format($vote->getValue());
                    $ratings[] = $vote->getPercent();
                }
                $avgRatingPercentage = array_sum($ratings)/count($ratings);
                $avgRatingValue = number_format($avgRatingPercentage/20, 1);
                $avgRounded = round((float)$avgRatingValue);
                for($x = 1; $x <= count($starCount); $x++){
                    if($avgRounded == $x){
                        $starCount[$x]++;
                    }
                }
            } 
        }
        
        if(!$avgRatingPercentage){$avgRatingPercentage = 0;}
        if ((int) $avgRatingValue == $avgRatingValue)  {$avgRatingValue = (int) $avgRatingValue;}

        $result->starCount = $starCount;
        $result->avgRatingPercentage = $avgRatingPercentage;
        $result->avgRatingValue = $avgRatingValue;
        $result->reviewCount = $count;

        return $result;
    }

	public function getAvgProductRating($productId) {
		$reviews = Mage::getModel('review/review')
				->getResourceCollection()
				->addStoreFilter(Mage::app()->getStore()->getId()) 
				->addEntityFilter('product', $productId)
				->addStatusFilter(Mage_Review_Model_Review::STATUS_APPROVED)
				->setDateOrder()
				->addRateVotes();
		
		$count = count($reviews);
		$result = new stdClass();
		
		$avg = 0;
		$ratings = array();
		if (count($reviews) > 0) {
			foreach ($reviews->getItems() as $review) {
				foreach( $review->getRatingVotes() as $vote ) {
					$ratings[] = $vote->getPercent();
				}
			}
			$avg = array_sum($ratings)/count($ratings);
		}
		
		$result->count = $count;
		$result->avg = $avg;
		return $result;
	}

    public function getReviewCount($productId){
        $this->_blnReviewCount = true;
        return $this->getAvgReview($productId);
    }

    public function getStarCount($productId){
        $this->_blnStarCount = true;
        return $this->getAvgReview($productId);
    }
}
