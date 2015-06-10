<?php
class Natv_Questions_Block_Adminhtml_Question extends Mage_Adminhtml_Block_Widget_Grid_Container{	
	public function __construct(){
		$this->_controller 		= 'adminhtml_question';
		$this->_blockGroup 		= 'questions';
		$this->_headerText 		= Mage::helper('questions')->__('Question');
		$this->_addButtonLabel 	= Mage::helper('questions')->__('Add Question');
		parent::__construct();
	}
}