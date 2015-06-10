<?php
class Natv_Questions_Model_Adminhtml_Observer{	
	protected function _canAddTab($product){
		if ($product->getId()){
			return true;
		}
		if (!$product->getAttributeSetId()){
			return false;
		}
		$request = Mage::app()->getRequest();
		if ($request->getParam('type') == 'configurable'){
			if ($request->getParam('attribtues')){
				return true;
			}
		}
		return false;
	}	
	public function addQuestionBlock($observer){
		$block = $observer->getEvent()->getBlock();
		$product = Mage::registry('product');
		if ($block instanceof Mage_Adminhtml_Block_Catalog_Product_Edit_Tabs && $this->_canAddTab($product)){
			$block->addTab('questions', array(
				'label' => Mage::helper('questions')->__('Questions'),
				'url'   => Mage::helper('adminhtml')->getUrl('adminhtml/questions_question_catalog_product/questions', array('_current' => true)),
				'class' => 'ajax',
			));
		}
		return $this;
	}	
	public function saveQuestionData($observer){
		$post = Mage::app()->getRequest()->getPost('questions', -1);
		if ($post != '-1') {
			$post = Mage::helper('adminhtml/js')->decodeGridSerializedInput($post);
			$product = Mage::registry('product');
			$questionProduct = Mage::getResourceSingleton('questions/question_product')->saveProductRelation($product, $post);
		}
		return $this;
	}}