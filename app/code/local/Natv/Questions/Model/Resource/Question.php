<?php
class Natv_Questions_Model_Resource_Question extends Mage_Core_Model_Resource_Db_Abstract{	
	public function _construct(){
		$this->_init('questions/question', 'entity_id');
	}	
	public function lookupStoreIds($questionId){
		$adapter = $this->_getReadAdapter();
		$select  = $adapter->select()
			->from($this->getTable('questions/question_store'), 'store_id')
			->where('question_id = ?',(int)$questionId);
		return $adapter->fetchCol($select);
	}
	protected function _afterLoad(Mage_Core_Model_Abstract $object){
		if ($object->getId()) {
			$stores = $this->lookupStoreIds($object->getId());
			$object->setData('store_id', $stores);
		}
		return parent::_afterLoad($object);
	}
	protected function _getLoadSelect($field, $value, $object){
		$select = parent::_getLoadSelect($field, $value, $object);
		if ($object->getStoreId()) {
			$storeIds = array(Mage_Core_Model_App::ADMIN_STORE_ID, (int)$object->getStoreId());
			$select->join(
				array('questions_question_store' => $this->getTable('questions/question_store')),
				$this->getMainTable() . '.entity_id = questions_question_store.question_id',
				array()
			)
			->where('questions_question_store.store_id IN (?)', $storeIds)
			->order('questions_question_store.store_id DESC')
			->limit(1);
		}
		return $select;
	}
	protected function _afterSave(Mage_Core_Model_Abstract $object){
		$oldStores = $this->lookupStoreIds($object->getId());
		$newStores = (array)$object->getStores();
		if (empty($newStores)) {
			$newStores = (array)$object->getStoreId();
		}
		$table  = $this->getTable('questions/question_store');
		$insert = array_diff($newStores, $oldStores);
		$delete = array_diff($oldStores, $newStores);
		if ($delete) {
			$where = array(
				'question_id = ?' => (int) $object->getId(),
				'store_id IN (?)' => $delete
			);
			$this->_getWriteAdapter()->delete($table, $where);
		}
		if ($insert) {
			$data = array();
			foreach ($insert as $storeId) {
				$data[] = array(
					'question_id'  => (int) $object->getId(),
					'store_id' => (int) $storeId
				);
			}
			$this->_getWriteAdapter()->insertMultiple($table, $data);
		}
		return parent::_afterSave($object);
	}}