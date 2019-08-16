<?php
class TransactionController extends LogisticAppController {

    public $uses = array(
        'Logistic.LogisticTransaction',
        'Logistic.LogisticItem',
        'Logistic.LogisticBulk',
        'Logistic.LogisticStorage',
        'Logistic.LogisticStatus',
        'Logistic.LogisticTag',
        'User',
        'Crew'
    );

    var $layout = 'responsive-default';

    public function confirm() {
        if(isset($this->request->data['LogisticTransaction']['amount'])) {
            $item = $this->LogisticItem->findById($this->request->data['LogisticTransaction']['logistic_item_id']);
            $bulk = $this->LogisticBulk->findById($item['LogisticItem']['logistic_bulk_id']);
            if (!isset($this->request->data['LogisticTransaction']['logistic_storage_id']) ||
                $this->request->data['LogisticTransaction']['logistic_storage_id'] == '') {
                throw new BadRequestException(_('You need to specify a storage location'));
            }
            if ($this->request->data['LogisticTransaction']['logistic_status_id'] == $this->LogisticStatus->MOVED && (
                    !isset($this->request->data['LogisticTransaction']['prev_logistic_storage_id']) ||
                    $this->request->data['LogisticTransaction']['prev_logistic_storage_id'] == '')) {
                throw new BadRequestException(_('You need to specify a previous storage location'));
            }
            if($this->request->data['LogisticTransaction']['amount'] > $bulk['LogisticBulk']['amount']) {
                throw new BadRequestException(_('The number cannot be bigger than the number of registered units'));
            }
            if(($this->request->data['LogisticTransaction']['amount'] > $bulk['LogisticBulk']['amountleft']) && ($this->request->data['LogisticTransaction']['logistic_status_id'] == 4 || $this->request->data['LogisticTransaction']['logistic_status_id'] == 7)) {
                throw new BadRequestException(_('You cannot checkout more units than you got in storage'));
            }
            if(($this->request->data['LogisticTransaction']['amount'] > ($bulk['LogisticBulk']['amount'] - $bulk['LogisticBulk']['amountleft'])) && $this->request->data['LogisticTransaction']['logistic_status_id'] == 5) {
                throw new BadRequestException(_('You cannot check in more units than that are checked out'));
            }

        }

        /* Get the item, the user and the receiving user from the database, in order to show extra information on the confirmation screen. */
        if (isset($this->request->data['LogisticTransaction']['logistic_item_id'])) {
            $this->set('item', $this->LogisticItem->findById($this->request->data['LogisticTransaction']['logistic_item_id']));
        }
        if (isset($this->request->data['LogisticTransaction']['logistic_user_id'])) {
            $this->set('user', $this->User->findById($this->request->data['LogisticTransaction']['logistic_user_id']));
        }
        if (isset($this->request->data['LogisticTransaction']['logistic_hand_out_comment'])) {
            $this->set('hand_out_comment', $this->request->data['LogisticTransaction']['logistic_hand_out_comment']);
        }

        $this->set('storagelist', $this->LogisticStorage->find('list', array(
            'conditions' => array(
                'LogisticStorage.deleted' => 0,
                'LogisticStorage.logistic_location_id' => $this->Session->read('logisticLocationID')
            ),
            'order' => 'LogisticStorage.name ASC'
        )));
        $this->set('title_for_layout', __("Confirm transaction"));
        $this->set('statuslist', $this->LogisticStatus->find('list'));
        $this->set('transaction', $this->request->data);
    }

    public function confirmall() {
        /* Get the item, the user and the receiving user from the database, in order to show extra information on the confirmation screen. */
        if (isset($this->request->data['LogisticTransaction']['logistic_item_id'])) {
            $this->set('item', $this->LogisticItem->findById($this->request->data['LogisticTransaction']['logistic_item_id']));
        }
        if (isset($this->request->data['LogisticTransaction']['logistic_user_id'])) {
            $this->set('user', $this->User->findById($this->request->data['LogisticTransaction']['logistic_user_id']));
        }
        if (isset($this->request->data['LogisticTransaction']['logistic_hand_out_comment'])) {
            $this->set('hand_out_comment', $this->request->data['LogisticTransaction']['logistic_hand_out_comment']);

        }

        $this->set('storagelist', $this->LogisticStorage->find('list', array(
            'conditions' => array(
                'LogisticStorage.deleted' => 0,
                'LogisticStorage.logistic_location_id' => $this->Session->read('logisticLocationID')
            ),
            'order' => 'LogisticStorage.name ASC'
        )));
        $this->set('title_for_layout', __("Confirm transaction"));
        $this->set('statuslist', $this->LogisticStatus->find('list'));
        $this->set('transaction', $this->request->data);
    }

    public function confirmstorage() {
        if (isset($this->request->data['LogisticTransaction']['logistic_storage_id'])) {
            $this->set('storage', $this->LogisticStorage->findById($this->request->data['LogisticTransaction']['logistic_storage_id']));
            $this->LogisticTransaction->unbindModel(array('belongsTo' => array('User', 'DoneBy', 'LogisticStorage')));
            $tempstorageid = $this->LogisticTransaction->find('all', array(
                'conditions' => array(
                    'logistic_storage_id' => $this->request->data['LogisticTransaction']['logistic_storage_id']
                )
            ));
            $storage_ids = "";
            $itmatch = 0;
            if(is_array($tempstorageid) && !empty($tempstorageid)) {
                foreach($tempstorageid as $store_id) {
                    if($itmatch) {
                        $storage_ids .= " OR ";
                        $itmatch = 0;
                    }
                    $laststorage = $this->LogisticTransaction->query("SELECT id FROM wb4_logistic_transactions where logistic_item_id=".$store_id['LogisticTransaction']['logistic_item_id']." order by id desc limit 1");
                    foreach($tempstorageid as $temptempstorageid) {
                        foreach($laststorage as $tempstorage) {
                            if($tempstorage) {
                                if($tempstorage['wb4_logistic_transactions']['id'] == $temptempstorageid['LogisticTransaction']['id']) {
                                    $storage_ids = $storage_ids."logistic_item_id = ".$temptempstorageid['LogisticTransaction']['logistic_item_id'];
                                    $itmatch = 1;
                                }
                            }
                        }
                    }
                }
            }
            if(!$itmatch) $storage_ids .= "1 = 0";
            $matches = $this->LogisticItem->query('SELECT LogisticItem.* FROM wb4_logistic_items LogisticItem where LogisticItem.id in (select distinct logistic_item_id from wb4_logistic_transactions where ('.$storage_ids.'))');
            $bulk_names = array();

            if(!empty($matches)) {
                foreach($matches as &$match) {
                    $tags = $this->LogisticTag->query("select logistic_tag_id from wb4_logistic_items_logistic_tags where logistic_item_id={$match['LogisticItem']['id']}");
                    if(is_array($tags) && !empty($tags)) {
                        $match['LogisticTag'] = array();
                        foreach($tags as $tag) {
                            $match['LogisticTag'][] = $tag['wb4_logistic_items_logistic_tags']['logistic_tag_id'];
                        }
                    }
                    $match += $this->LogisticTransaction->find('first', array(
                                'conditions' => array(
                                    'logistic_item_id' => $match['LogisticItem']['id']
                                    ),
                                'order' => 'LogisticTransaction.created DESC'
                                ));
                    if($match['LogisticItem']['logistic_bulk_id'] > 0) {
                        if(isset($bulk_names[$match['LogisticItem']['logistic_bulk_id']])) {
                            $match['LogisticItem']['name'] = $bulk_names[$match['LogisticItem']['logistic_bulk_id']];
                        } else {
                            $bulk_name = $this->LogisticBulk->find('first', array(
                                        'conditions' => array(
                                            'LogisticBulk.id' => $match['LogisticItem']['logistic_bulk_id']
                                            )
                                        ));
                            $bulk_names[$match['LogisticItem']['logistic_bulk_id']] = $bulk_name['LogisticBulk']['name'];
                            $match['LogisticItem']['name'] = $bulk_name['LogisticBulk']['name'];
                        }
                    }
                }
            } else {
                throw new BadRequestException(__("Storage is empty, aborting"));
            }
        } else {
            throw new BadRequestException(__("No storage ID found, aborting"));
        }
        if (isset($this->request->data['LogisticTransaction']['logistic_user_id']) and $this->request->data['LogisticTransaction']['logistic_user_id'] != '') {
            $this->set('user', $this->User->findById($this->request->data['LogisticTransaction']['logistic_user_id']));
        }
        elseif (isset($this->request->data['LogisticTransaction']['logistic_crew_id']) and $this->request->data['LogisticTransaction']['logistic_crew_id'] != '') {
            $this->set('crew', $this->Crew->findById($this->request->data['LogisticTransaction']['logistic_crew_id']));
        }

        $this->set('storagelist', $this->LogisticStorage->find('list', array(
            'conditions' => array(
                'LogisticStorage.deleted' => 0,
                'LogisticStorage.logistic_location_id' => $this->Session->read('logisticLocationID')
            ),
            'order' => 'LogisticStorage.name ASC'
        )));
        $this->set('title_for_layout', __("Confirm transaction"));
        $this->set('statuslist', $this->LogisticStatus->find('list'));
        $this->set('transaction', $this->request->data);
    }

    public function applystorage() {
        if(!$this->request->data)
            throw new BadRequestException(_('No direct access'));
        if(isset($this->request->data['confirm'])) {
            $this->LogisticTransaction->unbindModel(array('belongsTo' => array('User', 'DoneBy', 'LogisticStorage', 'Crew')));
            $tempstorageid = $this->LogisticTransaction->find('all', array(
                'conditions' => array(
                    'logistic_storage_id' => $this->request->data['LogisticTransaction']['logistic_storage_id']
                )
            ));
            $storage_ids = "";
            $itmatch = 0;
            if(is_array($tempstorageid) && !empty($tempstorageid)) {
                foreach($tempstorageid as $store_id) {
                    if($itmatch) {
                        $storage_ids .= " OR ";
                        $itmatch = 0;
                    }
                    $laststorage = $this->LogisticTransaction->query("SELECT id FROM wb4_logistic_transactions where logistic_item_id=".$store_id['LogisticTransaction']['logistic_item_id']." order by id desc limit 1");
                    foreach($tempstorageid as $temptempstorageid) {
                        foreach($laststorage as $tempstorage) {
                            if($tempstorage) {
                                if($tempstorage['wb4_logistic_transactions']['id'] == $temptempstorageid['LogisticTransaction']['id']) {
                                    $storage_ids = $storage_ids."logistic_item_id = ".$temptempstorageid['LogisticTransaction']['logistic_item_id'];
                                    $itmatch = 1;
                                }
                            }
                        }
                    }
                }
            }
            if(!$itmatch) $storage_ids .= "1 = 0";
            $matches = $this->LogisticItem->query('SELECT LogisticItem.* FROM wb4_logistic_items LogisticItem where LogisticItem.id in (select distinct logistic_item_id from wb4_logistic_transactions where ('.$storage_ids.'))');
            $bulk_names = array();

            if(!empty($matches)) {
                foreach($matches as &$match) {
                    $tags = $this->LogisticTag->query("select logistic_tag_id from wb4_logistic_items_logistic_tags where logistic_item_id={$match['LogisticItem']['id']}");
                    if(is_array($tags) && !empty($tags)) {
                        $match['LogisticTag'] = array();
                        foreach($tags as $tag) {
                            $match['LogisticTag'][] = $tag['wb4_logistic_items_logistic_tags']['logistic_tag_id'];
                        }
                    }
                    $match += $this->LogisticTransaction->find('first', array(
                                'conditions' => array(
                                    'logistic_item_id' => $match['LogisticItem']['id']
                                    ),
                                'order' => 'LogisticTransaction.created DESC'
                                ));
                    if($match['LogisticItem']['logistic_bulk_id'] > 0) {
                        if(isset($bulk_names[$match['LogisticItem']['logistic_bulk_id']])) {
                            $match['LogisticItem']['name'] = $bulk_names[$match['LogisticItem']['logistic_bulk_id']];
                        } else {
                            $bulk_name = $this->LogisticBulk->find('first', array(
                                        'conditions' => array(
                                            'LogisticBulk.id' => $match['LogisticItem']['logistic_bulk_id']
                                            )
                                        ));
                            $bulk_names[$match['LogisticItem']['logistic_bulk_id']] = $bulk_name['LogisticBulk']['name'];
                            $match['LogisticItem']['name'] = $bulk_name['LogisticBulk']['name'];
                        }
                    }
                }
            } else {
                throw new BadRequestException(__("Storage is empty, aborting"));
            }
            foreach($matches as $item) {
                $bulk = $this->LogisticBulk->findById($item['LogisticItem']['logistic_bulk_id']);
                $amount = 0;
                if(!empty($bulk)) {
                    $bulkdata['LogisticBulk']['id'] = $bulk['LogisticBulk']['id'];
                    $bulkdata['LogisticBulk']['amountleft'] = 0;
                    $this->LogisticBulk->save($bulkdata);
                    $amount = $bulk['LogisticBulk']['amountleft'];
                }

                if(!isset($this->request->data['LogisticTransaction']['logistic_hand_out_comment'])){
                    $this->request->data['LogisticTransaction']['logistic_hand_out_comment'] = '';
                }

                if(isset($this->request->data['LogisticTransaction']['logistic_user_id']) and $this->request->data['LogisticTransaction']['logistic_user_id'] != '') {
                    $user_id = $this->request->data['LogisticTransaction']['logistic_user_id'];
                    $userorcrew = 'user';
                } elseif (isset($this->request->data['LogisticTransaction']['logistic_crew_id']) and $this->request->data['LogisticTransaction']['logistic_crew_id'] != 0){
                    $user_id = $this->request->data['LogisticTransaction']['logistic_crew_id'];
                    $userorcrew = 'crew';
                }
                $this->LogisticTransaction->setCheckedOut($item['LogisticItem']['id'], $item['LogisticItem']['logistic_bulk_id'], $amount, $this->Wannabe->user['User']['id'],
                        $user_id, $this->request->data['LogisticTransaction']['logistic_hand_out_comment'],'', $userorcrew);
            }
            $this->Flash->success(__("Transaction successful"));
        } else {
            $this->Flash->info(__("Transaction aborted"));
        }

        $this->redirectEvent($this->request->data['Redirect']['path']);
    }

    public function apply() {
        if(!$this->request->data)
            throw new BadRequestException(_('No direct access'));
        if(isset($this->request->data['confirm'])) {
            $status = $this->request->data['LogisticTransaction']['logistic_status_id'];
            if(!$status && $this->request->data) {
                $transaction = $this->LogisticTransaction->getLastStatusId($this->request->data['LogisticTransaction']['logistic_item_id']);
                if($transaction[0]['logistic_transactions']['logistic_status_id'] <= 2) $status = 3;
                else $status = 5;
            }
            if(!isset($this->request->data['LogisticTransaction']['amount'])) {
                $amount = 1;
            } else {
                $amount = $this->request->data['LogisticTransaction']['amount'];
            }
            switch($status) {
                //Register
                case 1:
                    $this->LogisticTransaction->setRegistered($this->request->data['LogisticTransaction']['logistic_item_id'], $this->request->data['LogisticTransaction']['logistic_bulk_id'], $amount, $this->Wannabe->user['User']['id']);
                    break;
                    //In transit
                case 2:
                    $this->LogisticTransaction->setInTransit($this->request->data['LogisticTransaction']['logistic_item_id'], $this->request->data['LogisticTransaction']['logistic_bulk_id'],   $amount, $this->Wannabe->user['User']['id'],
                            $this->request->data['LogisticTransaction']['donedate']);
                    break;
                    //Arrived
                case 3:
                    $this->LogisticTransaction->setArrived($this->request->data['LogisticTransaction']['logistic_item_id'], $this->request->data['LogisticTransaction']['logistic_bulk_id'],   $amount, $this->Wannabe->user['User']['id'],
                            $this->request->data['LogisticTransaction']['logistic_storage_id'], $this->request->data['LogisticTransaction']['storage_comment']);
                    if(isset($this->request->data['LogisticTransaction']['amount'])) {
                        $item = $this->LogisticItem->findById($this->request->data['LogisticTransaction']['logistic_item_id']);
                        $bulk = $this->LogisticBulk->findById($item['LogisticItem']['logistic_bulk_id']);
                        $bulkdata['LogisticBulk']['id'] = $bulk['LogisticBulk']['id'];
                        $bulkdata['LogisticBulk']['amountleft'] = $this->request->data['LogisticTransaction']['amount'];
                        $this->LogisticBulk->save($bulkdata);
                    }
                    break;
                    //Checked out

                case 4:
                    if(!isset($this->request->data['LogisticTransaction']['logistic_bulk_id'])) {
                        $this->request->data['LogisticTransaction']['logistic_bulk_id'] = null;
                    }
                    if(!isset($this->request->data['LogisticTransaction']['logistic_storage_id']))
                        $this->request->data['LogisticTransaction']['logistic_storage_id'] = null;

                    $this->LogisticTransaction->setCheckedOut($this->request->data['LogisticTransaction']['logistic_item_id'], $this->request->data['LogisticTransaction']['logistic_bulk_id'], $amount, $this->Wannabe->user['User']['id'],
                    $this->request->data['LogisticTransaction']['logistic_user_id'], $this->request->data['LogisticTransaction']['logistic_hand_out_comment'], $this->request->data['LogisticTransaction']['logistic_storage_id']);

                    if(isset($this->request->data['LogisticTransaction']['amount'])) {
                        $item = $this->LogisticItem->findById($this->request->data['LogisticTransaction']['logistic_item_id']);
                        $bulk = $this->LogisticBulk->findById($item['LogisticItem']['logistic_bulk_id']);
                        $bulkdata['LogisticBulk']['id'] = $bulk['LogisticBulk']['id'];
                        $bulkdata['LogisticBulk']['amountleft'] = ($bulk['LogisticBulk']['amountleft'] - $this->request->data['LogisticTransaction']['amount']);
                        $this->LogisticBulk->save($bulkdata);
                    }
                    break;
                    //Checked in
                case 5:
                    $this->LogisticTransaction->setCheckedIn($this->request->data['LogisticTransaction']['logistic_item_id'], $this->request->data['LogisticTransaction']['logistic_bulk_id'], $amount, $this->Wannabe->user['User']['id'],
                            $this->request->data['LogisticTransaction']['logistic_storage_id'], $this->request->data['LogisticTransaction']['storage_comment']);
                    if(isset($this->request->data['LogisticTransaction']['amount'])) {
                        $item = $this->LogisticItem->findById($this->request->data['LogisticTransaction']['logistic_item_id']);
                        $bulk = $this->LogisticBulk->findById($item['LogisticItem']['logistic_bulk_id']);
                        $bulkdata['LogisticBulk']['id'] = $bulk['LogisticBulk']['id'];
                        $bulkdata['LogisticBulk']['amountleft'] = ($bulk['LogisticBulk']['amountleft'] + $this->request->data['LogisticTransaction']['amount']);
                        $this->LogisticBulk->save($bulkdata);
                    }
                    break;
                    //Returned
                case 6:
                    $this->LogisticTransaction->setReturned($this->request->data['LogisticTransaction']['logistic_item_id'], $this->request->data['LogisticTransaction']['logistic_bulk_id'],   $amount, $this->Wannabe->user['User']['id']);
                    if(isset($this->request->data['LogisticTransaction']['amount'])) {
                        $item = $this->LogisticItem->findById($this->request->data['LogisticTransaction']['logistic_item_id']);
                        $bulk = $this->LogisticBulk->findById($item['LogisticItem']['logistic_bulk_id']);
                        $bulkdata['LogisticBulk']['id'] = $bulk['LogisticBulk']['id'];
                        $bulkdata['LogisticBulk']['amountleft'] = 0;
                        $this->LogisticBulk->save($bulkdata);
                    }
                    break;
                    //Moved
                case 7:
                    $this->LogisticTransaction->setMoved($this->request->data['LogisticTransaction']['logistic_item_id'], $this->request->data['LogisticTransaction']['logistic_bulk_id'],   $amount, $this->Wannabe->user['User']['id'],
                            $this->request->data['LogisticTransaction']['logistic_storage_id'], $this->request->data['LogisticTransaction']['storage_comment'],
                            $this->request->data['LogisticTransaction']['prev_logistic_storage_id']);
                    break;
                    //Unregistered
                case 8:
                    $this->LogisticTransaction->setUnregistered($this->request->data['LogisticTransaction']['logistic_item_id'], $this->request->data['LogisticTransaction']['logistic_bulk_id'],   $amount, $this->Wannabe->user['User']['id']);
                    $item = $this->LogisticItem->findById($this->request->data['LogisticTransaction']['logistic_item_id']);
                    $this->LogisticItem->setDeleted($item['LogisticItem']['id']);
                    if($item['LogisticItem']['logistic_bulk_id']) {
                        $bulk = $this->LogisticBulk->findById($item['LogisticItem']['logistic_bulk_id']);
                        if($bulk['LogisticBulk']['type'] == 'bulk') {
                            $this->LogisticBulk->setDeleted($bulk['LogisticBulk']['id']);
                        }
                    }
                    break;
                    //Reregistered
                case 9:
                    $this->LogisticTransaction->setReregistered($this->request->data['LogisticTransaction']['logistic_item_id'], $this->request->data['LogisticTransaction']['logistic_bulk_id'],   $amount, $this->Wannabe->user['User']['id']);
                    $item = $this->LogisticItem->findById($this->request->data['LogisticTransaction']['logistic_item_id']);
                    $this->LogisticItem->unDelete($item['LogisticItem']['id']);
                    if($item['LogisticItem']['logistic_bulk_id']) {
                        $bulk = $this->LogisticBulk->findById($item['LogisticItem']['logistic_bulk_id']);
                        if($bulk['LogisticBulk']['type'] == 'bulk') {
                            $amount = 0;
                            if(isset($this->request->data['LogisticTransaction']['amount']))
                                $amount = $this->request->data['LogisticTransaction']['amount'];
                            $this->LogisticBulk->unDelete($bulk['LogisticBulk']['id'], $amount);
                        }
                    }
                    break;
            }
            $this->Flash->success(__("Transaction successful"));
        } else {
            $this->Flash->info(__("Transaction aborted"));
        }

        $this->redirectEvent($this->request->data['Redirect']['path']);
    }


    public function applyall() {
        if(!$this->request->data)
            throw new BadRequestException(_('No direct access'));

        if(isset($this->request->data['confirm'])) {
            $status = $this->request->data['LogisticTransaction']['logistic_status_id'];
            if($status != 9) {
                $items = $this->LogisticItem->find('all', array(
                    'conditions' => array(
                        'LogisticItem.logistic_bulk_id' => $this->request->data['LogisticTransaction']['logistic_bulk_id'],
                        'LogisticItem.deleted' => 0
                    )
                ));
            } else {
                $items = $this->LogisticItem->find('all', array(
                    'conditions' => array(
                        'LogisticItem.logistic_bulk_id' => $this->request->data['LogisticTransaction']['logistic_bulk_id']
                    )
                ));
            }
            if(!isset($this->request->data['LogisticTransaction']['amount'])) {
                $amount = 1;
            } else {
                $amount = $this->request->data['LogisticTransaction']['amount'];
            }
            foreach($items as $item) {
                $this->request->data['LogisticTransaction']['logistic_item_id'] = $item['LogisticItem']['id'];
                if(!$status && $this->request->data) {
                    $transaction = $this->LogisticTransaction->getLastStatusId($this->request->data['LogisticTransaction']['logistic_item_id']);
                    if($transaction[0]['logistic_transactions']['logistic_status_id'] <= 2) $status = 3;
                    else $status = 5;
                }
                if($status != 9 && $item['LogisticItem']['deleted']) continue;
                switch($status) {
                    //Register
                    case 1:
                        $this->LogisticTransaction->setRegistered($this->request->data['LogisticTransaction']['logistic_item_id'], $this->request->data['LogisticTransaction']['logistic_bulk_id'], $amount, $this->Wannabe->user['User']['id']);
                        break;
                        //In transit
                    case 2:
                        $this->LogisticTransaction->setInTransit($this->request->data['LogisticTransaction']['logistic_item_id'], $this->request->data['LogisticTransaction']['logistic_bulk_id'],   $amount, $this->Wannabe->user['User']['id'],
                                $this->request->data['LogisticTransaction']['donedate']);
                        break;
                        //Arrived
                    case 3:
                        $this->LogisticTransaction->setArrived($this->request->data['LogisticTransaction']['logistic_item_id'], $this->request->data['LogisticTransaction']['logistic_bulk_id'],   $amount, $this->Wannabe->user['User']['id'],
                                $this->request->data['LogisticTransaction']['logistic_storage_id'], $this->request->data['LogisticTransaction']['storage_comment']);
                        if(isset($this->request->data['LogisticTransaction']['amount'])) {
                            $item = $this->LogisticItem->findById($this->request->data['LogisticTransaction']['logistic_item_id']);
                            $bulk = $this->LogisticBulk->findById($item['LogisticItem']['logistic_bulk_id']);
                            $bulkdata['LogisticBulk']['id'] = $bulk['LogisticBulk']['id'];
                            $bulkdata['LogisticBulk']['amountleft'] = $this->request->data['LogisticTransaction']['amount'];
                            $this->LogisticBulk->save($bulkdata);
                        }
                        break;
                        //Checked out
                    case 4:
                        $this->LogisticTransaction->setCheckedOut($this->request->data['LogisticTransaction']['logistic_item_id'], $this->request->data['LogisticTransaction']['logistic_bulk_id'],   $amount, $this->Wannabe->user['User']['id'],
                            $this->request->data['LogisticTransaction']['logistic_user_id'],$this->request->data['LogisticTransaction']['logistic_hand_out_comment']);

                        if(isset($this->request->data['LogisticTransaction']['amount'])) {
                            $item = $this->LogisticItem->findById($this->request->data['LogisticTransaction']['logistic_item_id']);
                            $bulk = $this->LogisticBulk->findById($item['LogisticItem']['logistic_bulk_id']);
                            $bulkdata['LogisticBulk']['id'] = $bulk['LogisticBulk']['id'];
                            $bulkdata['LogisticBulk']['amountleft'] = ($bulk['LogisticBulk']['amountleft'] - $this->request->data['LogisticTransaction']['amount']);
                            $this->LogisticBulk->save($bulkdata);
                        }
                        break;
                        //Checked in
                    case 5:
                        $this->LogisticTransaction->setCheckedIn($this->request->data['LogisticTransaction']['logistic_item_id'], $this->request->data['LogisticTransaction']['logistic_bulk_id'],   $amount, $this->Wannabe->user['User']['id'],
                                $this->request->data['LogisticTransaction']['logistic_storage_id'], $this->request->data['LogisticTransaction']['storage_comment']);
                        if(isset($this->request->data['LogisticTransaction']['amount'])) {
                            $item = $this->LogisticItem->findById($this->request->data['LogisticTransaction']['logistic_item_id']);
                            $bulk = $this->LogisticBulk->findById($item['LogisticItem']['logistic_bulk_id']);
                            $bulkdata['LogisticBulk']['id'] = $bulk['LogisticBulk']['id'];
                            $bulkdata['LogisticBulk']['amountleft'] = ($bulk['LogisticBulk']['amountleft'] + $this->request->data['LogisticTransaction']['amount']);
                            $this->LogisticBulk->save($bulkdata);
                        }
                        break;

                        //Returned
                    case 6:
                        $this->LogisticTransaction->setReturned($this->request->data['LogisticTransaction']['logistic_item_id'], $this->request->data['LogisticTransaction']['logistic_bulk_id'],   $amount, $this->Wannabe->user['User']['id']);
                        if(isset($this->request->data['LogisticTransaction']['amount'])) {
                            $item = $this->LogisticItem->findById($this->request->data['LogisticTransaction']['logistic_item_id']);
                            $bulk = $this->LogisticBulk->findById($item['LogisticItem']['logistic_bulk_id']);
                            $bulkdata['LogisticBulk']['id'] = $bulk['LogisticBulk']['id'];
                            $bulkdata['LogisticBulk']['amountleft'] = 0;
                            $this->LogisticBulk->save($bulkdata);
                        }
                        break;
                        //Moved
                    case 7:
                        $this->LogisticTransaction->setMoved($this->request->data['LogisticTransaction']['logistic_item_id'], $this->request->data['LogisticTransaction']['logistic_bulk_id'],   $amount, $this->Wannabe->user['User']['id'],$this->request->data['LogisticTransaction']['logistic_storage_id'], $this->request->data['LogisticTransaction']['storage_comment']);
                        break;
                        //Unregistered
                    case 8:
                        $this->LogisticTransaction->setUnregistered($this->request->data['LogisticTransaction']['logistic_item_id'], $this->request->data['LogisticTransaction']['logistic_bulk_id'],   $amount, $this->Wannabe->user['User']['id']);
                        $item = $this->LogisticItem->findById($this->request->data['LogisticTransaction']['logistic_item_id']);
                        $this->LogisticItem->setDeleted($item['LogisticItem']['id']);
                        if($item['LogisticItem']['logistic_bulk_id']) {
                            $bulk = $this->LogisticBulk->findById($item['LogisticItem']['logistic_bulk_id']);
                            $this->LogisticBulk->setDeleted($bulk['LogisticBulk']['id']);
                        }
                        break;
                        //Reregistered
                    case 9:
                        $amount = 0;
                        if(isset($this->request->data['LogisticTransaction']['amount']))
                            $amount = $this->request->data['LogisticTransaction']['amount'];
                        $this->LogisticTransaction->setReregistered($this->request->data['LogisticTransaction']['logistic_item_id'], $this->request->data['LogisticTransaction']['logistic_bulk_id'],   $amount, $this->Wannabe->user['User']['id']);
                        $item = $this->LogisticItem->findById($this->request->data['LogisticTransaction']['logistic_item_id']);
                        $this->LogisticItem->unDelete($item['LogisticItem']['id']);
                        if($item['LogisticItem']['logistic_bulk_id']) {
                            $bulk = $this->LogisticBulk->findById($item['LogisticItem']['logistic_bulk_id']);
                            $this->LogisticBulk->unDelete($bulk['LogisticBulk']['id'], $amount);
                        }
                        break;
                }
            }
            $this->Flash->success(__("Transaction successful"));
        } else {
            $this->Flash->info(__("Transaction aborted"));
        }
        $this->redirectEvent($this->request->data['Redirect']['path']);
    }
}
