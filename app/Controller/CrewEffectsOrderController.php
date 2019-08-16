<?php

class CrewEffectsOrderController extends AppController {

    public $uses = array('CrewEffectsItem', 'CrewEffectsOrder', 'Acl');
    var $layout = "responsive-default";
    /*
     * User view to order effects
     */
    public function index() {
        // Get the items able to order
        $items = $this->CrewEffectsItem->find('all', array('conditions' => array(
            'CrewEffectsItem.event_id' => $this->Wannabe->event->id), 'order' => 'id ASC'));

        if(!$items)
            $this->set('noItems', __("You are not able to order any items"));

        if($this->request->is('post')) {
            $allSaved = true;

            for($i=0; $i < sizeof($this->request->data['CrewEffectsOrder']); $i++) {
                $this->request->data['CrewEffectsOrder'][$i]['user_id'] = $this->Wannabe->user['User']['id'];
                $this->request->data['CrewEffectsOrder'][$i]['event_id'] = $this->Wannabe->event->id;
                $item = $this->CrewEffectsItem->find('first', array(
                    'conditions' => array(
                        'CrewEffectsItem.id' => $this->request->data['CrewEffectsOrder'][$i]['item_id']
                    )
                ));
                if(!$item['CrewEffectsItem']['allow_order']) {
                    $this->Flash->warning(__("Your order has not been saved"));
                    $this->redirectEvent("/CrewEffectsOrder/");
                }
                if(isset($this->request->data['CrewEffectsOrder'][$i]['id'])) {
                    $this->CrewEffectsOrder->id = $this->request->data['CrewEffectsOrder'][$i]['id'];
                } else {
                    $this->CrewEffectsOrder->id = null;
                }

                if(!($this->CrewEffectsOrder->save($this->request->data['CrewEffectsOrder'][$i])))
                    $allSaved = false;
            }
            if($allSaved) {
                $this->Flash->success(__("Your order has been saved"));
                $this->redirectEvent("/CrewEffectsOrder/");
            }
        }

        // Convert size chart to array and get orders
        foreach($items as $item => $value) {
            $items[$item]['CrewEffectsItem']['sizes'] = explode(',', $value['CrewEffectsItem']['sizes']);
            $items[$item]['CrewEffectsItem']['sizes'] = array_combine(
                $items[$item]['CrewEffectsItem']['sizes'],$items[$item]['CrewEffectsItem']['sizes']);
            array_pop($items[$item]['CrewEffectsItem']['sizes']);

            $items[$item]['Order'] = $this->CrewEffectsOrder->find('first', array('conditions' => array(
                'CrewEffectsOrder.item_id' => $items[$item]['CrewEffectsItem']['id'],
                'CrewEffectsOrder.event_id' => $this->Wannabe->event->id,
                'CrewEffectsOrder.user_id' => $this->Wannabe->user['User']['id']
            )));
        }
        $this->set('title_for_layout', __("Order crew effects"));
        $this->set('items', $items);
    }

    /*
     * Economy view, register payments for effects
     */
    public function economy($userid = null, $paid = null) {
        if($userid != null && $paid != null) {
            $date = date('Y-m-d H:i:s');
            /*$temp = $this->CrewEffectsOrder->query("UPDATE wb4_crew_effects_orders SET paid='".$paid."',
                paid_time='".$date."'
                WHERE user_id='".$userid."';");
            die(var_dump($temp));*/
            $this->CrewEffectsOrder->query("UPDATE wb4_crew_effects_orders SET paid='".$paid."',
                paid_time='".$date."'
                WHERE user_id='".$userid."';");
                    //$this->Flash->error(__("Could not update"));
                    //$this->redirectEvent('/CrewEffectsOrder/economy');

                $this->set('date', strftime(__("%b %e %G, %H:%M"), strtotime($date)));
                $this->layout = "ajax";
                $this->render('economy-ajax');

        }
        $this->set('title_for_layout', __('Economy administration for crew effects'));

        $orders = $this->CrewEffectsOrder->query(
            'SELECT
                CrewEffectsOrder.id,
                CrewEffectsOrder.paid,
                CrewEffectsOrder.paid_time,
                User.id,
                User.nickname,
                User.realname,
                sum(CrewEffectsOrder.item_amount * CrewEffectsItem.price)
            FROM
                (
                    (wb4_users User JOIN wb4_crew_effects_orders CrewEffectsOrder)
                JOIN
                    wb4_crew_effects_items CrewEffectsItem)
            WHERE
                CrewEffectsOrder.item_id = CrewEffectsItem.id
            AND
                User.id = CrewEffectsOrder.user_id
            AND
                CrewEffectsOrder.event_id= '.$this->Wannabe->event->id.'
            GROUP BY
                User.id;
            ');

        // Delete entries with nothing to pay
        foreach($orders as $key=>$order) {
            if($order[0]['sum(CrewEffectsOrder.item_amount * CrewEffectsItem.price)'] == 0)
                unset($orders[$key]);
        }

        $this->set('orders', $orders);
    }

    /*
     * Logistics view for delivering effects, free and extra
     */
    public function logistics($action = null, $userid = null, $given = null) {
        if($action != "free" && $action != "extra") {
            $this->Flash->error(__("Error opening the requested site"));
            $this->redirectEvent('/CrewEffectsOrder/overview');
        }

        $this->set('action', $action);

        if($userid != null && $given != null) {
            if(!$this->CrewEffectsOrder->query('UPDATE wb4_crew_effects_orders SET given'.$action.'='.$given.'
                WHERE user_id='.$userid.';')) {
                    $this->Flash->error(__("Could not update"));
                    $this->redirectEvent('/CrewEffectsOrder/overview');
            }
        }

        $orders = $this->CrewEffectsOrder->query(
            'SELECT
                CrewEffectsOrder.id,
                CrewEffectsOrder.given'.$action.',
                CrewEffectsOrder.item_size,
                CrewEffectsOrder.item_amount,
                CrewEffectsOrder.paid,
                CrewEffectsItem.title,
                CrewEffectsItem.amount_free,
                User.id,
                User.nickname,
                User.realname
            FROM
                (
                    (wb4_users User JOIN wb4_crew_effects_orders CrewEffectsOrder)
                JOIN
                    wb4_crew_effects_items CrewEffectsItem)
            WHERE
                CrewEffectsOrder.item_id = CrewEffectsItem.id
            AND
                User.id = CrewEffectsOrder.user_id
            AND
                CrewEffectsOrder.event_id= '.$this->Wannabe->event->id.'
            ');

        // Prepare data for view
        $dataForView = array();
        $array = array();
        foreach($orders as $orderkey => $order) {
            foreach($orders as $itemkey => $item) {
                if($order['User']['id'] == $item['User']['id']) {
                    $array = array_merge($array, array($item['CrewEffectsItem']['title'] => ($action == "free" ? $item['CrewEffectsItem']['amount_free'] : $item['CrewEffectsOrder']['item_amount']).'('.$item['CrewEffectsOrder']['item_size'].')'));
                }
            }
            $array = array_merge($array, array('realname' => $order['User']['realname'],
                'nick' => $order['User']['nickname'],
                'given' => $order['CrewEffectsOrder']['given'.$action.''],
                'paid' => $order['CrewEffectsOrder']['paid']));

            $dataForView[$order['User']['id']] = $array;
            $array = array();
        }

        $itemTitles = $this->CrewEffectsItem->query('SELECT Items.title FROM wb4_crew_effects_items Items WHERE event_id='.$this->Wannabe->event->id.';');

        // Delete entries where no extra items are ordered
        if($action == "extra") {
            foreach($dataForView as $key => $entry) {
                $moreThanZero = false;
                foreach($itemTitles as $itemkey => $item) {
                    $itemAmount = explode('(', $entry[$item['Items']['title']]);
                        if($itemAmount[0] > 0)
                            $moreThanZero = true;
                }
                if(!$moreThanZero)
                    unset($dataForView[$key]);
            }
        }

        $this->set('itemTitles', $itemTitles);
        $this->set('data', $dataForView);
        if($action == "free")
            $this->set('title_for_layout', __('Deliver free crew effects'));
        else
            $this->set('title_for_layout', __('Deliver extra crew effects'));
    }

    /*
     * Login is not required to view amount of effects
     */
    public function beforeFilter() {
        if($this->request->params['action'] == 'overview')
            $this->requireLogin = false;

        parent::beforeFilter();
    }

    /*
     * Overview of ordered effects
     */
    public function overview() {
        $orders = $this->CrewEffectsOrder->query('
            SELECT Items.id, Items.title, Items.amount_free, Orders.item_size, Orders.item_amount
            FROM (wb4_crew_effects_orders Orders JOIN wb4_crew_effects_items Items)
            WHERE Orders.event_id='.$this->Wannabe->event->id.'
            AND Orders.item_id=Items.id
            ;');

        $items = $this->CrewEffectsItem->find('all', array('conditions' => array(
            'CrewEffectsItem.event_id' => $this->Wannabe->event->id), 'order' => 'id ASC'));

       // Convert sizes to array
        foreach($items as $item => $value) {
            $items[$item]['CrewEffectsItem']['sizes'] = explode(',', $value['CrewEffectsItem']['sizes']);
            $items[$item]['CrewEffectsItem']['sizes'] = array_combine(
                $items[$item]['CrewEffectsItem']['sizes'],$items[$item]['CrewEffectsItem']['sizes']);
            array_pop($items[$item]['CrewEffectsItem']['sizes']);
        }

        // Build data for view
        $dataForView = array();
        for($i=0; $i < sizeof($items); $i++) {
            $dataForView[$i] = array_merge(array('Title' => $items[$i]['CrewEffectsItem']['title']),$items[$i]['CrewEffectsItem']['sizes']);
            foreach($dataForView[$i] as $datakey => $data) {
                if($datakey != 'Title') {
                    $dataForView[$i][$datakey] = array('free' => 0, 'extra' => 0);
                }
                foreach($orders as $orderkey => $order) {
                    if(($items[$i]['CrewEffectsItem']['id'] == $order['Items']['id']) && ($datakey == $order['Orders']['item_size'])) {
                        $dataForView[$i][$datakey]['free'] = $dataForView[$i][$datakey]['free'] +
                            (1 * $order['Items']['amount_free']);
                        $dataForView[$i][$datakey]['extra'] = $dataForView[$i][$datakey]['extra'] +
                            (1 * $order['Orders']['item_amount']);
                    }
                }
            }
        }

        $acl = array(
            'economy' => $this->Acl->hasAccess('write', null, 'CrewEffectsOrder/economy'),
            'logistic' => $this->Acl->hasAccess('write', null, 'CrewEffectsOrder/logistics'),
            'items' => $this->Acl->hasAccess('manage', null, 'CrewEffectsItems'));

        $this->set('acl', $acl);
        $this->set('title_for_layout', __('Crew effects overview'));
        $this->set('data', $dataForView);
        $this->set('desc_for_layout', '');
        if(!$this->Auth->isLoggedIn)
            $this->layout = 'front-generic-long';
    }
}
