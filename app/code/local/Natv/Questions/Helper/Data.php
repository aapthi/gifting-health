<?php 
class Natv_Questions_Helper_Data extends Mage_Core_Helper_Abstract{	
	public function getQuestionsUrl(){
		return Mage::getUrl('questions/question/index');
	}
}