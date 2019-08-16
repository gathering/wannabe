<?php
/**
 * LogisticItem Model
 *
 * @property LogisticSupplier $LogisticSupplier
 * @property ItemTag $ItemTag
 * @property LogisticTag $LogisticTag
 */
class LogisticItem extends LogisticAppModel {
	public $displayField = 'name';
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notBlank'),
			),
		),
	);
	public $belongsTo = array('LogisticSupplier');
	public $hasAndBelongsToMany = array(
		'LogisticTag' => array(
			'className' => 'LogisticTag',
            'unique' => true
		)
	);
	public function afterFind($results) {
        foreach($results as & $result) {
            App::import('Model', 'Logistic.LogisticTransaction');
            $transactionModel = new LogisticTransaction();
            $transaction['LogisticTransaction'] = & $transactionModel->find('all', array(
                'conditions' => array(
                    'LogisticTransaction.logistic_item_id' => $result['LogisticItem']['id']
                ),
                'order' => 'LogisticTransaction.id DESC'
            ));
            $result = array_merge($result, $transaction);
		}
		return($results);
	}

    public function search($query) {
        $where = 'AND (LogisticItem.id='.(int)$query.'
                    OR LogisticBulk.id='.(int)$query.'
                    OR LogisticItem.AssetTag LIKE \'%'.addslashes($query).'%\'
                    OR LogisticItem.serialnumber LIKE \'%'.addslashes($query).'%\'
                    OR ((LogisticItem.description LIKE \'%'.addslashes($query).'%\'
                    OR LogisticBulk.name LIKE \'%'.addslashes($query).'%\'
                    OR LogisticItem.name LIKE \'%'.addslashes($query).'%\') AND LogisticItem.deleted = 0))';

        return $this->query('SELECT LogisticItem.*, LogisticBulk.*
                            FROM wb4_logistic_items LogisticItem
                            LEFT JOIN wb4_logistic_bulks LogisticBulk
                                    ON LogisticBulk.id=LogisticItem.logistic_bulk_id
                            WHERE 1 '.$where.' ORDER BY LogisticItem.name ASC');
    }

    public function findChildren($id,$list){
        $arr = array();
        foreach($list as $item){
            if($item['LogisticItem']['parent'] == $id){
                array_push($arr,$item);
            }
        }
        return $arr;
    }
    public function findParent($id,$list){
        foreach($list as $item){
            if($item['LogisticItem']['id'] == $id){
                return $item['LogisticItem']['parent'];
            }
        }
    }

    public function findAllChildren($id,$top=False){
        $subsection = $this->query('SELECT LogisticItem.*, LogisticBulk.*
                            FROM wb4_logistic_items LogisticItem
                            LEFT JOIN wb4_logistic_bulks LogisticBulk
                                    ON LogisticBulk.id=LogisticItem.logistic_bulk_id
                            WHERE LogisticItem.parent IS NOT NULL ORDER BY LogisticItem.name ASC');
        if($top){
            do{
                $tmp_id=$id;
                $id = $this->findParent($id,$subsection);
            }while($id !== null);
            $id=$tmp_id;
        }

        $children = $this->findChildren($id,$subsection);
        $arr = array();
        while(count($children) > 0){
            $child = array_shift($children);
            array_push($arr,$child);
            $temp_children = $this->findChildren($child['LogisticItem']['id'],$subsection);
            foreach($temp_children as $tchild){
                array_push($arr,$tchild);
            }
        }
        return $arr;
    }

    public function setDeleted($id) {
        $itemdata['LogisticItem']['id'] = $id;
        $itemdata['LogisticItem']['deleted'] = 1;
        $this->save($itemdata);
    }

    public function unDelete($id) {
        $itemdata['LogisticItem']['id'] = $id;
        $itemdata['LogisticItem']['deleted'] = 0;
        $this->save($itemdata);
    }

}
