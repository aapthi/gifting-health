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
 * Question product list
 *
 * @category	Efk
 * @package		Efk_Questions
 * @author Ultimate Module Creator
 */
class Natv_Questions_Block_Question_Catalog_Product_List extends Mage_Core_Block_Template{
	/**
	 * get the list of products
	 * @access public
	 * @return Mage_Catalog_Model_Resource_Product_Collection
	 * @author Ultimate Module Creator
	 */
	public function getProductCollection(){
		$collection = $this->getQuestion()->getSelectedProductsCollection();
		$collection->addAttributeToSelect('name');
		$collection->addUrlRewrite();
		$collection->getSelect()->order('related.position');
		Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
		Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);
		return $collection;
	}
	/**
	 * get current question
	 * @access public
	 * @return Efk_Questions_Model_Question
	 * @author Ultimate Module Creator
	 */
	public function getQuestion(){
		return Mage::registry('current_questions_question');
	}
}