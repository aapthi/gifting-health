<?php 
$this->startSetup();
$table = $this->getConnection()
	->newTable($this->getTable('questions/question'))
	->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		'identity'  => true,
		'nullable'  => false,
		'primary'   => true,
		), 'Question ID')
	->addColumn('question', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		'nullable'  => false,
		), 'question')

	->addColumn('answer', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
		'nullable'  => false,
		), 'answer')

	->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		), 'Status')

	->addColumn('meta_title', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		), 'Meta title')

	->addColumn('meta_keywords', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
		), 'Meta keywords')

	->addColumn('meta_description', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
		), 'Meta description')

	->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
		), 'Question Creation Time')
	->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
		), 'Question Modification Time')
	->setComment('Question Table');
$this->getConnection()->createTable($table);

$table = $this->getConnection()
	->newTable($this->getTable('questions/question_store'))
	->addColumn('question_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
		'nullable'  => false,
		'primary'   => true,
		), 'Question ID')
	->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
		'unsigned'  => true,
		'nullable'  => false,
		'primary'   => true,
		), 'Store ID')
	->addIndex($this->getIdxName('questions/question_store', array('store_id')), array('store_id'))
	->addForeignKey($this->getFkName('questions/question_store', 'question_id', 'questions/question', 'entity_id'), 'question_id', $this->getTable('questions/question'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
	->addForeignKey($this->getFkName('questions/question_store', 'store_id', 'core/store', 'store_id'), 'store_id', $this->getTable('core/store'), 'store_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
	->setComment('Questions To Store Linkage Table');
$this->getConnection()->createTable($table);
$table = $this->getConnection()
	->newTable($this->getTable('questions/question_product'))
	->addColumn('rel_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Category ID')
	->addColumn('question_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		'unsigned'  => true,
		'nullable'  => false,
		'default'   => '0',
	), 'Question ID')
	->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		'unsigned'  => true,
		'nullable'  => false,
		'default'   => '0',
	), 'Product ID')
	->addColumn('position', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		'nullable'  => false,
		'default'   => '0',
	), 'Position')
	->addIndex($this->getIdxName('questions/question_product', array('product_id')), array('product_id'))
	->addForeignKey($this->getFkName('questions/question_product', 'question_id', 'questions/question', 'entity_id'), 'question_id', $this->getTable('questions/question'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
	->addForeignKey($this->getFkName('questions/question_product', 'product_id', 'catalog/product', 'entity_id'),	'product_id', $this->getTable('catalog/product'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
	->setComment('Question to Product Linkage Table');
$this->getConnection()->createTable($table);
$this->endSetup();