<?php 
class Natv_Questions_Model_Resource_Question_Product_Collection extends Mage_Catalog_Model_Resource_Product_Collection{
	
	protected $_joinedFields = false;
	
	public function joinFields(){
		if (!$this->_joinedFields){
			$this->getSelect()->join(
				array('related' => $this->getTable('questions/question_product')),
				'related.product_id = e.entity_id',
				array('position')
			);
			$this->_joinedFields = true;
		}
		return $this;
	}
	
	public function addQuestionFilter($question){
		if ($question instanceof Natv_Questions_Model_Question){
			$question = $question->getId();
		}
		if (!$this->_joinedFields){
			$this->joinFields();
		}
		$this->getSelect()->where('related.question_id = ?', $question);
		return $this;
	}
}