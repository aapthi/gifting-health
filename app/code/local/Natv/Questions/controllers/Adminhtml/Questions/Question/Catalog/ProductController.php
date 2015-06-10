<?php
require_once ("Mage/Adminhtml/controllers/Catalog/ProductController.php");
class Natv_Questions_Adminhtml_Questions_Question_Catalog_ProductController extends Mage_Adminhtml_Catalog_ProductController{
	
	protected function _construct(){
		
		$this->setUsedModuleName('Efk_Questions');
	}
	
	public function questionsAction(){
		$this->_initProduct();
		$this->loadLayout();
		$this->getLayout()->getBlock('product.edit.tab.question')
			->setProductQuestions($this->getRequest()->getPost('product_questions', null));
		$this->renderLayout();
	}
	
	public function questionsGridAction(){
		$this->_initProduct();
		$this->loadLayout();
		$this->getLayout()->getBlock('product.edit.tab.question')
			->setProductQuestions($this->getRequest()->getPost('product_questions', null));
		$this->renderLayout();
	}
}