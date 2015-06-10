<?php
class Natv_Questions_Model_Question extends Mage_Core_Model_Abstract{
	
	const ENTITY= 'questions_question';
	const CACHE_TAG = 'questions_question';
	
	protected $_eventPrefix = 'questions_question';
	
	protected $_eventObject = 'question';
	protected $_productInstance = null;
	
	public function _construct(){
		parent::_construct();
		$this->_init('questions/question');
	}	
	protected function _beforeSave(){
		parent::_beforeSave();
		$now = Mage::getSingleton('core/date')->gmtDate();
		if ($this->isObjectNew()){
			$this->setCreatedAt($now);
		}
		$this->setUpdatedAt($now);
		return $this;
	}	
	public function getQuestionUrl(){
		return Mage::getUrl('questions/question/view', array('id'=>$this->getId()));
	}	
	protected function _afterSave() {
		$this->getProductInstance()->saveQuestionRelation($this);
		return parent::_afterSave();
	}
	public function getProductInstance(){
		if (!$this->_productInstance) {
			$this->_productInstance = Mage::getSingleton('questions/question_product');
		}
		return $this->_productInstance;
	}	
	public function getSelectedProducts(){
		if (!$this->hasSelectedProducts()) {
			$products = array();
			foreach ($this->getSelectedProductsCollection() as $product) {
				$products[] = $product;
			}
			$this->setSelectedProducts($products);
		}
		return $this->getData('selected_products');
	}	
	public function getSelectedProductsCollection(){
		$collection = $this->getProductInstance()->getProductCollection($this);
		return $collection;
	}
}