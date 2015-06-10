<?php
class Natv_Questions_Block_Adminhtml_Question_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		$this->setId('question_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('questions')->__('Question'));
	}
	/**
	 * before render html
	 * @access protected
	 * @return Efk_Questions_Block_Adminhtml_Question_Edit_Tabs
	 * @author Ultimate Module Creator
	 */
	protected function _beforeToHtml(){
		$this->addTab('form_question', array(
			'label'		=> Mage::helper('questions')->__('Question'),
			'title'		=> Mage::helper('questions')->__('Question'),
			'content' 	=> $this->getLayout()->createBlock('questions/adminhtml_question_edit_tab_form')->toHtml(),
		));
		// $this->addTab('form_meta_question', array(
		// 	'label'		=> Mage::helper('questions')->__('Meta'),
		// 	'title'		=> Mage::helper('questions')->__('Meta'),
		// 	'content' 	=> $this->getLayout()->createBlock('questions/adminhtml_question_edit_tab_meta')->toHtml(),
		// ));
		if (!Mage::app()->isSingleStoreMode()){
			$this->addTab('form_store_question', array(
				'label'		=> Mage::helper('questions')->__('Store views'),
				'title'		=> Mage::helper('questions')->__('Store views'),
				'content' 	=> $this->getLayout()->createBlock('questions/adminhtml_question_edit_tab_stores')->toHtml(),
			));
		}
		$this->addTab('products', array(
			'label' => Mage::helper('questions')->__('Associated products'),
			'url'   => $this->getUrl('*/*/products', array('_current' => true)),
   			'class'	=> 'ajax'
		));
		return parent::_beforeToHtml();
	}
}