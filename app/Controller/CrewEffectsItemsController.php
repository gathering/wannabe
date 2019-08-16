<?php
/**
 * CrewEffectsItems Controller
 *
 */
class CrewEffectsItemsController extends AppController {

    public $sizes = array('XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL', 'XXXXL', 'XXXXXL', 'XS-dame','S-herre','S-dame','M-herre','M-dame','L-herre','L-dame','XL-herre','XL-dame','XXL-herre','XXL-dame','XXXL-herre','XXXXL-herre', 'XXXXXL-herre');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->CrewEffectsItem->recursive = 0;
        $this->set('items', $this->CrewEffectsItem->find('list', array('conditions' => array(
           'CrewEffectsItem.event_id' => $this->Wannabe->event->id), 'order' => 'id ASC')));
        $this->set('title_for_layout', 'Crew effects items');
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
        if ($this->request->is('post')) {

            $this->request->data['CrewEffectsItem']['event_id'] = $this->Wannabe->event->id;

            // Collect sizes selected and store in request->sizes
            $selectedSizes = "";
            for($i=0; $i < sizeof($this->sizes); $i++)
                    if($this->request->data['CrewEffectsItem']['sizes'.$this->sizes[$i]])
                        $selectedSizes .= $this->sizes[$i].',';

            if($selectedSizes == "") {
                $this->Flash->error(__("You must choose at least one available size"));
                $this->redirectEvent('/CrewEffectsItems/add');
            }

            $this->request->data['CrewEffectsItem']['sizes'] = $selectedSizes;

            // Save object
			if ($this->CrewEffectsItem->save($this->request->data)) {
                $this->Flash->success(__("The crew effects item has been saved"));
				$this->redirectEvent('/CrewEffectsItems/');
			}
        }

        $this->set('title_for_layout', __('Crew effect item'));
        $this->set('savebutton', __("Save item"));
        $this->set('sizes', $this->sizes);
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->CrewEffectsItem->id = $id;
		if (!$this->CrewEffectsItem->exists())
			throw new NotFoundException(__('Invalid crew effects item'));

		if ($this->request->is('post') || $this->request->is('put')) {

            // Collect sizes selected and store in request->sizes
            $selectedSizes = "";
            for($i=0; $i < sizeof($this->sizes); $i++)
                    if($this->request->data['CrewEffectsItem']['sizes'.$this->sizes[$i]])
                        $selectedSizes .= $this->sizes[$i].',';

            $this->request->data['CrewEffectsItem']['sizes'] = $selectedSizes;

            // Save object
			if ($this->CrewEffectsItem->save($this->request->data)) {
				$this->Flash->success(__("The crew effects item has been saved"));
				$this->redirectEvent('/CrewEffectsItems/');
            }
        } else {
            $this->request->data = $this->CrewEffectsItem->read(null, $id);
        }

        // Get sizes from database and prepare them for the form
        $selectedSizesArray = explode(",", $this->request->data['CrewEffectsItem']['sizes']);
        $sizesToPass = array();
        for($i=0; $i < sizeof($this->sizes); $i++) {
            for($j=0; $j < sizeof($selectedSizesArray); $j++) {
                if($this->sizes[$i] == $selectedSizesArray[$j]) {
                    $sizesToPass[$this->sizes[$i]] = "1";
                    break;
                }else{
                    $sizesToPass[$this->sizes[$i]] = "0";
                }
            }
        }

        $this->set('sizesValues', $sizesToPass);
        $this->set('sizes', $this->sizes);
        $this->set('savebutton', __("Edit item"));
        $this->set('title_for_layout', __('Crew effect item'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {

		$this->CrewEffectsItem->id = $id;
		if (!$this->CrewEffectsItem->exists()) {
			throw new NotFoundException(__('Invalid crew effects item'));
		}
		if ($this->CrewEffectsItem->delete()) {
			$this->Flash->success(__("Crew effects item deleted"));
			$this->redirectEvent('/CrewEffectsItems/');
		}
		$this->Flash->error(__("Crew effects item was not deleted"));
        $this->redirectEvent('/CrewEffectsItems/');
    }
}
