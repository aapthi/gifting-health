<?php 
class Natv_Questions_Block_Adminhtml_Question_Edit_Tab_Meta extends Mage_Adminhtml_Block_Widget_Form{
	/**
	 * prepare the form
	 * @access protected
	 * @return Efk_Questions_Block_Adminhtml_Question_Edit_Tab_Meta
	 * @author Ultimate Module Creator
	 */
	protected function _prepareForm(){
		$form = new Varien_Data_Form();
		$form->setFieldNameSuffix('question');
		$this->setForm($form);
		$fieldset = $form->addFieldset('question_meta_form', array('legend'=>Mage::helper('questions')->__('Meta information')));
		$fieldset->addField('meta_title', 'text', array(
			'label' => Mage::helper('questions')->__('Meta-title'),
			'name'  => 'meta_title',
		));
		$fieldset->addField('meta_description', 'textarea', array(
			'name'  	=> 'meta_description',
			'label' 	=> Mage::helper('questions')->__('Meta-description'),
  		));
  		$fieldset->addField('meta_keywords', 'textarea', array(
			'name'  	=> 'meta_keywords',
			'label' 	=> Mage::helper('questions')->__('Meta-keywords'),
  		));
  		$form->addValues(Mage::registry('current_question')->getData());
		return parent::_prepareForm();
	}
}