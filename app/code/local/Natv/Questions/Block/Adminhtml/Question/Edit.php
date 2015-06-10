<?php

class Natv_Questions_Block_Adminhtml_Question_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{
	
	public function __construct(){
		parent::__construct();
		$this->_blockGroup = 'questions';
		$this->_controller = 'adminhtml_question';
		$this->_updateButton('save', 'label', Mage::helper('questions')->__('Save Question'));
		$this->_updateButton('delete', 'label', Mage::helper('questions')->__('Delete Question'));
		$this->_addButton('saveandcontinue', array(
			'label'		=> Mage::helper('questions')->__('Save And Continue Edit'),
			'onclick'	=> 'saveAndContinueEdit()',
			'class'		=> 'save',
		), -100);
		$this->_formScripts[] = "
			function saveAndContinueEdit(){
				editForm.submit($('edit_form').action+'back/edit/');
			}
		";
	}	
	public function getHeaderText(){
		if( Mage::registry('question_data') && Mage::registry('question_data')->getId() ) {
			return Mage::helper('questions')->__("Edit Question '%s'", $this->htmlEscape(Mage::registry('question_data')->getQuestion()));
		} 
		else {
			return Mage::helper('questions')->__('Add Question');
		}
	}
}