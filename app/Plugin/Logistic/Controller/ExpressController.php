<?php

class ExpressController extends LogisticAppController
{
    public $uses = array('User', 'Logistic.LogisticItem', 'Logistic.LogisticBulk', 'Logistic.LogisticTransaction', 'Logistic.LogisticStorage', 'Crew', 'Badge');
    var $layout = 'responsive-default';


    public function index()
    {
        $this->redirectEvent('/Logistic/Express/checkout');
    }

    public function checkout()
    {
        $this->set('title_for_layout', __('Express Checkout'));
        $this->set('mode', 'checkout');
        $this->set('crews', $this->Crew->getAllCrews());
        $this->render('index');
    }

    public function checkin()
    {
        $this->set('storages', $this->LogisticStorage->find('list', array(
            'conditions' => array(
                'LogisticStorage.deleted' => 0,
                'LogisticStorage.type' => 'default',
                'LogisticStorage.logistic_location_id' => $this->Session->read('logisticLocationID')))));

        $this->set('title_for_layout', __('Express Checkin'));
        $this->set('mode', 'checkin');
        $this->set('box_into_header', array(
            'Header' => __('Other checkin options'),
            'Link' => array(
                array('class' => 'btn btn-default', 'href' => '/logistic/Express/unrig', 'title' => __('Unrig checkin')))));
        $this->set('crews', $this->Crew->getAllCrews());
        $this->render('index');
    }

    public function unrig()
    {
        $this->set('storages', $this->LogisticStorage->find('list', array(
            'conditions' => array(
                'LogisticStorage.deleted' => 0,
                'LogisticStorage.type' => 'unrig',
                'LogisticStorage.logistic_location_id' => $this->Session->read('logisticLocationID')))));

        $this->set('title_for_layout', __('Express Unrig'));
    }

    public function getUser($id = -1)
    {
        $this->layout = 'ajax';

        if(preg_match("/^([0-9A-F]{8,14})/",$id)) {
            $userId = $this->Badge->query("SELECT wb4_users.id FROM wb4_users LEFT JOIN wb4_badges ON wb4_users.id = wb4_badges.user_id WHERE wb4_badges.type = 'crew' AND wb4_badges.nfc_id = '".$id."' AND wb4_badges.active = 1 AND wb4_badges.event_id = ".WB::$event->id);
            $userId = @$userId[0]['wb4_users']['id'];
        } else {
            $userId = $id;
        }
        $user = $this->User->findById($userId);
        $this->set('user', $user);
    }
    public function getChildren($AssetTag){ 
        $this->layout = 'ajax';
        $item = $this->LogisticItem->find('first', array('conditions' => array(
            'LogisticItem.AssetTag' => $AssetTag,
            'LogisticItem.deleted' => 0)));
        $this->set('children', $this->LogisticItem->findAllChildren($item['LogisticItem']['id']));
    }


    public function getCrew($id = -1)
    {
        $this->layout = 'ajax';
        $crew = $this->Crew->findById($id);
        $this->set('crew', $crew);
    }


    public function getItem($AssetTag = -1)
    {
        $this->layout = 'ajax';
        $item = $this->LogisticItem->find('first', array('conditions' => array(
            'LogisticItem.AssetTag' => $AssetTag,
            'LogisticItem.deleted' => 0)));

        if (isset($item) and !$item) {
            $this->set('item', []);
            return;
        }
        $this->set('item', $item);
        $this->set('comment', $item['LogisticItem']['comment']);
        $this->set('storage_amounts', array());
        $this->set('storages', array());

        if (!$item['LogisticItem']['logistic_bulk_id']) {
            $this->set('type', 'item');
        } else {
            $bulk = $this->LogisticBulk->find('first', array('conditions' => array(
                'LogisticBulk.id' => $item['LogisticItem']['logistic_bulk_id'])));
            $this->set('type', $bulk['LogisticBulk']['type']);
            if ($bulk['LogisticBulk']['type'] == 'bulk') {
                /* We don't use comments for bulks; comments are used to
                 * describe the condition of an item, so it doesn't make
                 * sense to specify the condition of an entire bulk. */
                $this->set('comment', '');
                /* Get the storage location summary. */
                $this->set('storage_amounts', $this->LogisticBulk->getAmountsPerStorage($item, $bulk));
                /* Get the names of the storage locations. */
                $this->set('storages', $this->LogisticStorage->find('list', array(
                    'conditions' => array(
                        'LogisticStorage.deleted' => 0,
                        'LogisticStorage.logistic_location_id' => $this->Session->read('logisticLocationID')
                    ),
                    'order' => 'LogisticStorage.name ASC'
                )));
            }
        }
    }

    public function commit($mode)
    {
        if (!$this->request->is('post') || !in_array($mode, array('checkout', 'checkin'))) {
            return;
        }

       if($this->request->data['creworuser'] == 'user'){
            /* Check that the item user is valid, and abort if it's not. */
            $user = $this->User->findById($this->request->data['user-id']);
            if (count($user) == 0) {
                $this->Flash->error(__("Invalid user ID"));
                $this->redirectEvent('/Logistic/Express/'.$mode);
            }
            $user_id = $user['User']['id'];
       } elseif($this->request->data['creworuser'] == 'crew'){
           $crew = $this->Crew->findById($this->request->data['user-id']);
           if (count($crew) == 0) {
               $this->Flash->error(__("Invalid crew ID"));
               $this->redirectEvent('/Logistic/Express/'.$mode);
           }
           $user_id = $crew['Crew']['id'];
       }

        /* Check that all the AssetTags are valid, and get the associated items. */
        $items = array();
        foreach ($this->request->data['assetTags'] as $AssetTag) {
            $item = $this->LogisticItem->find('first', array('conditions' => array(
                'LogisticItem.AssetTag' => $AssetTag,
                'LogisticItem.deleted' => 0)));
            if (count($item) == 0) {
                $this->Flash->error(__("Invalid item AssetTag"));
                $this->redirectEvent('/Logistic/Express/'.$mode);
            }
            /* Get the corresponding bulk, if any. */
            if ($item['LogisticItem']['logistic_bulk_id']) {
                $item += $this->LogisticBulk->find('first', array('conditions' => array(
                    'LogisticBulk.id' => $item['LogisticItem']['logistic_bulk_id'])));
            }
            $items[] = $item;
        }
        //wired way of doing it, I know but this was the only way i was able to realiably add 
        //all children to the items array
        $items_copy = $items;
        foreach($items_copy as $i){
            foreach($this->LogisticItem->findAllChildren($i['LogisticItem']['id']) as $child){
                array_push($items,$child); 
            }
        }
        
        /* Create 'Checked out'/'Checked in' transactions for each of the items. */
        foreach ($items as $item) {
            $transactions = array();
            if ($item['LogisticItem']['logistic_bulk_id'] && $item['LogisticBulk']['type'] == 'bulk') {
                /* This is a bulk checkout -- make transactions for each
                 * separate storage that the bulk is checked out from or in to. */
                $total_amount_diff = 0;
                $amounts = $this->request->data['amounts'][strtolower($item['LogisticItem']['AssetTag'])];
                foreach ($amounts as $storage_id => $storage_amount) {
                    $transactions[] = array('storage_id' => $storage_id, 'storage_amount' => $storage_amount);
                    if ($mode == 'checkout') {
                        $total_amount_diff -= $storage_amount;
                    } else {
                        $total_amount_diff += $storage_amount;
                    }
                }
                /* Update the amount left on the bulk model. */
                $this->LogisticBulk->save(array('LogisticBulk' => array(
                    'id' => $item['LogisticBulk']['id'],
                    'amountleft' => $item['LogisticBulk']['amountleft'] + $total_amount_diff)));
            } else {
                $storage_id = null;
                if ($mode == 'checkin') {
                    $storage_id = $this->request->data['storage'][strtolower($item['LogisticItem']['AssetTag'])];
                }
                $transactions[] = array('storage_id' => $storage_id, 'storage_amount' => 1);
            }
            foreach ($transactions as $transaction) {
                if ($mode == 'checkout') {
                    $this->LogisticTransaction->setCheckedOut(
                        $item['LogisticItem']['id'],                /* The item to check out. */
                        $item['LogisticItem']['logistic_bulk_id'],  /* The corresponding bulk. */
                        $transaction['storage_amount'],             /* Amount. */
                        $this->Wannabe->user['User']['id'],         /* Done by the logged in user. */
                        $user_id,                                   /* User of the item. */
                        $user_id,                                   /* Receiver of the item. */
                        $transaction['storage_id'],                 /* Storage location. */
                        $this->request->data['creworuser']);        /* If user or crew */
                } else {
                    $this->LogisticTransaction->setCheckedIn(
                        $item['LogisticItem']['id'],                /* The item to check in. */
                        $item['LogisticItem']['logistic_bulk_id'],  /* The corresponding bulk. */
                        $transaction['storage_amount'],             /* Amount. */
                        $this->Wannabe->user['User']['id'],         /* Done by the logged in user. */
                        $transaction['storage_id'],                 /* Storage location. */
                        '',                                         /* Storage comment. */
                        $user_id,                                   /* User/Crew checking in the item. */
                        $this->request->data['creworuser']);        /* If user or crew */
                }
            }
        }

        /* If checking in, update conditions and comments for all single
         * items and series items (but not bulks). */
        if ($mode == 'checkin') {
            foreach ($items as $item) {
                if ($item['LogisticItem']['logistic_bulk_id'] && $item['LogisticBulk']['type'] == 'bulk') {
                    continue;
                }
                $AssetTag = strtolower($item['LogisticItem']['AssetTag']);
                $this->LogisticItem->save(array('LogisticItem' => array(
                    'id' => $item['LogisticItem']['id'],
                    'comment' => $this->request->data['comment'][$AssetTag],
                    'condition' => $this->request->data['condition'][$AssetTag])));
            }
        }

        /* Done; redirect the user. */
        if ($mode == 'checkout') {
            $this->Flash->success(__("The items were checked out"));
        } else {
            $this->Flash->success(__("The items were checked in"));
        }
        $this->redirectEvent('/Logistic/Express/'.$mode);
    }

    public function performUnrig($AssetTag)
    {
        $this->autoRender = false;

        /* Check that the AssetTag is valid, and get the associated item. */
        $item = $this->LogisticItem->find('first', array('conditions' => array(
            'LogisticItem.AssetTag' => $AssetTag,
            'LogisticItem.deleted' => 0)));
        if (count($item) == 0) {
            return json_encode(array('status' => 'error', 'error' => __('Invalid item AssetTag')));
        }

        /* Get the corresponding bulk, if any. */
        if ($item['LogisticItem']['logistic_bulk_id']) {
            $item += $this->LogisticBulk->find('first', array('conditions' => array(
                'LogisticBulk.id' => $item['LogisticItem']['logistic_bulk_id'])));

            /* Bail if bulk item. */
            if ($item['LogisticBulk']['type'] === 'bulk') {
                return json_encode(array('status' => 'error', 'error' => __('Bulk items are not supported')));
            }
        }

        /* Create 'Checked in' transaction for the item. */
        $storage_id = $this->request->query['storage_id'];
        $this->LogisticTransaction->setCheckedIn(
            $item['LogisticItem']['id'],                /* The item to check in. */
            $item['LogisticItem']['logistic_bulk_id'],  /* The corresponding bulk. */
            1,                                          /* Amount. */
            $this->Wannabe->user['User']['id'],         /* Done by the logged in user. */
            $storage_id,                                /* Storage location. */
            '',                                         /* Storage comment. */
            0);                                         /* User checking in the item. */

        return json_encode(array('status' => 'ok', 'item' => $item['LogisticItem']['name']));
    }
}

?>
