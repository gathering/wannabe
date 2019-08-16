<?php

    class LostAndFoundController extends AppController {

        public $uses = array('LostAndFound', 'User');

        public function index() {

            $this->set('title_for_layout', __("Lost and Found"));

            $lost = $this->LostAndFound->find('all', array(
                'conditions' => array(
                    'LostAndFound.event_id' => $this->Wannabe->event->id,
                    'LostAndFound.type' => 0,
                    'LostAndFound.resolved' => '0000-00-00 00:00:00',
                    ),
                'order' => 'name ASC'
            ));

            $found = $this->LostAndFound->find('all', array(
                'conditions' => array(
                    'LostAndFound.event_id' => $this->Wannabe->event->id,
                    'LostAndFound.type' => 1,
                    'LostAndFound.resolved' => '0000-00-00 00:00:00',
                    ),
                'order' => 'name ASC'
            ));

            $resolved = $this->LostAndFound->find('all', array(
                'conditions' => array(
                    'LostAndFound.event_id' => $this->Wannabe->event->id,
                    'LostAndFound.resolved !=' => '0000-00-00 00:00:00',
                    ),
                'order' => 'name ASC'
            ));

            $this->set('found', $found);
            $this->set('lost', $lost);
            $this->set('resolved', $resolved);
        }

        public function add() {
            if($this->request->is('post')) {

                $this->request->data['LostAndFound']['event_id'] = $this->Wannabe->event->id;

                if($this->LostAndFound->save($this->request->data)){
                    $this->Flash->success(__("Item was successfully registered"));
                    $this->redirectEvent('/LostAndFound');
                }
                else {
                    $this->Flash->warning(__("Something went wrong"));
                }
            }

            $this->set('title_for_layout', __('Register new item'));
        }

        public function delete($id=0) {

            if($this->request->is('post')) {
                if($this->LostAndFound->delete($id)) {
                    $this->Flash->success(__("Item was deleted"));
                    $this->redirectEvent('/LostAndFound');
                }
            }

            if(!$id) {
                $this->Flash->warning(__("Select item to delete"));
                $this->redirectEvent('/LostAndFound');
            }

            $this->set('title_for_layout', __("Delete item"));
            $this->set('channel', $this->LostAndFound->find('first', array(
                'conditions' => array(
                    'LostAndFound.id' => $id
                    )
                )));

        }

        public function edit($id=0) {
            if($this->request->is('post')) {

                $this->request->data['LostAndFound']['event_id'] = $this->Wannabe->event->id;

                if($this->LostAndFound->save($this->request->data)){
                    $this->Flash->success(__("Item was successfully registered"));
                    $this->redirectEvent('/LostAndFound');
                }
                else {
                    $this->Flash->warning(__("Something went wrong"));
                }
            }

            if(!$id) {
                $this->Flash->warning(__("You must choose an item id"));
                $this->redirectEvent('/LostAndFound');
            }

            $item = $this->LostAndFound->find('first', array(
                'conditions' => array(
                    'LostAndFound.id' => $id,
                    'LostAndFound.event_id' => $this->Wannabe->event->id,
                ),
            ));

            $this->set('title_for_layout', __('Edit item'));
            $this->set('id', $item['LostAndFound']['id']);
            $this->set('item', $item);
        }

        public function view($id=0) {

            if(!$id) {
                $this->Flash->warning(__("You must choose an item id"));
                $this->redirectEvent('/LostAndFound');
            }

            $item = $this->LostAndFound->find('first', array(
                'conditions' => array(
                    'LostAndFound.id' => $id,
                    'LostAndFound.event_id' => $this->Wannabe->event->id,
                ),
            ));

            $realname = $this->User->find('first', array(
                'conditions' => array(
                    'User.id' => $item['LostAndFound']['resolved_by'],
                ),
            ));

            $this->set('title_for_layout', __('View item'));
            $this->set('item', $item);
            $this->set('realname', $realname);
        }

        public function resolve($id=0) {
            if($this->request->is('post')) {

                $now_date = new DateTime();
                $now = $now_date->format('Y-m-d H:i:s');

                $this->request->data['LostAndFound']['event_id'] = $this->Wannabe->event->id;
                $this->request->data['LostAndFound']['resolved'] = $now;

                if($this->LostAndFound->save($this->request->data)){
                    $this->Flash->success(__("Item was successfully resolved"));
                    $this->redirectEvent('/LostAndFound');
                }
                else {
                    $this->Flash->warning(__("Something went wrong"));
                }
            }

            if(!$id) {
                $this->Flash->warning(__("You must choose an item id"));
                $this->redirectEvent('/LostAndFound');
            }

            $item = $this->LostAndFound->find('first', array(
                'conditions' => array(
                    'LostAndFound.id' => $id,
                    'LostAndFound.event_id' => $this->Wannabe->event->id,
                    ''
                ),
            ));

            $this->set('title_for_layout', __('Resolve item'));
            $this->set('id', $item['LostAndFound']['id']);
            $this->set('item', $item);
        }

        public function search() {
            if($this->request->is('post')) {
                $items = $this->LostAndFound->search($this->request->data['LostAndFound']['query']);
            }

            $this->set('title_for_layout', __('Search results'));
            $this->set('items', $items);
        }
    }

?>
