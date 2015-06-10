<?php
class EM_Bestsellerproducts_Block_List extends Mage_Catalog_Block_Product_Abstract
implements Mage_Widget_Block_Interface
{
	protected function _construct()
    {
        parent::_construct();
        $cacheLifeTime = $this->getCacheLifeTime() ? $this->getCacheLifeTime() : 7200;
        $cacheTags = array(Mage_Catalog_Model_Product::CACHE_TAG,Mage_Cms_Model_Page::CACHE_TAG,'em_bestsellerproducts');
        if($this->ShowLabel() && Mage::helper('core')->isModuleEnabled('EM_Productlabels')){
            $cacheTags[] = EM_Productlabels_Model_Productlabels::CACHE_TAG;
        }
		$this->addData(array(
            'cache_lifetime'    => $cacheLifeTime,
            'cache_tags'        => $cacheTags
		));
    }  
	
	public function getCacheKeyInfo()
	{
		return array(
			'bestsellerproducts',
			Mage::app()->getStore()->getId(),
			(int)Mage::app()->getStore()->isCurrentlySecure(),
			Mage::getDesign()->getPackageName(),
			Mage::getDesign()->getTheme('template'),
			Mage::app()->getStore()->getCurrentCurrencyCode(),
            Mage::getSingleton('customer/session')->getCustomerGroupId(),
			serialize($this->getData())
		);
	}
	
	public function _prepareLayout()
	{
	
		return parent::_prepareLayout();
	}

	protected function _toHtml()
	{	
		if($this->getData('choose_template')	==	'custom_template')
		{
			if($this->getData('custom_theme'))
				$this->setTemplate($this->getData('custom_theme'));	
			else 
				$this->setTemplate('em_bestseller_products/bestseller_custom.phtml');	
		}
		else
		{
			$this->setTemplate($this->getData('choose_template'));	
		}
		return parent::_toHtml();
	}
	
	public function getCategories()
	{
		$strCategories=  $this->getData('new_category');
		$arrCategories = explode(",", $strCategories);
		return $arrCategories;
	}
    
    /* --------*/
    public function getCacheLifeTime(){		
		return $this->getData('cache_lifetime');
	}
    
	public function getColumnCount(){
		return $this->getData('column_count');
	}
	
	public function getLimitCount(){
		return $this->getData('limit_count');
	}
    
    public function getThumbnailWidth(){
        $tempwidth = $this->getData('thumbnail_width');
        if (!(is_numeric($tempwidth)))
            $tempwidth = 150;
        return $tempwidth;
	}
    
    public function getThumbnailHeight(){
        $tempheight = $this->getData('thumbnail_height');
       if (!(is_numeric($tempheight)))
            $tempheight = 150;
        return $tempheight;
	}
	
	public function getItemWidth(){
        $tempwidth = $this->getData('item_width');
        if (!(is_numeric($tempwidth)))
            $tempwidth = null;
        return $tempwidth;
	}
    
    public function getItemHeight(){
        $tempheight = $this->getData('item_height');
       if (!(is_numeric($tempheight)))
            $tempheight = null;
        return $tempheight;
	}
	
	public function getItemSpacing(){
        $tempheight = $this->getData('item_spacing');
       if (!(is_numeric($tempheight)))
            $tempheight = null;
        return $tempheight;
	}
    
    public function ShowThumb(){
        return $this->getData('show_thumbnail');
	}
    
    public function getAltImg(){
        return $this->getData('alt_img');
	}
    
    public function ShowProductName(){
        return $this->getData('show_product_name');
	}
    
    public function ShowDesc(){
        return $this->getData('show_description');
	}
    
    public function ShowPrice(){
        return $this->getData('show_price');
	}
    
    public function ShowReview(){
        return $this->getData('show_reviews');
	}
    
    public function ShowAddtoCart(){
        return $this->getData('show_addtocart');
	}
    
    public function ShowAddto(){
        return $this->getData('show_addto');
	}
    
    public function ShowLabel(){
        return $this->getData('show_label');
	}

    protected function getBestsellerProduct()
	{		
		$strCategories = $this->getData('new_category');		
		$query = "
					SELECT DISTINCT * FROM  `".Mage::getSingleton('core/resource')->getTableName('catalog_product_entity')."` AS  `e` 
					INNER JOIN  `".Mage::getSingleton('core/resource')->getTableName('catalog_category_product_index')."` AS  `cat_index` ON cat_index.product_id = e.entity_id
					AND cat_index.store_id =1 AND cat_index.category_id
					IN ( ".$strCategories." ) 
				";
		$resource = Mage::getSingleton('core/resource');
		$readConnection = $resource->getConnection('core_read');
        return $readConnection->fetchAll($query);
	}
    
    public function getProductCollection(){
		$_bestseller_products = $this->getBestsellerProduct();
		$_temp_productIds = array();
        foreach ($_bestseller_products as $i => $_product){			
				$_temp_productIds[] = $_product['entity_id'];   
		}
     	$products= Mage::getModel('catalog/product')->getCollection()		
			 ->addAttributeToFilter('entity_id',array('in' => $_temp_productIds))
		    ->addAttributeToSelect('em_hot_sell')
			->addFieldToFilter(array(array('attribute' => 'em_hot_sell', 'eq' => true),));
		return $products;	
	}
}
?>
