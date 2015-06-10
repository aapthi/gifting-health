<?php
class Natv_Questions_Model_Resource_Question_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract{
	protected $_joinedFields = array();

	public function _construct(){
		parent::_construct();
		$this->_init('questions/question');
		$this->_map['fields']['store'] = 'store_table.store_id';
	}

	protected function _toOptionArray($valueField='entity_id', $labelField='question', $additional=array()){
		return parent::_toOptionArray($valueField, $labelField, $additional);
	}
	
	protected function _toOptionHash($valueField='entity_id', $labelField='question'){
		return parent::_toOptionHash($valueField, $labelField);
	}
	
	public function addStoreFilter($store, $withAdmin = true){
		if (!isset($this->_joinedFields['store'])){
			if ($store instanceof Mage_Core_Model_Store) {
				$store = array($store->getId());
			}
			if (!is_array($store)) {
				$store = array($store);
			}
			if ($withAdmin) {
				$store[] = Mage_Core_Model_App::ADMIN_STORE_ID;
			}
			$this->addFilter('store', array('in' => $store), 'public');
			$this->_joinedFields['store'] = true;
		}
		return $this;
	}
	
	protected function _renderFiltersBefore(){
		if ($this->getFilter('store')) {
			$this->getSelect()->join(
				array('store_table' => $this->getTable('questions/question_store')),
				'main_table.entity_id = store_table.question_id',
				array()
			)->group('main_table.entity_id');
			
			$this->_useAnalyticFunction = true;
		}
		return parent::_renderFiltersBefore();
	}
	
	public function getSelectCountSql(){
		$countSelect = parent::getSelectCountSql();
		$countSelect->reset(Zend_Db_Select::GROUP);
		return $countSelect;
	}
	
	public function addProductFilter($product){
		if ($product instanceof Mage_Catalog_Model_Product){
			$product = $product->getId();
		}
		if (!isset($this->_joinedFields['product'])){
			$this->getSelect()->join(
				array('related_product' => $this->getTable('questions/question_product')),
				'related_product.question_id = main_table.entity_id',
				array('position')
			);
			$this->getSelect()->where('related_product.product_id = ?', $product);
			$this->_joinedFields['product'] = true;
		}
		return $this;
	}
}