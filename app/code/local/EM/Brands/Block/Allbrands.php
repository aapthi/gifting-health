<?php
class EM_Brands_Block_Allbrands extends Mage_Core_Block_Template
{
	public function getAllBrandsProduct(){
		$product = Mage::getModel('catalog/product');
		$attributes = Mage::getResourceModel('eav/entity_attribute_collection')
			  ->setEntityTypeFilter($product->getResource()->getTypeId())
			  ->addFieldToFilter('attribute_code', 'manufacturer');
		$attribute = $attributes->getFirstItem()->setEntity($product->getResource());
		$manufacturers = $attribute->getSource()->getAllOptions(false);
		# adding products count to the brands collection
		foreach ($manufacturers as $key => $value) {
			$collection = Mage::getModel('catalog/product')->getCollection();
			
			$collection->addFieldToFilter(array(array('attribute' => 'manufacturer', 'eq' => $value['value'])));
			$numberOfProducts = count($collection);
			$manufacturers[$key]['products_count'] = $numberOfProducts;
		}
		# sort the array in desc order
		$pcount = array();
		foreach ($manufacturers as $key => $row)
		{
			$pcount[$key] = $row['products_count'];
		}
		array_multisort($pcount, SORT_DESC, $manufacturers);
		$getBrands = array();
		$keyy = 0;
		foreach ($manufacturers as $cnt => $val) { 			
			if($val['products_count']>0){
				$getBrands[$keyy++] = $val;
			}
		}
		usort($getBrands, array('EM_Brands_Block_Allbrands'));
		return $getBrands;
    }	
}