<?php
/**
 * LogisticTransaction Model
 *
 */
class LogisticTransaction extends LogisticAppModel {

	public $name = 'LogisticTransaction';

    public $belongsTo = array(
        'User' => array(
            'className'  => 'User',
            'foreignKey' => 'user_id'
        ),
        'Crew' => array(
            'className'  => 'Crew',
            'foreignKey' => 'crew_id'
        ),
        'DoneBy' => array(
            'className'  => 'User',
            'foreignKey' => 'doneby_id'
        ),
        'LogisticStorage' => array(
            'className'  => 'LogisticStorage',
            'foreignKey' => 'logistic_storage_id'
        )
    );

	public function setRegistered($itemId=0, $bulkId=0, $amount=1, $userId) {
		$savedata['LogisticTransaction']['logistic_item_id'] = $itemId;
		$savedata['LogisticTransaction']['logistic_bulk_id'] = $bulkId;
		$savedata['LogisticTransaction']['amount'] = $amount;
		$savedata['LogisticTransaction']['logistic_status_id'] = 1;
		$savedata['LogisticTransaction']['doneby_id'] = $userId;
		$this->create();
		$this->save($savedata);
	}

	public function setInTransit($itemId=0, $bulkId=0, $amount=1, $userId, $donedate) {
		$savedata['LogisticTransaction']['logistic_item_id'] = $itemId;
		$savedata['LogisticTransaction']['logistic_bulk_id'] = $bulkId;
		$savedata['LogisticTransaction']['amount'] = $amount;
		$savedata['LogisticTransaction']['logistic_status_id'] = 2;
		$savedata['LogisticTransaction']['doneby_id'] = $userId;
		$savedata['LogisticTransaction']['donedate'] = $donedate;
		$this->create();
		$this->save($savedata);
	}


	public function setArrived($itemId=0, $bulkId=0, $amount=1, $userId, $storageId, $storageComment=0) {
		$savedata['LogisticTransaction']['logistic_item_id'] = $itemId;
		$savedata['LogisticTransaction']['logistic_bulk_id'] = $bulkId;
		$savedata['LogisticTransaction']['amount'] = $amount;
		$savedata['LogisticTransaction']['logistic_status_id'] = 3;
		$savedata['LogisticTransaction']['doneby_id'] = $userId;
		$savedata['LogisticTransaction']['logistic_storage_id'] = $storageId;
		$savedata['LogisticTransaction']['storage_comment'] = $storageComment;
		$this->create();
		$this->save($savedata);
	}

	public function setCheckedOut($itemId=0, $bulkId=0, $amount=1, $donebyId, $userId, $hand_out_comment, $storageId = NULL, $typeofUser = 'user') {
		$savedata['LogisticTransaction']['logistic_item_id'] = $itemId;
		$savedata['LogisticTransaction']['logistic_bulk_id'] = $bulkId;
		$savedata['LogisticTransaction']['amount'] = $amount;
		$savedata['LogisticTransaction']['logistic_status_id'] = 4;
		$savedata['LogisticTransaction']['doneby_id'] = $donebyId;
		if($typeofUser == 'user') {
		    $savedata['LogisticTransaction']['user_id'] = $userId;
        } elseif($typeofUser == 'crew') {
            $savedata['LogisticTransaction']['crew_id'] = $userId;
        }
		$savedata['LogisticTransaction']['hand_out_comment'] = $hand_out_comment;
		$savedata['LogisticTransaction']['logistic_storage_id'] = $storageId;
		$this->create();
		$this->save($savedata);
	}

	public function setCheckedIn($itemId=0, $bulkId=0, $amount=1, $donebyId, $storageId, $storageComment, $userId = 0, $typeofUser = 'user') {
		$savedata['LogisticTransaction']['logistic_item_id'] = $itemId;
		$savedata['LogisticTransaction']['logistic_bulk_id'] = $bulkId;
		$savedata['LogisticTransaction']['amount'] = $amount;
		$savedata['LogisticTransaction']['logistic_status_id'] = 5;
		$savedata['LogisticTransaction']['doneby_id'] = $donebyId;
		$savedata['LogisticTransaction']['logistic_storage_id'] = $storageId;
		$savedata['LogisticTransaction']['storage_comment'] = $storageComment;
        if($typeofUser == 'user') {
            $savedata['LogisticTransaction']['user_id'] = $userId;
        } elseif($typeofUser == 'crew') {
            $savedata['LogisticTransaction']['crew_id'] = $userId;
        }
		$this->create();
		$this->save($savedata);
	}

	public function setReturned($item_id=0, $bulk_id=0, $amount=1, $doneby_id) {
		$savedata['LogisticTransaction']['logistic_item_id'] = $item_id;
		$savedata['LogisticTransaction']['logistic_bulk_id'] = $bulk_id;
		$savedata['LogisticTransaction']['amount'] = $amount;
		$savedata['LogisticTransaction']['logistic_status_id'] = 6;
		$savedata['LogisticTransaction']['doneby_id'] = $doneby_id;
		$this->create();
		$this->save($savedata);
	}

	public function setMoved($itemId=0, $bulkId=0, $amount=1, $donebyId, $storageId, $storageComment, $prevStorageId = null) {
		$savedata['LogisticTransaction']['logistic_item_id'] = $itemId;
		$savedata['LogisticTransaction']['logistic_bulk_id'] = $bulkId;
		$savedata['LogisticTransaction']['amount'] = $amount;
		$savedata['LogisticTransaction']['logistic_status_id'] = 7;
		$savedata['LogisticTransaction']['doneby_id'] = $donebyId;
		$savedata['LogisticTransaction']['logistic_storage_id'] = $storageId;
		$savedata['LogisticTransaction']['storage_comment'] = $storageComment;
		$savedata['LogisticTransaction']['prev_logistic_storage_id'] = $prevStorageId;
		$this->create();
		$this->save($savedata);
	}

	public function setUnregistered($itemId=0, $bulkId=0, $amount=1, $donebyId) {
        $transactions = $this->find('all', array(
            'conditions' => array(
                'LogisticTransaction.logistic_item_id' => $itemId
            )
        ));
        if(!empty($transactions)) {
            foreach($transactions as $transaction) {
                $transaction['LogisticTransaction']['deleted'] = date('Y-m-d H:i:s');
                $this->save($transaction);
            }
        }
		$savedata['LogisticTransaction']['logistic_item_id'] = $itemId;
		$savedata['LogisticTransaction']['logistic_bulk_id'] = $bulkId;
		$savedata['LogisticTransaction']['amount'] = $amount;
		$savedata['LogisticTransaction']['logistic_status_id'] = 8;
		$savedata['LogisticTransaction']['doneby_id'] = $donebyId;
		$this->create();
		$this->save($savedata);
	}

	public function setReregistered($itemId=0, $bulkId=0, $amount=1, $donebyId) {
		$savedata['LogisticTransaction']['logistic_item_id'] = $itemId;
		$savedata['LogisticTransaction']['logistic_bulk_id'] = $bulkId;
		$savedata['LogisticTransaction']['amount'] = $amount;
		$savedata['LogisticTransaction']['logistic_status_id'] = 9;
		$savedata['LogisticTransaction']['doneby_id'] = $donebyId;
		$this->create();
		$this->save($savedata);
	}

	public function getLastStatusId($itemId=0, $bulkId=0) {
		return $this->query('SELECT logistic_status_id FROM wb4_logistic_transactions WHERE (logistic_item_id = '.$itemId.' AND logistic_bulk_id = 0) OR (logistic_item_id = 0 AND logistic_bulk_id = '.$bulkId.' ) ORDER BY id DESC LIMIT 1');
	}



}
