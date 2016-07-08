<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Sales
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Model to calculate grand total or an order
 *
 * @category    Mage
 * @package     Mage_Sales
 * @author      Magento Core Team
 */
class Mage_Sales_Model_Quote_Address_Total_Grand extends Mage_Sales_Model_Quote_Address_Total_Abstract
{
    /**
     * Collect grand total address amount
     *
     * @param   Mage_Sales_Model_Quote_Address $address
     * @return  Mage_Sales_Model_Quote_Address_Total_Grand
     */
    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        $grandTotal     = $address->getGrandTotal();
        $baseGrandTotal = $address->getBaseGrandTotal();

        $store      = $address->getQuote()->getStore();
       // $totals     = array_sum($address->getAllTotalAmounts());
       // $totals     = $store->roundPrice($totals);
       // $baseTotals = array_sum($address->getAllBaseTotalAmounts());
       // $baseTotals = $store->roundPrice($baseTotals);
		$quote = $address->getQuote();
        $cartItems = $quote->getAllVisibleItems();
		$totcomission = 0; $totals =0;
        foreach ($cartItems as $item)
        {
			 $qty = $item->getQty();
			 $comission = Mage::getModel('catalog/product')->load($item->getProduct()->getId())->getComission();
			 $e_c = $comission * $qty;
			 $totcomission += $e_c; 					
        }   
		 $address->setGrandTotal($totcomission);
		 $address->setBaseGrandTotal($totcomission);	
		return $this;
    }

    /**
     * Add grand total information to address
     *
     * @param   Mage_Sales_Model_Quote_Address $address
     * @return  Mage_Sales_Model_Quote_Address_Total_Grand
     */
    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
		if($address->getGrandTotal()!=0){
			$address->addTotal(array(
				'code'  => $this->getCode(),
				'title' => Mage::helper('sales')->__('Grand Total'),
				'value' => $address->getGrandTotal()/2,
				'area'  => 'footer',
			));
		}
        return $this;
    }
}
