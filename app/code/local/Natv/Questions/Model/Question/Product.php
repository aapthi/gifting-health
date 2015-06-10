<?php 
class Natv_Questions_Model_Question_Product extends Mage_Core_Model_Abstract{	
	protected function _construct(){
		$this->_init('questions/question_product');
	}	
	public function saveQuestionRelation($question){
		$data = $question->getProductsData();
		if (!is_null($data)) {
			$this->_getResource()->saveQuestionRelation($question, $data);
		}
		return $this;
	}	
	public function getProductCollection($question){
		$collection = Mage::getResourceModel('questions/question_product_collection')
			->addQuestionFilter($question);
		return $collection;
	}
}