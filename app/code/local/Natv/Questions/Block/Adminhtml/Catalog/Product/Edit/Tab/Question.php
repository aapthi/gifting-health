<?php
class Natv_Questions_Block_Adminhtml_Catalog_Product_Edit_Tab_Question extends Mage_Adminhtml_Block_Widget_Grid{
	
	public function __construct(){
		parent::__construct();
		$this->setId('question_grid');
		$this->setDefaultSort('position');
		$this->setDefaultDir('ASC');
		$this->setUseAjax(true);
		if ($this->getProduct()->getId()) {
			$this->setDefaultFilter(array('in_questions'=>1));
		}
	}
	
	protected function _prepareCollection() {
		$collection = Mage::getResourceModel('questions/question_collection');
		if ($this->getProduct()->getId()){
			$constraint = 'related.product_id='.$this->getProduct()->getId();
			}
			else{
				$constraint = 'related.product_id=0';
			}
		$collection->getSelect()->joinLeft(
			array('related'=>$collection->getTable('questions/question_product')),
			'related.question_id=main_table.entity_id AND '.$constraint,
			array('position')
		);
		$this->setCollection($collection);
		parent::_prepareCollection();
		return $this;
	}
	
	protected function _prepareMassaction(){
		return $this;
	}
	
	protected function _prepareColumns(){
		$this->addColumn('in_questions', array(
			'header_css_class'  => 'a-center',
			'type'  => 'checkbox',
			'name'  => 'in_questions',
			'values'=> $this->_getSelectedQuestions(),
			'align' => 'center',
			'index' => 'entity_id'
		));
		$this->addColumn('question', array(
			'header'=> Mage::helper('questions')->__('question'),
			'align' => 'left',
			'index' => 'question',
		));
		$this->addColumn('position', array(
			'header'		=> Mage::helper('questions')->__('Position'),
			'name'  		=> 'position',
			'width' 		=> 60,
			'type'		=> 'number',
			'validate_class'=> 'validate-number',
			'index' 		=> 'position',
			'editable'  	=> true,
		));
	}
	
	protected function _getSelectedQuestions(){
		$questions = $this->getProductQuestions();
		if (!is_array($questions)) {
			$questions = array_keys($this->getSelectedQuestions());
		}
		return $questions;
	}
 	
	public function getSelectedQuestions() {
		$questions = array();
		//used helper here in order not to override the product model
		$selected = Mage::helper('questions/product')->getSelectedQuestions(Mage::registry('current_product'));
		if (!is_array($selected)){
			$selected = array();
		}
		foreach ($selected as $question) {
			$questions[$question->getId()] = array('position' => $question->getPosition());
		}
		return $questions;
	}
	/**
	 * get row url
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getRowUrl($item){
		return '#';
	}
	/**
	 * get grid url
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getGridUrl(){
		return $this->getUrl('*/*/questionsGrid', array(
			'id'=>$this->getProduct()->getId()
		));
	}
	/**
	 * get the current product
	 * @access public
	 * @return Mage_Catalog_Model_Product
	 * @author Ultimate Module Creator
	 */
	public function getProduct(){
		return Mage::registry('current_product');
	}
	/**
	 * Add filter
	 * @access protected
	 * @param object $column
	 * @return Efk_Questions_Block_Adminhtml_Catalog_Product_Edit_Tab_Question
	 * @author Ultimate Module Creator
	 */
	protected function _addColumnFilterToCollection($column){
		if ($column->getId() == 'in_questions') {
			$questionIds = $this->_getSelectedQuestions();
			if (empty($questionIds)) {
				$questionIds = 0;
			}
			if ($column->getFilter()->getValue()) {
				$this->getCollection()->addFieldToFilter('entity_id', array('in'=>$questionIds));
			} 
			else {
				if($questionIds) {
					$this->getCollection()->addFieldToFilter('entity_id', array('nin'=>$questionIds));
				}
			}
		} 
		else {
			parent::_addColumnFilterToCollection($column);
		}
		return $this;
	}
}