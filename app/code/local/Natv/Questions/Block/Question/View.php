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
 * Question view block
 *
 * @category	Efk
 * @package		Efk_Questions
 * @author Ultimate Module Creator
 */
class Natv_Questions_Block_Question_View extends Mage_Core_Block_Template{
	/**
	 * get the current question
	 * @access public
	 * @return mixed (Efk_Questions_Model_Question|null)
	 * @author Ultimate Module Creator
	 */
	public function getCurrentQuestion(){
		return Mage::registry('current_questions_question');
	}
} 