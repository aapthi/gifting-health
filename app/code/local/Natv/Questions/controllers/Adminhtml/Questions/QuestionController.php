<?php
class Natv_Questions_Adminhtml_Questions_QuestionController extends Natv_Questions_Controller_Adminhtml_Questions{
	
	protected function _initQuestion(){
		$questionId  = (int) $this->getRequest()->getParam('id');
		$question	= Mage::getModel('questions/question');
		if ($questionId) {
			$question->load($questionId);
		}
		Mage::register('current_question', $question);
		return $question;
	} 
	public function indexAction() {
		$this->loadLayout();
		$this->_title(Mage::helper('questions')->__('Questions'))
			 ->_title(Mage::helper('questions')->__('Questions'));
		$this->renderLayout();
	}	
	public function gridAction() {
		$this->loadLayout()->renderLayout();
	}	
	public function editAction() {
		$questionId	= $this->getRequest()->getParam('id');
		$question  	= $this->_initQuestion();
		if ($questionId && !$question->getId()) {
			$this->_getSession()->addError(Mage::helper('questions')->__('This question no longer exists.'));
			$this->_redirect('*/*/');
			return;
		}
		$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
		if (!empty($data)) {
			$question->setData($data);
		}
		Mage::register('question_data', $question);
		$this->loadLayout();
		$this->_title(Mage::helper('questions')->__('Questions'))
			 ->_title(Mage::helper('questions')->__('Questions'));
		if ($question->getId()){
			$this->_title($question->getQuestion());
		}
		else{
			$this->_title(Mage::helper('questions')->__('Add question'));
		}
		if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) { 
			$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true); 
		}
		$this->renderLayout();
	}
	
	public function newAction() {
		$this->_forward('edit');
	}
	
	public function saveAction() {
		if ($data = $this->getRequest()->getPost('question')) {
			try {
				$question = $this->_initQuestion();
				$question->addData($data);
				$products = $this->getRequest()->getPost('products', -1);
				if ($products != -1) {
					$question->setProductsData(Mage::helper('adminhtml/js')->decodeGridSerializedInput($products));
				}
				$question->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('questions')->__('Question was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $question->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
			} 
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
			catch (Exception $e) {
				Mage::logException($e);
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('questions')->__('There was a problem saving the question.'));
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('questions')->__('Unable to find question to save.'));
		$this->_redirect('*/*/');
	}
	
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0) {
			try {
				$question = Mage::getModel('questions/question');
				$question->setId($this->getRequest()->getParam('id'))->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('questions')->__('Question was successfully deleted.'));
				$this->_redirect('*/*/');
				return; 
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('questions')->__('There was an error deleteing question.'));
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				Mage::logException($e);
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('questions')->__('Could not find question to delete.'));
		$this->_redirect('*/*/');
	}
	
	public function massDeleteAction() {
		$questionIds = $this->getRequest()->getParam('question');
		if(!is_array($questionIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('questions')->__('Please select questions to delete.'));
		}
		else {
			try {
				foreach ($questionIds as $questionId) {
					$question = Mage::getModel('questions/question');
					$question->setId($questionId)->delete();
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('questions')->__('Total of %d questions were successfully deleted.', count($questionIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('questions')->__('There was an error deleteing questions.'));
				Mage::logException($e);
			}
		}
		$this->_redirect('*/*/index');
	}

	public function massStatusAction(){
		$questionIds = $this->getRequest()->getParam('question');
		if(!is_array($questionIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('questions')->__('Please select questions.'));
		} 
		else {
			try {
				foreach ($questionIds as $questionId) {
				$question = Mage::getSingleton('questions/question')->load($questionId)
							->setStatus($this->getRequest()->getParam('status'))
							->setIsMassupdate(true)
							->save();
				}
				$this->_getSession()->addSuccess($this->__('Total of %d questions were successfully updated.', count($questionIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('questions')->__('There was an error updating questions.'));
				Mage::logException($e);
			}
		}
		$this->_redirect('*/*/index');
	}
	
	public function productsAction(){
		$this->_initQuestion();
		$this->loadLayout();
		$this->getLayout()->getBlock('question.edit.tab.product')
			->setQuestionProducts($this->getRequest()->getPost('question_products', null));
		$this->renderLayout();
	}
	
	public function productsgridAction(){
		$this->_initQuestion();
		$this->loadLayout();
		$this->getLayout()->getBlock('question.edit.tab.product')
			->setQuestionProducts($this->getRequest()->getPost('question_products', null));
		$this->renderLayout();
	}
	
	public function exportCsvAction(){
		$fileName   = 'question.csv';
		$content	= $this->getLayout()->createBlock('questions/adminhtml_question_grid')->getCsv();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	
	public function exportExcelAction(){
		$fileName   = 'question.xls';
		$content	= $this->getLayout()->createBlock('questions/adminhtml_question_grid')->getExcelFile();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	
	public function exportXmlAction(){
		$fileName   = 'question.xml';
		$content	= $this->getLayout()->createBlock('questions/adminhtml_question_grid')->getXml();
		$this->_prepareDownloadResponse($fileName, $content);
	}
}