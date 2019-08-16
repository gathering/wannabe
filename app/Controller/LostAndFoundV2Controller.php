<?php

class LostAndFoundV2Controller extends AppController {

    public $uses = array('FoundItem', 'LostItem', 'LostAndFoundCategory', 'LostAndFoundStoragePlace', 'User');

    private function setViewVariable($key, $value) {
        if(is_string($value)) {
            $this->set($key, __($value));
        }
        else {
            $this->set($key, $value);
        }
    }

    private function makeAjaxResponse($statusCode, $message = "") {

        if($message) {
            return new CakeResponse(array(
                'body' => json_encode($message),
                'status' => $statusCode
            ));
        }
        else {
            return new CakeResponse(array('status' => $statusCode));
        }
    }

    public function index() {
        $this->set('title_for_layout', __("Lost and Found"));
    }

    //<editor-fold desc="Categories">

    private function _getCategories($active) {
        return $this->LostAndFoundCategory->find('all', array(
            'conditions' => array(
                'LostAndFoundCategory.active' => $active
            ),
            'order' => 'name ASC'
        ));
    }


    public function categories() {
        if($this->request->is("post"))
            throw new MethodNotAllowedException();
    }


    // Gets categories as JSON
    public function getCategories($active) {

        if(! $this->request->is('ajax'))
            return $this->makeAjaxResponse(405, null);

        return $this->makeAjaxResponse(200, $this->_getCategories($active));
    }


    public function categoriesList() {

        if(! $this->request->is("ajax"))
            return $this->makeAjaxResponse(405, null);

        $active = (boolean) json_decode($this->request->data['active']);
        $this->layout = "ajax";
        $this->setViewVariable('categories', $this->_getCategories($active));
        $this->render("categories_list");
    }

    public function addCategory() {

        if(! $this->request->is('ajax'))
            return new CakeResponse(array('status' => 405));

        $this->request->data['LostAndFoundCategory']['event_id'] = $this->Wannabe->event->id;
        if(! $this->LostAndFoundCategory->save($this->request->data)) {

            $validationErrors = $this->LostAndFoundCategory->validationErrors;
            if($validationErrors)
                return $this->makeAjaxResponse(200, $validationErrors);

            return new CakeResponse(array('status' => 500));
        }

        return new CakeResponse(array('status' => 200));
    }

    public function setCategoryActiveState() {
        if(! $this->request->is('ajax'))
            return new CakeResponse(array('status' => 405));

        $id = json_decode($this->request->data['id']);
        $active = (boolean) json_decode($this->request->data['active']);

        $this->layout = "ajax";

        if($id) {
            $this->LostAndFoundCategory->id = $id;
            $this->LostAndFoundCategory->saveField('active', $active);
            return $this->makeAjaxResponse(200);
        }

        return $this->makeAjaxResponse(400);
    }


    //</editor-fold>

    //<editor-fold desc="Storage Place">

    private function _getStoragePlaces($active) {
        return $this->LostAndFoundStoragePlace->find('all', array(
            'conditions' => array(
                'LostAndFoundStoragePlace.active' => $active
            ),
            'order' => 'name ASC'
        ));
    }


    public function storagePlaces() {
        if($this->request->is("post"))
            throw new MethodNotAllowedException();
    }


    // Gets storage places as JSON
    public function getStoragePlaces($active) {

        if(! $this->request->is('ajax'))
            return $this->makeAjaxResponse(405, null);

        return $this->makeAjaxResponse(200, $this->_getStoragePlaces($active));
    }


    public function storagePlacesList() {

        if(! $this->request->is("ajax"))
            return $this->makeAjaxResponse(405, null);

        $active = (boolean) json_decode($this->request->data['active']);
        $this->layout = "ajax";
        $this->setViewVariable('places', $this->_getStoragePlaces($active));
        $this->render("storage_places_list");
    }

    public function addStoragePlace() {

        if(! $this->request->is('ajax'))
            return new CakeResponse(array('status' => 405));

        $this->request->data['LostAndFoundStoragePlace']['event_id'] = $this->Wannabe->event->id;

        if(! $this->LostAndFoundStoragePlace->save($this->request->data)) {

            $validationErrors = $this->LostAndFoundStoragePlace->validationErrors;
            if($validationErrors)
                return $this->makeAjaxResponse(200, $validationErrors);

            return new CakeResponse(array('status' => 500));
        }

        return new CakeResponse(array('status' => 200));
    }

    public function setStoragePlaceActiveState() {
        if(! $this->request->is('ajax'))
            return new CakeResponse(array('status' => 405));

        $id = json_decode($this->request->data['id']);
        $active = (boolean) json_decode($this->request->data['active']);

        $this->layout = "ajax";

        if($id) {
            $this->LostAndFoundStoragePlace->id = $id;
            $this->LostAndFoundStoragePlace->saveField('active', $active);
            return $this->makeAjaxResponse(200);
        }
        return $this->makeAjaxResponse(400);
    }

    //</editor-fold>x

    //<editor-fold desc="Lost">
    public function lost() {

        $lostItems = $this->LostItem->find('all', array(
            'conditions' => array(
                'LostItem.event_id' => $this->Wannabe->event->id,
                'resolved' => false
            ),
        ));

        $this->setViewVariable("lostItems", $lostItems);
        $this->set('title_for_layout', __('Lost'));
    }
    //</editor-fold>


    public function add() {
        if($this->request->is('post')) {
            $type = $this->request->data["SelectedType"];

            if($type == "lost") {
                $this->request->data['LostItem']['event_id'] = $this->Wannabe->event->id;
                $this->request->data['LostItem']['lost_registered_logged_in_user'] = $this->Wannabe->user['User']['id'];
                $this->request->data['LostItem']['resolved'] = 0;

                if(! array_key_exists("lost_registered_by", $this->request->data["LostItem"])) {
                    $this->request->data["LostItem"]["lost_registered_by"] = $this->Wannabe->user['User']['id'];

                }

                if ($this->LostItem->save($this->request->data)) {
                    $this->Flash->success(__("Item was successfully registered"));
                    $this->redirectEvent('/LostAndFoundV2/lost');
                }
                else {
//                    $this->setViewVariable("categories", $this->_getCategories(true));
                    $this->setViewVariable("selectedCategory", $this->request->data['LostItem']['category_id']);
//                    $this->setViewVariable("selectedStoragePlace", $this->request->data['FoundItem']['storage_id']);

                    if(array_key_exists("DifferentUser", $this->request->data)) {
                        $this->setViewVariable("differentUser", $this->request->data['DifferentUser']);
                    }

                    $this->Flash->warning(__("Something went wrong"));
                }
            }
            else if($type == "found") {
                $this->request->data['FoundItem']['event_id'] = $this->Wannabe->event->id;
                $this->request->data['FoundItem']['found_logged_in_user'] = $this->Wannabe->user['User']['id'];

                $now_date = new DateTime();
                $now = $now_date->format('Y-m-d H:i:s');

                $this->request->data['FoundItem']['found_date'] = $now;

                if(! array_key_exists("found_registered_by", $this->request->data["FoundItem"])) {
                    $this->request->data["FoundItem"]["found_registered_by"] = $this->Wannabe->user['User']['id'];
                }

                if($this->FoundItem->save($this->request->data)) {
                    $this->Flash->success(__("Item was successfully registered"));
                    $this->redirectEvent('/LostAndFoundV2/found');
                }
                else {
                    $this->setViewVariable("selectedStoragePlace", $this->request->data['FoundItem']['storage_place_id']);
                    if(array_key_exists("DifferentUser", $this->request->data)) {
                        $this->set("differentUser", $this->request->data["DifferentUser"]);
                    }

                    $this->Flash->warning(__("Something went wrong"));
                }
            }

            $this->setViewVariable("selectedType", $this->request->data['SelectedType']);
        }

        $this->setViewVariable("categories", $this->_getCategories(true));
        $this->set("storagePlaces", $this->_getStoragePlaces(true));
        $this->set("title_for_layout", __("Add item"));
    }

    public function lost_info($id) {

        $lostItem = $this->LostItem->find('first', array(
            'conditions' => array(
                'LostItem.id' => $id
            ),
        ));

//        if($lostItem == null) $lostItem = array("LostItem" => null, "LostAndFoundCategory" => null);
        if($lostItem == null)
            throw new NotFoundException();

        $this->set("lostItem", $lostItem);
        $this->set("title_for_layout", __("Information about lost item"));
    }


    public function lost_edit($id) {

        if($this->request->is("post")) {
            if ($this->LostItem->save($this->request->data)) {
                $this->Flash->success(__("Item was successfully registered"));
                $this->redirectEvent('/LostAndFoundV2/lost');
            }
            else {
                $this->Flash->warning(__("Something went wrong"));
            }
        }


        $lostItem = $this->LostItem->find('first', array(
            'conditions' => array(
                'LostItem.id' => $id
            ),
        ));

        if($lostItem == null)
            throw new NotFoundException();

        $categories = $this->_getCategories(true);
        $storagePlaces = $this->_getStoragePlaces(true);

        $this->set("lostItem", $lostItem);
        $this->set("categories", $categories);
        $this->set("storagePlaces", $storagePlaces);
        $this->set("title_for_layout", __("Edit lost item"));
    }

    public function lost_delete($id) {

        if($this->request->is("post")) {
            if ($this->LostItem->delete($this->request->data["LostItem"]["id"])) {
                $this->Flash->success(__("Item was successfully deleted"));
                $this->redirectEvent('/LostAndFoundV2/lost');
            }
            else {
                $this->Flash->warning(__("Item could not be deleted"));
                $this->redirectEvent('/LostAndFoundV2/lost');
            }
        }

        $lostItem = $this->LostItem->find('first', array(
            'conditions' => array(
                'LostItem.id' => $id
            )
        ));

        $this->set("lostItem", $lostItem);
        $this->set("title_for_layout", __("Delete lost item"));
    }

    public function lost_found($id) {
        if($this->request->is('post')) {

            $this->request->data['LostItem']['found_logged_in_user'] = $this->Wannabe->user['User']['id'];

            if(! array_key_exists("found_registered_by", $this->request->data["LostItem"])) {
                $this->request->data["LostItem"]["found_registered_by"] = $this->Wannabe->user['User']['id'];
            }

            if ($this->LostItem->save($this->request->data)) {
                $this->Flash->success(__("Item was successfully saved"));
                $this->redirectEvent('/LostAndFoundV2/lost');
            }
            else {
                $this->set("selectedStoragePlace", $this->request->data["LostItem"]["storage_place_id"]);

                if(array_key_exists("DifferentUser", $this->request->data)) {
                    $this->setViewVariable("differentUser", $this->request->data['DifferentUser']);
                }
                $this->Flash->warning(__("Something went wrong"));
            }
        }

        $lostItem = $this->LostItem->find('first', array(
            'conditions' => array(
                'LostItem.id' => $id
            )
        ));

        $storagePlaces = $this->_getStoragePlaces(true);

        $this->set("lostItem", $lostItem);
        $this->set("storagePlaces", $storagePlaces);
        $this->set("title_for_layout", __("Set item as found"));
    }

    public function lost_resolve($id) {
        if($this->request->is('post')) {

            $this->request->data['LostItem']['resolved_logged_in_user'] = $this->Wannabe->user['User']['id'];
            $this->request->data['LostItem']['resolved'] = true;

            if(! array_key_exists("resolved_registered_by", $this->request->data["LostItem"])) {
                $this->request->data["LostItem"]["resolved_registered_by"] = $this->Wannabe->user['User']['id'];
            }

            if ($this->LostItem->save($this->request->data)) {
                $this->Flash->success(__("Item was successfully saved"));
                $this->redirectEvent('/LostAndFoundV2/lost');
            }
            else {
                if(array_key_exists("DifferentUser", $this->request->data)) {
                    $this->setViewVariable("differentUser", $this->request->data['DifferentUser']);
                }
                $this->Flash->warning(__("Something went wrong"));
            }
        }

        $lostItem = $this->LostItem->find('first', array(
            'conditions' => array(
                'LostItem.id' => $id
            )
        ));

        $this->set("lostItem", $lostItem);
        $this->set("title_for_layout", __("Set item as resolved"));
    }


    public function found() {

        $foundItems = $this->FoundItem->find('all', array(
           'conditions' => array(
                'FoundItem.event_id' => $this->Wannabe->event->id,
                'FoundItem.resolved' => false
           )
        ));

        $this->set("foundItems", $foundItems);
        $this->set("title_for_layout", __("Found"));
    }


    public function found_info($id) {
        $foundItem = $this->FoundItem->find('first', array(
            'conditions' => array(
                'FoundItem.id' => $id
            )
        ));

        $this->set("foundItem", $foundItem);
        $this->set("title_for_layout", __("Edit found item"));
    }

    public function found_delete($id) {

        if($this->request->is("post")) {
            if ($this->FoundItem->delete($this->request->data["FoundItem"]["id"])) {
                $this->Flash->success(__("Item was successfully deleted"));
                $this->redirectEvent('/LostAndFoundV2/found');
            }
            else {
                $this->Flash->warning(__("Item could not be deleted"));
                $this->redirectEvent('/LostAndFoundV2/found');
            }
        }

        $foundItem = $this->FoundItem->find('first', array(
            'conditions' => array(
                'FoundItem.id' => $id
            )
        ));

        $this->set("foundItem", $foundItem);
        $this->set("title_for_layout", __("Delete found item"));
    }

    public function found_edit($id) {

        if($this->request->is("post")) {
            if ($this->FoundItem->save($this->request->data)) {
                $this->Flash->success(__("Item was successfully registered"));
                $this->redirectEvent('/LostAndFoundV2/found');
            }
            else {
                $this->Flash->warning(__("Something went wrong"));
            }
        }


        $foundItem = $this->FoundItem->find('first', array(
            'conditions' => array(
                'FoundItem.id' => $id
            ),
        ));

        if($foundItem == null)
            throw new NotFoundException();

        $categories = $this->_getCategories(true);
        $storagePlaces = $this->_getStoragePlaces(true);

        $this->set("foundItem", $foundItem);
        $this->set("categories", $categories);
        $this->set("storagePlaces", $storagePlaces);
        $this->set("title_for_layout", __("Edit found item"));
    }

    public function found_resolve($id) {
        if($this->request->is('post')) {

            $this->request->data['FoundItem']['resolved_logged_in_user'] = $this->Wannabe->user['User']['id'];
            $this->request->data['FoundItem']['resolved'] = true;

            $now_date = new DateTime();
            $now = $now_date->format('Y-m-d H:i:s');

            $this->request->data['FoundItem']['resolved_date'] = $now;

            if(! array_key_exists("resolved_registered_by", $this->request->data["FoundItem"])) {
                $this->request->data["FoundItem"]["resolved_registered_by"] = $this->Wannabe->user['User']['id'];
            }

            if ($this->FoundItem->save($this->request->data)) {
                $this->Flash->success(__("Item was successfully saved"));
                $this->redirectEvent('/LostAndFoundV2/found');
            }
            else {
                if(array_key_exists("DifferentUser", $this->request->data)) {
                    $this->setViewVariable("differentUser", $this->request->data['DifferentUser']);
                }
                $this->Flash->warning(__("Something went wrong"));
            }
        }

        $foundItem = $this->FoundItem->find('first', array(
            'conditions' => array(
                'FoundItem.id' => $id
            )
        ));

        $this->set("foundItem", $foundItem);
        $this->set("title_for_layout", __("Set item as resolved"));
    }

    public function resolved() {

        $lostItems = $this->LostItem->find('all', array(
            'conditions' => array(
                'LostItem.event_id' => $this->Wannabe->event->id,
                'LostItem.resolved' => true
            ),
        ));

        $foundItems = $this->FoundItem->find('all', array(
            'conditions' => array(
                'FoundItem.event_id' => $this->Wannabe->event->id,
                'FoundItem.resolved' => true
            )
        ));

        $this->set("lostItems", $lostItems);
        $this->set("foundItems", $foundItems);
        $this->set('title_for_layout', __('Resolved'));
    }
}

?>
