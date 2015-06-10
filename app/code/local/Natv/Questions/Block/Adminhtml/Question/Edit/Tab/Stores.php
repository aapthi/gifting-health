<?php 
class Natv_Questions_Block_Adminhtml_Question_Edit_Tab_Stores extends Mage_Adminhtml_Block_Widget_Form{	
	protected function _prepareForm(){
		$form = new Varien_Data_Form();
		$form->setFieldNameSuffix('question');
		$this->setForm($form);
		$fieldset = $form->addFieldset('question_stores_form', array('legend'=>Mage::helper('questions')->__('Store views')));
		$field = $fieldset->addField('store_id', 'multiselect', array(
			'name'  => 'stores[]',
			'label' => Mage::helper('questions')->__('Store Views'),
			'title' => Mage::helper('questions')->__('Store Views'),
			'required'  => true,
			'values'=> Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
		));
		$renderer = $this->getLayout()->createBlock('adminhtml/store_switcher_form_renderer_fieldset_element');
		$field->setRenderer($renderer);
  		$form->addValues(Mage::registry('current_question')->getData());
		return parent::_prepareForm();
	}
}