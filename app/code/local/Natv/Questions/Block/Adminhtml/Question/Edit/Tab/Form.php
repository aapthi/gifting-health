<?php
class Natv_Questions_Block_Adminhtml_Question_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form{	
	/**
	 * prepare the form
	 * @access protected
	 * @return Questions_Question_Block_Adminhtml_Question_Edit_Tab_Form
	 * @author Ultimate Module Creator
	 */
	protected function _prepareForm(){
		$form = new Varien_Data_Form();
		$form->setHtmlIdPrefix('question_');
		$form->setFieldNameSuffix('question');
		$this->setForm($form);
		$fieldset = $form->addFieldset('question_form', array('legend'=>Mage::helper('questions')->__('Question')));

		$fieldset->addField('question', 'text', array(
			'label' => Mage::helper('questions')->__('question'),
			'name'  => 'question',
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('answer', 'textarea', array(
			'label' => Mage::helper('questions')->__('answer'),
			'name'  => 'answer',
			'required'  => true,
			'class' => 'required-entry',

		));
		$fieldset->addField('status', 'select', array(
			'label' => Mage::helper('questions')->__('Status'),
			'name'  => 'status',
			'values'=> array(
				array(
					'value' => 1,
					'label' => Mage::helper('questions')->__('Enabled'),
				),
				array(
					'value' => 0,
					'label' => Mage::helper('questions')->__('Disabled'),
				),
			),
		));
		if (Mage::app()->isSingleStoreMode()){
			$fieldset->addField('store_id', 'hidden', array(
                'name'      => 'stores[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
            Mage::registry('current_question')->setStoreId(Mage::app()->getStore(true)->getId());
		}
		if (Mage::getSingleton('adminhtml/session')->getQuestionData()){
			$form->setValues(Mage::getSingleton('adminhtml/session')->getQuestionData());
			Mage::getSingleton('adminhtml/session')->setQuestionData(null);
		}
		elseif (Mage::registry('current_question')){
			$form->setValues(Mage::registry('current_question')->getData());
		}
		return parent::_prepareForm();
	}
}