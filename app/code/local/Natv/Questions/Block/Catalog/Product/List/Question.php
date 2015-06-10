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
 * Question list on product page block
 *
 * @category	Efk
 * @package		Efk_Questions
 * @author Ultimate Module Creator
 */
class Natv_Questions_Block_Catalog_Product_List_Question extends Mage_Catalog_Block_Product_Abstract{
	protected $_isAjax = null;
	
	public function __construct(){
		$isAjax = $this->getRequest()->getParam('ajax');
		$this->_isAjax = $isAjax;
		$_product = $isAjax?Mage::getModel('catalog/product')->load($isAjax):Mage::registry('current_product');
		$this->setProduct($_product);
	}

	public function getQuestionCollection(){
		if (!$this->hasData('question_collection')){
			$product = $this->getProduct();
			$collection = Mage::getResourceSingleton('questions/question_collection')
				->addStoreFilter(Mage::app()->getStore())
				->addFilter('status', 1)
				->addProductFilter($product);
			$collection->getSelect()->order('related_product.position', 'ASC');
			$this->setData('question_collection', $collection);
		}
		return $this->getData('question_collection');
	}

	public function getSpecificQuestionsUrl($id){
		// return Mage::getUrl('questions/question/specific/') . 'id/' . $productId;
		return Mage::getUrl('questions/question/specific/', array('ajax' => $id));
	}
}