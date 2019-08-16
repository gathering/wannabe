<?php
class ItemController extends LogisticAppController {
    public $uses = array('Logistic.LogisticItem', 'Logistic.LogisticTag', 'Logistic.LogisticStorage', 'Logistic.LogisticBulk', 'Logistic.LogisticSupplier', 'Logistic.LogisticTransaction','Logistic.LogisticStatus','User');

    var $layout = 'responsive-default';

    public function beforeRender() {
        parent::beforeRender();
        CakeSession::write('LogisticTab', 'search');
        if(!$this->Session->check('logisticLocationID')) {
            $this->Session->write('logisticLocationRedir', $this->here);
            $this->redirectEvent('/logistic');
        }
    }
    public function create($confirm=false) {
        if($confirm) {
            $lastitem = $this->LogisticItem->find('all', array(
                'order' => 'LogisticItem.created DESC',
                'limit' => 1
            ));
            $url = '/logistic/Item/view/';
            if($lastitem[0]['LogisticItem']['logistic_bulk_id']) $url = '/logistic/Bulk/view/'.$lastitem[0]['LogisticItem']['logistic_bulk_id'];
            else $url .= $lastitem[0]['LogisticItem']['id'];
            $this->Flash->success(__("Your registration was saved, press %s to view the registration","<a href='/{$this->Wannabe->event->reference}{$url}'>".__("here")."</a>"));
        }
        $this->set('title_for_layout', __("Create item"));
    }
    public function createNew() {
        if($this->request->is('post')) {
            if(isset($this->request->data['Item']['AssetTag'])) {
                $item = $this->LogisticItem->find('first', array(
                    'conditions' => array(
                        'LogisticItem.AssetTag' => $this->request->data['Item']['AssetTag']
                    )
                ));
                if(!empty($item)) {
                    if($item['LogisticItem']['deleted']) {
                        $this->LogisticItem->unDelete($item['LogisticItem']['id']);
                        $this->LogisticTransaction->setReregistered($item['LogisticItem']['id'], 0, 0, $this->Wannabe->user['User']['id']);
                        $this->Flash->info(__("Item exists, but deactivated. Item has been reactivated."));
                        $this->redirectEvent('/Logistic/Item/view/'.$item['LogisticItem']['id']);
                    } else {
                        throw new BadRequestException(__("Item with AssetTag already exists: %s", $this->request->data['Item']['AssetTag']));
                    }
                } else {
                    $this->set('AssetTag', $this->request->data['Item']['AssetTag']);
                }
            }
        } else {
            $this->redirectEvent('/Logistic/Item/create');
        }
        $this->set('title_for_layout', __("Create item"));
        $this->set('tags', $this->LogisticItem->LogisticTag->find('list'));
        $this->set('unrig_storages', $this->LogisticStorage->find('list', array(
            'conditions' => array(
                'LogisticStorage.deleted' => 0,
                'LogisticStorage.type' => 'unrig'
            ),
            'order' => 'LogisticStorage.name ASC'
        )));
        $this->set('storages', $this->LogisticStorage->find('list', array(
            'conditions' => array(
                'LogisticStorage.deleted' => 0,
                'LogisticStorage.type' => 'default',
                'LogisticStorage.logistic_location_id' => $this->Session->read('logisticLocationID')
            ),
            'order' => 'LogisticStorage.name ASC'
        )));
        $this->set('suppliers', $this->LogisticSupplier->find('list', array(
            'fields' => array('LogisticSupplier.id', 'LogisticSupplier.company'))));
    }

    public function view($id=0) {
        if(!$id)
            $this->redirectEvent('/logistic');

        $item = $this->LogisticItem->find('first', array(
            'conditions' => array(
                'LogisticItem.id' => $id
            )
        ));
        if(isset($item['LogisticItem']['logistic_bulk_id']) && $item['LogisticItem']['logistic_bulk_id']) {
            $bulk = $this->LogisticBulk->find('first', array(
                'conditions' => array(
                    'LogisticBulk.id' => $item['LogisticItem']['logistic_bulk_id']
                )
            ));
            if($bulk['LogisticBulk']['type'] == 'bulk') {
                $this->redirectEvent('/logistic/Bulk/view/'.$item['LogisticItem']['logistic_bulk_id']);
            }
            $this->set('bulk', $bulk);
        }
        $this->set('storages', $this->LogisticStorage->find('all', array(
            'conditions' => array(
                'LogisticStorage.id' => $this->Session->read('logistic_location_id')
            )
        )));
        $this->set('storagelist', $this->LogisticStorage->find('list', array(
            'conditions' => array(
                'LogisticStorage.deleted' => 0,
                'LogisticStorage.type' => 'default',
                'LogisticStorage.logistic_location_id' => $this->Session->read('logisticLocationID')
            ),
            'order' => 'LogisticStorage.name ASC'
        )));
        if ($item['LogisticItem']['unrig_storage_id']) {
            $this->set('unrig_storage', $this->LogisticStorage->find('first', array(
                'conditions' => array(
                    'LogisticStorage.id' => $item['LogisticItem']['unrig_storage_id']))));
        }
        $this->set('title_for_layout', __("View item: ").($item['LogisticItem']['logistic_bulk_id']?$bulk['LogisticBulk']['name']:$item['LogisticItem']['name']));
        if(!$item['LogisticItem']['deleted'] && !isset($bulk)) {
            $box_into_header = array();
            $box_into_header['Header'] = __("Actions");
            $box_into_header['Link'] = array();
            $box_into_header['Link'][] = array('class' => 'btn btn-primary', 'href' => '/logistic/Item/edit/'.$item['LogisticItem']['id'], 'title' => __("Edit"));
            $this->set('box_into_header', $box_into_header);
        }
        $this->set('item', $item);
        $this->set('status', $this->LogisticStatus->find('all'));
        $this->set('condition_captions', array(
            'ok' => __('OK'),
            'damaged' => __('Damaged'),
            'destroyed' => __('Destroyed'),
            'lost' => __('Lost'),
        ));
        $this->set('children', $this->LogisticItem->findAllChildren($item['LogisticItem']['id']));
        $this->set('parent',$this->LogisticItem->find('first',array(
            'conditions' => array(
                    'LogisticItem.id' => $item['LogisticItem']['parent'] ))));
    }
    public function save() {
        if($this->request->is('post')) {
            $item['LogisticItem']['name'] = $this->request->data['Item']['name'];
            $item['LogisticItem']['description'] = $this->request->data['Item']['description'];
            $item['LogisticItem']['amount'] = $this->request->data['Item']['count'];
            $item['LogisticItem']['regimode'] = $this->request->data['Item']['regimode'];
            $item['LogisticItem']['logistic_supplier_id'] = $this->request->data['Item']['supplier_id'];
            if(!$item['LogisticItem']['logistic_supplier_id']) {
                throw new BadRequestException(__("Supplier not provided."));
            }
            $item['LogisticItem']['unrig_storage_id'] = $this->request->data['Item']['unrig_storage_id'];
            $item['LogisticTag'] = $this->request->data['Tag'];
            $item['LogisticItem']['parent'] = $this->request->data['Item']['parent'];

            if($this->request->data['Item']['regimode'] == 'stock') {
                $item['storage_id'] = $this->request->data['Item']['storage_id'];
            }

            switch($this->request->data['Item']['regmode']) {
                // 'single' -- single item. Has a AssetTag and doesn't
                // belong to a bulk.
                case 'single':
                    $item['LogisticItem']['logistic_bulk_id'] = 0;
                    $item['LogisticItem']['AssetTag'] = $this->request->data['Item']['AssetTag'];
                    $item['LogisticItem']['serialnumber'] = $this->request->data['Item']['serialnumber'];
                    if($this->request->data['Item']['regimode'] == 'handout')
                        $this->saveItem($item, $this->request->data['Item']['user_id']);
                    else if($this->request->data['Item']['regimode'] == 'stock')
                        $this->saveItem($item, false, true);
                    else
                        $this->saveItem($item);
                    break;

                // 'bulk' -- bulk items. Items aren't tracked individually,
                // only by amount.
                case 'bulk':
                    if($item['LogisticItem']['amount'] <= 0) throw new BadRequestException(__("Cannot add 0 or less units"));
                    $item['LogisticItem']['AssetTag'] = $this->request->data['Item']['AssetTag'];
                    $item['LogisticItem']['logistic_bulk_id'] = $this->createBulk($this->request->data, 'bulk');
                    if($this->request->data['Item']['regimode'] == 'handout') {
                        $this->saveItem( $item, $this->request->data['Item']['user_id'] );
                    } else if($this->request->data['Item']['regimode'] == 'stock') {
                        $bulksave['LogisticBulk']['id'] = $item['LogisticItem']['logistic_bulk_id'];
                        $bulksave['LogisticBulk']['amountleft'] = $this->request->data['Item']['count'];
                        $this->LogisticBulk->save($bulksave);
                        $this->saveItem($item, false, true);
                    } else {
                        $this->saveItem($item);
                    }
                    break;

                // 'series' -- item series. Individual items have their own
                // AssetTags, but they are also grouped together in a
                // unifying bulk.
                case 'series':
                    $item['LogisticItem']['logistic_bulk_id'] = $this->createBulk($this->request->data, 'series');
                    $item['LogisticItem']['serialnumber'] = $this->request->data['Item']['serialnumber'];
                    $AssetTag = $this->request->data['Item']['AssetTag'];

                    $tempitem = $item;
                    $tempitem['LogisticItem']['AssetTag'] = $AssetTag;
                    if($this->request->data['Item']['regimode'] == 'handout')
                        $item_id = $this->saveItem($tempitem, $this->request->data['Item']['user_id']);
                    else if($this->request->data['Item']['regimode'] == 'stock')
                        $item_id = $this->saveItem($tempitem, false, true);
                    else
                        $item_id = $this->saveItem($tempitem);
                    break;

                default:
                    throw new BadRequestException(__("Invalid parameters given"));
            }

            if ($this->request->data['Item']['regmode'] !== 'series') {
                $this->redirectEvent('/logistic/Item/create/1');
            } else {
                // Redirect to the add-more-items-page when creating a new series
                $this->redirectEvent('/logistic/Item/addItemsToSeries/' .
                    $item['LogisticItem']['logistic_bulk_id'] . '/1');
            }
        }
    }

    public function edit($id) {
        if(!$id) {
            $this->redirectEvent('/logistic');
        }
        $item = $this->LogisticItem->find('first', array(
            'conditions' => array(
                'LogisticItem.id' => $id)
            )
        );
        if($item['LogisticItem']['logistic_bulk_id']) {
            $bulk = $this->LogisticBulk->find('first', array(
                'conditions' => array(
                    'LogisticBulk.id' => $item['LogisticItem']['logistic_bulk_id']
                )
            ));
            if($bulk['LogisticBulk']['amount'] != $bulk['LogisticBulk']['amountleft']) {
                throw new BadRequestException(__("This bulk has items checked out of storage, and can therefore not be edited"));
            }
            $this->set('bulk', $bulk);
        } else {
            $this->set('bulk', false);
        }
        $this->set('title_for_layout', __("Edit item: ").($item['LogisticItem']['logistic_bulk_id']?$bulk['LogisticBulk']['name']:$item['LogisticItem']['name']));
        $this->set('tags', $this->LogisticTag->find('list'));
        $this->set('storages', $this->LogisticStorage->find('list', array(
            'conditions' => array(
                'LogisticStorage.deleted' => 0,
                'LogisticStorage.logistic_location_id' => $this->Session->read('logisticLocationID')
            ),
            'order' => 'LogisticStorage.name ASC'
        )));
        $selected_tags = array();
        foreach($item['LogisticTag'] as $tag) {
            $selected_tags[] = $tag['id'];
        }

        $this->set('selected_tags', $selected_tags);
        $this->set('suppliers', $this->LogisticSupplier->find('list', array(
            'fields' => array('LogisticSupplier.id', 'LogisticSupplier.company'))));

        $this->set('item', $item);
        $this->set('items',$this->LogisticItem->find('list',array(
            'conditions' => array(
                'LogisticItem.id' => 1711
            ))));
    }

    public function update() {
        if(!$this->request->is('post')) {
            $this->redirectEvent('/logistic');
        }
        if(isset($this->request->data['Item']['bulk_id'])) {
            $savebulk['LogisticBulk']['id'] = $this->request->data['Item']['bulk_id'];
            $savebulk['LogisticBulk']['name'] = $this->request->data['Item']['name'];
            $savebulk['LogisticBulk']['description'] = $this->request->data['Item']['description'];
            $savebulk['LogisticBulk']['logistic_supplier_id'] = $this->request->data['Item']['supplier_id'];
            if(isset($this->request->data['Item']['amount'])) {
                $savebulk['LogisticBulk']['amount'] = $this->request->data['Item']['amount'];
                $savebulk['LogisticBulk']['amountleft'] = $this->request->data['Item']['amount'];
            }
            $this->LogisticBulk->save($savebulk);
        } else {
            $saveitem['LogisticItem']['id'] = $this->request->data['Item']['id'];
            $saveitem['LogisticItem']['name'] = $this->request->data['Item']['name'];
            $saveitem['LogisticItem']['description'] = $this->request->data['Item']['description'];
            $saveitem['LogisticItem']['comment'] = $this->request->data['Item']['comment'];
            $saveitem['LogisticItem']['logistic_supplier_id'] = $this->request->data['Item']['supplier_id'];
            $saveitem['LogisticItem']['parent'] = $this->request->data['Item']['parent'];

            $this->LogisticItem->save($saveitem);
        }
        if(isset($this->request->data['Item']['AssetTag']))
            $saveinfo['LogisticItem']['AssetTag'] = $this->request->data['Item']['AssetTag'];
        if(isset($this->request->data['Item']['serialnumber']))
            $saveinfo['LogisticItem']['serialnumber'] = $this->request->data['Item']['serialnumber'];
        $saveinfo['LogisticItem']['name'] = $this->request->data['Item']['name'];
        $saveinfo['LogisticItem']['description'] = $this->request->data['Item']['description'];
        if(isset($this->request->data['Item']['comment']))
            $saveinfo['LogisticItem']['comment'] = $this->request->data['Item']['comment'];
        $saveinfo['LogisticTag'] = $this->request->data['Tag'];
        $this->LogisticItem->id = $this->request->data['Item']['id'];
        $this->LogisticItem->save($saveinfo);
        $this->Flash->success(__("Item was saved"));
        if(isset($this->request->data['Item']['bulk_id'])) {
            $this->redirectEvent('/logistic/Bulk/view/'.$this->request->data['Item']['bulk_id']);
        } else {
            $this->redirectEvent('/logistic/Item/view/'.$this->request->data['Item']['id']);
        }
    }
    private function saveItem( $item, $user_id=false, $arrived=false) {
        $this->LogisticItem->create();
        $this->LogisticItem->save($item);
        $item_id = $this->LogisticItem->getLastInsertID();
        $this->LogisticTransaction->setRegistered($item_id, $item['LogisticItem']['logistic_bulk_id'], $item['LogisticItem']['amount'], $this->Wannabe->user['User']['id']);
        if($user_id) {
            sleep(1);
            $this->LogisticTransaction->setCheckedOut($item_id, $item['LogisticItem']['logistic_bulk_id'], $item['LogisticItem']['amount'], $this->Wannabe->user['User']['id'], $user_id, $user_id);
        }
        if($arrived) {
            sleep(1);
            $this->LogisticTransaction->setArrived($item_id, $item['LogisticItem']['logistic_bulk_id'], $item['LogisticItem']['amount'], $this->Wannabe->user['User']['id'], $item['storage_id']);
        }
    }

    private function createBulk ($data, $type) {
        $bulk['LogisticBulk']['name'] = $data['Item']['name'];
        $bulk['LogisticBulk']['description'] = $data['Item']['description'];
        $bulk['LogisticBulk']['logistic_supplier_id'] = $data['Item']['supplier_id'];
        $bulk['LogisticBulk']['amountleft'] = 0;
        $bulk['LogisticBulk']['type'] = $type;

        if ($type == 'series') {
            $bulk['LogisticBulk']['amount'] = null;
        } else if ($type == 'bulk') {
            $bulk['LogisticBulk']['amount'] = $this->request->data['Item']['count'];
        }

        $this->LogisticBulk->save($bulk);
        return $this->LogisticBulk->getLastInsertID();
    }

    /*
     * Adds multiple items to an existing series
     */
    public function addItemsToSeries($bulkId=0, $confirm=false) {
        if($confirm) {
            $this->Flash->success(__("Your item series was created.  You may now add more items to the series below."));
        }

        $series = $this->LogisticBulk->find('first', array(
            'conditions' => array(
                'LogisticBulk.id' => $bulkId
            )
        ));

        if(!$series) {
            $this->Flash->error(__("Uncorrect series id provided"));
            $this->redirectEvent('/logistic');
        }

        if($series['LogisticBulk']['type'] != 'series') {
            $this->Flash->error(__("The object is not a series"));
            $this->redirectEvent('/logistic');
        }

        if($this->request->is('post')) {

            // Get an arbitrary item in the series so we can copy its contents
            // to reuse when adding new items by AssetTag.
            $arbitraryItemInSeries = $this->LogisticItem->find('first', array(
                'conditions' => array(
                    'LogisticItem.logistic_bulk_id' => $bulkId,
                    'LogisticItem.deleted' => 0,
                )
            ));

            // Unset the id, so we can create a fresh item.
            unset($arbitraryItemInSeries['LogisticItem']['id']);

            // Force amount to 0. We don't use amount in series.
            $arbitraryItemInSeries['LogisticItem']['amount'] = 0;

            // Get AssetTag and serialnumber arrays from the request
            $AssetTags = $this->request->data['AssetTags'];
            $serialnumbers = $this->request->data['serialnumbers'];

            $errors = array();

            if(!empty($AssetTags)) {
                for ($i = 0; $i < count($AssetTags); $i++) {
                    $AssetTag = $AssetTags[$i];
                    $serialnumber = $serialnumbers[$i];
                    if ($AssetTag == '') {
                        continue;
                    }
                    $itemWithAssetTagExists = $this->LogisticItem->find('first', array(
                        'conditions' => array(
                            'LogisticItem.AssetTag' => $AssetTag
                            )));
                    if(!empty($itemWithAssetTagExists)) {
                        if($itemWithAssetTagExists['LogisticItem']['logistic_bulk_id'] == $bulkId && $itemWithAssetTagExists['LogisticItem']['deleted'] == 1) {
                            $itemId = $itemWithAssetTagExists['LogisticItem']['id'];
                            $this->LogisticItem->unDelete($itemId);
                            $this->LogisticTransaction->setReregistered($itemId, $bulkId, $amount=0, $this->Wannabe->user['User']['id']);
                        } else {
                            $errors[] = '<li>'.__('Item with AssetTag already exists: %s', $AssetTag).'</li>';
                        }

                    } else {
                        $arbitraryItemInSeries['LogisticItem']['AssetTag'] = $AssetTag;
                        $arbitraryItemInSeries['LogisticItem']['serialnumber'] = $serialnumber;
                        if($this->request->data['Item']['regimode'] == 'handout') {
                            $this->saveItem($arbitraryItemInSeries, $this->request->data['Item']['user_id']);
                        } else if($this->request->data['Item']['regimode'] == 'stock') {
                            $arbitraryItemInSeries['storage_id'] =
                                $this->request->data['Item']['storage_id'];
                            $this->saveItem($arbitraryItemInSeries, false, true);
                        } else {
                            $this->saveItem($arbitraryItemInSeries);
                        }
                    }
                }
            }

            if (count($errors) == 0) {
                $this->Flash->success(__("The items were added to the series."));
            } else {
              $this->Flash->error(__('The items were added to the series, but with the following errors: %s', '<ul>'.join($errors).'</ul>'));
            }
            $this->redirectEvent('/logistic/Bulk/view/'.$bulkId);
        }

        $this->set('id', $bulkId);
        $this->set('title_for_layout', __('Add items to series:')." ".$series['LogisticBulk']['name']);
        $this->set('storages', $this->LogisticStorage->find('list', array(
            'conditions' => array(
                'LogisticStorage.deleted' => 0,
                'LogisticStorage.logistic_location_id' => $this->Session->read('logisticLocationID')
            ),
            'order' => 'LogisticStorage.name ASC'
        )));
    }

    /*
     * Edit item info for all items in a series.
     */
    public function editSeries($seriesId=0) {

        $series = $this->LogisticBulk->find('first', array(
            'conditions' => array(
                'LogisticBulk.id' => $seriesId
            )
        ));

        if(!$series) {
            $this->Flash->error(__("Uncorrect series id provided"));
            $this->redirectEvent('/logistic');
        }

        if($series['LogisticBulk']['type'] != 'series') {
            $this->Flash->error(__("The object is not a series"));
            $this->redirectEvent('/logistic');
        }

        $arbitraryItemInSeries = $this->LogisticItem->find('first', array(
            'conditions' => array(
                'LogisticItem.logistic_bulk_id' => $seriesId
            )
        ));

        if($this->request->is('post')) {

            $name = $this->request->data['Item']['name'];
            $description = $this->request->data['Item']['description'];
            $supplier_id = $this->request->data['Item']['supplier_id'];
            $tags = $this->request->data['Tag'];

            // Update the series bulk object
            $series['LogisticBulk']['name'] = $name;
            $series['LogisticBulk']['description'] = $description;
            $series['LogisticBulk']['logistic_supplier_id'] = $supplier_id;

            $this->LogisticBulk->save($series);

            // Update all items within series
            $items = $this->LogisticItem->find('all', array(
                'conditions' => array(
                    'LogisticItem.logistic_bulk_id' => $seriesId
                    )
                ));

            if(!empty($items)) {
                foreach($items as $item) {
                    $item['LogisticItem']['name'] = $name;
                    $item['LogisticItem']['description'] = $description;
                    $item['LogisticItem']['logistic_supplier_id'] = $supplier_id;
                    $item['LogisticTag'] = $tags;

                    $this->LogisticItem->save($item);
                }
            }

            $this->Flash->success(__("The series with all its items were updated."));
            $this->redirectEvent('/logistic/Bulk/view/'.$seriesId);
        }

        $selected_tags = array();
        foreach($arbitraryItemInSeries['LogisticTag'] as $tag) {
            $selected_tags[] = $tag['id'];
        }

        $this->set('tags', $this->LogisticTag->find('list'));
        $this->set('selected_tags', $selected_tags);
        $this->set('suppliers', $this->LogisticSupplier->find('list', array(
            'fields' => array('LogisticSupplier.id', 'LogisticSupplier.company'))));
        $this->set('title_for_layout', __('Edit series:')." ".$series['LogisticBulk']['name']);
        $this->set('item', $arbitraryItemInSeries);

    }
}
