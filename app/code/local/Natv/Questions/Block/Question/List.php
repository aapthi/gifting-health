<?php 
/**
 * Efk_Questions extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category   	Efk
 * @package		Efk_Questions
 * @copyright  	Copyright (c) 2013
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Question list block
 *
 * @category	Efk
 * @package		Efk_Questions
 * @author Ultimate Module Creator
 */
class Natv_Questions_Block_Question_List extends Mage_Core_Block_Template{
	/**
	 * initialize
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
 	public function __construct(){
		parent::__construct();
 		$questions = Mage::getResourceModel('questions/question_collection')
 						->addStoreFilter(Mage::app()->getStore())
				->addFilter('status', 1)
		;
		$questions->setOrder('question', 'asc');
		$this->setQuestions($questions);
	}
	/**
	 * prepare the layout
	 * @access protected
	 * @return Efk_Questions_Block_Question_List
	 * @author Ultimate Module Creator
	 */
	protected function _prepareLayout(){
		parent::_prepareLayout();
		$pager = $this->getLayout()->createBlock('page/html_pager', 'questions.question.html.pager')
			->setCollection($this->getQuestions());
		$this->setChild('pager', $pager);
		$this->getQuestions()->load();
		return $this;
	}
	/**
	 * get the pager html
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getPagerHtml(){
		return $this->getChildHtml('pager');
	}
}