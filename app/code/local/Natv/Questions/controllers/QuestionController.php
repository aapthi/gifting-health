<?php 
class Natv_Questions_QuestionController extends Mage_Core_Controller_Front_Action{	
 	public function indexAction(){
		$this->loadLayout();
 		if (Mage::helper('questions/question')->getUseBreadcrumbs()){
			if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')){
				$breadcrumbBlock->addCrumb('home', array(
							'label'	=> Mage::helper('questions')->__('Home'), 
							'link' 	=> Mage::getUrl(),
						)
				);
				$breadcrumbBlock->addCrumb('questions', array(
							'label'	=> Mage::helper('questions')->__('Questions'), 
							'link'	=> '',
					)
				);
			}
		}
		$headBlock = $this->getLayout()->getBlock('head');
		if ($headBlock) {
			$headBlock->setTitle(Mage::getStoreConfig('questions/question/meta_title'));
			$headBlock->setKeywords(Mage::getStoreConfig('questions/question/meta_keywords'));
			$headBlock->setDescription(Mage::getStoreConfig('questions/question/meta_description'));
		}
		$this->renderLayout();
	}
	
	public function viewAction(){
		$questionId 	= $this->getRequest()->getParam('id', 0);
		$question 	= Mage::getModel('questions/question')
						->setStoreId(Mage::app()->getStore()->getId())
						->load($questionId);
		if (!$question->getId()){
			$this->_forward('no-route');
		}
		elseif (!$question->getStatus()){
			$this->_forward('no-route');
		}
		else{
			Mage::register('current_questions_question', $question);
			$this->loadLayout();
			if ($root = $this->getLayout()->getBlock('root')) {
				$root->addBodyClass('questions-question questions-question' . $question->getId());
			}
			if (Mage::helper('questions/question')->getUseBreadcrumbs()){
				if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')){
					$breadcrumbBlock->addCrumb('home', array(
								'label'	=> Mage::helper('questions')->__('Home'), 
								'link' 	=> Mage::getUrl(),
							)
					);
					$breadcrumbBlock->addCrumb('questions', array(
								'label'	=> Mage::helper('questions')->__('Questions'), 
								'link'	=> Mage::helper('questions')->getQuestionsUrl(),
						)
					);
					$breadcrumbBlock->addCrumb('question', array(
								'label'	=> $question->getQuestion(), 
								'link'	=> '',
						)
					);
				}
			}
			$headBlock = $this->getLayout()->getBlock('head');
			if ($headBlock) {
				if ($question->getMetaTitle()){
					$headBlock->setTitle($question->getMetaTitle());
				}
				else{
					$headBlock->setTitle($question->getQuestion());
				}
				$headBlock->setKeywords($question->getMetaKeywords());
				$headBlock->setDescription($question->getMetaDescription());
			}
			$this->renderLayout();
		}
	}

	public function specificAction(){
		$this->loadLayout();
		$layout = $this->getLayout();
		echo $layout->getBlock('product.info.questions.ajax')->toHtml();
	}
}