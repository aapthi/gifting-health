<?php
class Natv_Questions_Model_Resource_Question_Product extends Mage_Core_Model_Resource_Db_Abstract{
	protected function  _construct(){
		$this->_init('questions/question_product', 'rel_id');
	}	
	public function saveQuestionRelation($question, $data){
		if (!is_array($data)) {
			$data = array();
		}
		$deleteCondition = $this->_getWriteAdapter()->quoteInto('question_id=?', $question->getId());
		$this->_getWriteAdapter()->delete($this->getMainTable(), $deleteCondition);

		foreach ($data as $productId => $info) {
			$this->_getWriteAdapter()->insert($this->getMainTable(), array(
				'question_id'  	=> $question->getId(),
				'product_id' 	=> $productId,
				'position'  	=> @$info['position']
			));
		}
		return $this;
	}	
	public function saveProductRelation($product, $data){
		if (!is_array($data)) {
			$data = array();
		}
		$deleteCondition = $this->_getWriteAdapter()->quoteInto('product_id=?', $product->getId());
		$this->_getWriteAdapter()->delete($this->getMainTable(), $deleteCondition);
		
		foreach ($data as $questionId => $info) {
			$this->_getWriteAdapter()->insert($this->getMainTable(), array(
				'question_id' => $questionId,
				'product_id' => $product->getId(),
				'position'   => @$info['position']
			));
		}
		return $this;
	}
}