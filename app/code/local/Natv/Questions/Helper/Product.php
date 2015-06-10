<?php
class Natv_Questions_Helper_Product extends Natv_Questions_Helper_Data{	
	public function getSelectedQuestions(Mage_Catalog_Model_Product $product){
		if (!$product->hasSelectedQuestions()) {
			$questions = array();
			foreach ($this->getSelectedQuestionsCollection($product) as $question) {
				$questions[] = $question;
			}
			$product->setSelectedQuestions($questions);
		}
		return $product->getData('selected_questions');
	}	
	public function getSelectedQuestionsCollection(Mage_Catalog_Model_Product $product){
		$collection = Mage::getResourceSingleton('questions/question_collection')
			->addProductFilter($product);
		return $collection;
	}
}