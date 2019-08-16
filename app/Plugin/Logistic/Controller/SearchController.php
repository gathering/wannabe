<?php
class SearchController extends LogisticAppController {

	public $uses = array('Logistic.LogisticStorage', 'Logistic.LogisticLocation', 'Logistic.LogisticTransaction', 'User', 'Logistic.LogisticTag', 'Logistic.LogisticStatus', 'Crew', 'Logistic.LogisticSupplier', 'Logistic.LogisticItem', 'Logistic.LogisticBulk');

    var $layout = 'responsive-default';

	public function index() {
		CakeSession::write('LogisticTab', 'search');
        if($this->request->is('ajax')) {
			$this->layout = 'ajax';
		}
		if(isset($_GET['query'])) {
			$items = $this->LogisticItem->search($_GET['query']);
			if (sizeof($items) == 1) {
				$this->redirectEvent('/logistic/Item/view/'.$items[0]['LogisticItem']['id']);
				return;
			}
			$this->set('query', htmlentities($_GET['query']));
			$this->set('items', $items);
		} else {
			$this->set('query', '');
		}
		$this->set('title_for_layout', __("Search items"));
	}

	public function filter($tag_id=0,$storage_id=0,$status_id=0,$user_id=0,$crew_id=0,$supplier_id=0) {
		CakeSession::write('LogisticTab', 'filter');
		$tags = $this->LogisticTag->find('all');
		$this->set('taglist', $this->LogisticTag->find('list'));
		$this->set('tags', $tags);
		$this->set('user', $this->Wannabe->user['User']);
		$this->set('storages', $this->LogisticStorage->find('all', array(
            'conditions' => array(
                'logistic_location_id' => $this->Session->read('logisticLocationID'),
                'deleted' => '0'
                ),
            'order' => 'name ASC'
        )));
		$this->set('statuses', $this->LogisticStatus->find('all'));
		$this->set('statuslist', $this->LogisticStatus->find('list'));
		$this->set('storage_id', $this->Session->read('logisticLocationID'));
		$this->set('crewlist', $this->Crew->getAllCrews());
		$this->set('supplierlist', $this->LogisticSupplier->find('all'));
        if($this->request->is('ajax')) {
			$this->layout = 'ajax';
		}
        if(isset($this->request->named['tag'])) $this->request->data['tag_id'] = $this->request->named['tag'];
        elseif($tag_id) $this->request->data['tag_id'] = $tag_id;
        if(isset($this->request->named['storage'])) $this->request->data['storage_id'] = $this->request->named['storage'];
        elseif($storage_id) $this->request->data['storage_id'] = $storage_id;
        if(isset($this->request->named['status'])) $this->request->data['status_id'] = $this->request->named['status'];
        elseif($status_id) $this->request->data['status_id'] = $status_id;
        if(isset($this->request->named['user'])) $this->request->data['user_id'] = $this->request->named['user'];
        elseif($user_id) $this->request->data['user_id'] = $user_id;
        if(isset($this->request->named['crew'])) $this->request->data['crew_id'] = $this->request->named['crew'];
        elseif($crew_id) $this->request->data['crew_id'] = $crew_id;
        if(isset($this->request->named['supplier'])) $this->request->data['supplier_id'] = $this->request->named['supplier'];
        elseif($supplier_id) $this->request->data['supplier_id'] = $supplier_id;
		$this->set('query', array(
            'tag' => (isset($this->request->data['tag_id'])?$this->request->data['tag_id']:$tag_id),
            'storage' => (isset($this->request->data['storage_id'])?$this->request->data['storage_id']:$storage_id),
            'status' => (isset($this->request->data['status_id'])?$this->request->data['status_id']:$status_id),
            'user' => (isset($this->request->data['user_id'])?$this->request->data['user_id']:$user_id),
            'crew' => (isset($this->request->data['crew_id'])?$this->request->data['crew_id']:$crew_id),
            'supplier' => (isset($this->request->data['supplier_id'])?$this->request->data['supplier_id']:$supplier_id)
        ));

		if($this->request->data != null) {
			$constraint = "";

			//Should be fixed
			if(isset($this->request->data['tag_id']) && $this->request->data['tag_id'] != 0) {
				$condition = "";
				$tag = $this->request->data['tag_id'];

				//Here we look up any remaining ids for subtags:
				$tag_name = $this->LogisticTag->findAllById($tag);
				$subtag_conditions = array('name' => $tag_name[0]['LogisticTag']['name'].'/%');
				$subtag_ids = $this->LogisticTag->query("SELECT id FROM wb4_logistic_tags WHERE name LIKE '".$tag_name[0]['LogisticTag']['name']."/%'", $cachequeries = false);
				$condition = $condition."logistic_tag_id = ".$tag;

				if(!empty($subtag_ids)) {
					for($i =0; $i < count($subtag_ids); $i++) {
						$condition = $condition." OR logistic_tag_id = ".$subtag_ids[$i]['wb4_logistic_tags']['id'];
					}
				}

				$constraint .= "LogisticItem.id in (select logistic_item_id from wb4_logistic_items_logistic_tags where ".$condition.")";
				$selected_tag = $this->request->data['tag_id'];
			}

			// By crews
			if (isset($this->request->data['crew_id']) && $this->request->data['crew_id'] != 0) {
				$userids = array();
				$sql = "SELECT user_id FROM wb4_crews_users WHERE crew_id = " . $this->request->data['crew_id'];
				$res = $this->LogisticItem->query($sql);
				if(is_array($res) && !empty($res)) {
					foreach ($res as $r) {
						$userids[] = $r['wb4_crews_users']['user_id'];
					}
					$users = join(",", $userids);
					if ($constraint != "")
						$constraint .= " AND " ;
					var_dump($users);
					$constraint .= " LogisticItem.id IN (SELECT logistic_item_id FROM wb4_logistic_transactions WHERE user_id IN (" . $users . ") or crew_id = ".$this->request->data['crew_id'].") ";
				}
			}

			if (isset($this->request->data['supplier_id']) && $this->request->data['supplier_id'] != 0) {
				if ($constraint != "") {
					$constraint .= " AND " ;
				}
				$constraint .= " LogisticItem.logistic_supplier_id = " . $this->request->data['supplier_id'];
			}

			if(isset($this->request->data['storage_id']) && $this->request->data['storage_id'] != 0) {
				$this->LogisticTransaction->unbindModel(array('belongsTo' => array('User', 'DoneBy', 'LogisticStorage')));
				$tempstorageid = $this->LogisticTransaction->find('all', array(
							'conditions' => array(
								'logistic_storage_id' => $this->request->data['storage_id']
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
				if($constraint != "")
					$constraint = $constraint." AND ";
				$constraint = $constraint."LogisticItem.id in (select distinct logistic_item_id from wb4_logistic_transactions where (".$storage_ids."))";
			}

			if(isset($this->request->data['user_id']) && $this->request->data['user_id'] != 0) {
				$this->LogisticTransaction->unbindModel(array('belongsTo' => array('User', 'DoneBy', 'LogisticStorage')));
				$tempitemid = $this->LogisticTransaction->find('all', array(
							'conditions' => array(
								'user_id' => $this->request->data['user_id']
								)
							));
				$item_ids = "";
				$itmatched = 0;
				if(is_array($tempitemid) && !empty($tempitemid)) {
					foreach($tempitemid as $item_id) {
						if($itmatched) {
							$item_ids .= " OR ";
							$itmatched = 0;
						}
						$lastid = $this->LogisticTransaction->query("SELECT id FROM wb4_logistic_transactions where logistic_item_id=".$item_id['LogisticTransaction']['logistic_item_id']." order by id desc limit 1");
						foreach($tempitemid as $temptempidid) {
							foreach($lastid as $tempid) {
								if($tempid) {
									if(isset($tempid['wb4_logistic_transactions']) && $tempid['wb4_logistic_transactions']['id'] == $temptempidid['LogisticTransaction']['id']) {
										$item_ids = $item_ids."logistic_item_id = ".$temptempidid['LogisticTransaction']['logistic_item_id'];
										$itmatched = 1;
									}
								}
							}
						}
					}
				}
				if(!$itmatched) $item_ids .= "1 = 0";
				if($constraint != "")
					$constraint = $constraint." AND ";
				$constraint = $constraint."LogisticItem.id in (select distinct logistic_item_id from wb4_logistic_transactions where (".$item_ids."))";
			}
			if($constraint) {
				$matches_tmp = $this->LogisticItem->query('SELECT LogisticItem.* FROM wb4_logistic_items LogisticItem where '.$constraint);
			} else {
				$matches_tmp = $this->LogisticItem->query('SELECT LogisticItem.* FROM wb4_logistic_items LogisticItem');
			}

			//Fikser multiset og bulks

			// Cache fetched bulks to reduce number of queries
			$cached_bulks = array();

			foreach($matches_tmp as &$match) {
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

				$bulk_id = $match['LogisticItem']['logistic_bulk_id'];
				if ($bulk_id > 0) {
					if (!isset($cached_bulks[$bulk_id])) {
						$bulk = $this->LogisticBulk->find('first', array(
									'conditions' => array(
										'LogisticBulk.id' => $bulk_id
										)
									));
						$cached_bulks[$bulk_id] = $bulk['LogisticBulk'];
					}

					$match['LogisticBulk'] = $cached_bulks[$bulk_id];
					$match['LogisticItem']['name'] = $match['LogisticBulk']['name'];
				}
			}

			if(isset($this->request->data['status_id']) && $this->request->data['status_id'] != 0) {
				$matches = array();
				foreach($matches_tmp as $match) {
					if($match['LogisticTransaction']['logistic_status_id'] == $this->request->data['status_id']) {
						$matches[$match['LogisticItem']['id']] = $match;
					}
				}
				$selected_status = $this->request->data['status_id'];
			} else {
				$matches = $matches_tmp;
			}

			$this->set('matches', $matches);
		}
		$this->set('title_for_layout', __("Filter search"));
	}

        public function filterMap($storage_caption=null) {
            if ($storage_caption) {
                $search_name = '';
                if (strlen($storage_caption) > 3) {
                    // E.g.: 'Radio-bord' => 'Radiobord'
                    $search_name = str_replace('-', '', $storage_caption);
                } else if (strlen($storage_caption) == 2 && $storage_caption[0] == 'H') {
                    // E.g.: 'H3' => 'Hylleplass 3'
                    $search_name = 'Hylleplass '.$storage_caption[1];
                } else {
                    // E.g.: 'A5' => 'Palleplass A5'
                    $search_name = 'Palleplass '.$storage_caption;
                }
                $storage = $this->LogisticStorage->find('first', array(
                    'conditions' => array('LogisticStorage.name' => $search_name)));
                if (count($storage) > 0) {
                    $this->redirectEvent('/Logistic/Search/filter/0/'.$storage['LogisticStorage']['id'].'/0/0/0/0/');
                } else {
                    $this->Flash->error(__('Could not find storage %s', $search_name));
                }
            }
            $this->set('title_for_layout', __("Storage map"));
        }
}
