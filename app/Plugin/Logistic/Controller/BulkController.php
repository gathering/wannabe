<?
class BulkController extends LogisticAppController {
	public $uses = array( 'Logistic.LogisticItem', 'Logistic.LogisticTag', 'Logistic.LogisticStorage', 'Logistic.LogisticBulk', 'Logistic.LogisticSupplier', 'Logistic.LogisticTransaction','Logistic.LogisticStatus','User' );
    var $layout = 'responsive-default';

    public function beforeRender() {
        parent::beforeRender();
        CakeSession::write('LogisticTab', 'search');
        if(!$this->Session->check('logisticLocationID')) {
            $this->Session->write('logisticLocationRedir', $this->here);
            $this->redirectEvent('/logistic');
        }
    }
	public function view($id) {
		if(!$id) $this->redirectEvent('/logistic');

        $bulk = $this->LogisticBulk->find('first', array(
            'conditions' => array(
                'LogisticBulk.id' => $id
            )
        ));
        $items = $this->LogisticItem->Search($id);
        $item = [];
        foreach($items as $iitem){
            if($iitem['LogisticBulk']['id'] == $id){
                $this->set('item',$iitem);
                $item = $iitem;
                break;
            }
        }

		$this->set('bulk', $bulk);
        if($bulk['LogisticBulk']['deleted']) {
            $items = $this->LogisticItem->find('all', array(
                'conditions' => array(
                    'LogisticItem.logistic_bulk_id' => $bulk['LogisticBulk']['id']
                )
            ));
        } else {
            $items = $this->LogisticItem->find('all', array(
                'conditions' => array(
                    'LogisticItem.logistic_bulk_id' => $bulk['LogisticBulk']['id'],
                    'LogisticItem.deleted' => 0
                )
            ));
        }

        // Get the unrig destination for these items
        if (count($items) > 0 && $items[0]['LogisticItem']['unrig_storage_id']) {
            $this->set('unrig_storage', $this->LogisticStorage->find('first', array(
                'conditions' => array(
                    'LogisticStorage.id' => $items[0]['LogisticItem']['unrig_storage_id']))));
        }

        // Get a list of all storages
        $storages = $this->LogisticStorage->find('list', array(
            'conditions' => array(
                'LogisticStorage.deleted' => 0,
                'LogisticStorage.logistic_location_id' => $this->Session->read('logisticLocationID')
            ),
            'order' => 'LogisticStorage.name ASC'
        ));
        $this->set('storagelist', $storages);

        // If this is a bulk item, summarize the amounts available at each storage
        // location by iterating over all transactions in chronological order
        $storage_amounts = array();
        if ($bulk['LogisticBulk']['type'] == 'bulk') {
            $storage_amounts = $this->LogisticBulk->getAmountsPerStorage($items[0], $bulk);
        }
        $this->set('storage_amounts', $storage_amounts);

        $storage_amounts_sum = 0;
        foreach ($storage_amounts as $storage_amount) {
            $storage_amounts_sum += $storage_amount;
        }
        $this->set('storage_amounts_sum', $storage_amounts_sum);

        $box_into_header = array();
        $box_into_header['Link'] = array();
        $box_into_header['Header'] = __("Actions");

        if ($bulk['LogisticBulk']['type'] == 'series') {
            $this->set('title_for_layout', __("View series:")." ".$bulk['LogisticBulk']['name']);
            if (!$bulk['LogisticBulk']['deleted']) {
                $box_into_header['Link'][] = array('class' => 'btn btn-primary', 'href' => '/logistic/Item/editSeries/'.$bulk['LogisticBulk']['id'], 'title' => __("Edit"));
                $box_into_header['Link'][] = array('class' => 'btn btn-success', 'href' => '/logistic/Item/addItemsToSeries/'.$bulk['LogisticBulk']['id'], 'title' => __("Add items"));
		$this->set('box_into_header', $box_into_header);
            }
        } else {
            $this->set('title_for_layout', __("View bulk:")." ".$bulk['LogisticBulk']['name']);
            if (!$bulk['LogisticBulk']['deleted']) {
                $box_into_header['Link'][] = array('class' => 'btn btn-primary', 'href' => '/logistic/Item/edit/'.$items[0]['LogisticItem']['id'], 'title' => __("Edit"));
		$this->set('box_into_header', $box_into_header);
            }
        }
        $this->set('item',$item);
		$this->set('items', $items);
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

}
