<?php
/*
 * Geocode Controller
 *
 * Saves geocode query from the client
 */

class GeocodeController extends AppController {
    var $uses = array('Geocode', 'User');
    public function index() {
        if($this->request->is('ajax')) {
            $savegeo = array('Geocode' => array(
                'address' => $this->request->data['address'],
                'longitude' => $this->request->data['longitude'],
                'latitude' => $this->request->data['latitude'],
                'cached' => date( 'Y-m-d H:i:s', time())
            ));
            $cached = $this->Geocode->find('first', array(
                'conditions' => array(
                    'Geocode.address' => $savegeo['Geocode']['address']
                )
            ));
            if(is_array($cached) && $cached) {
                $savegeo['Geocode']['id'] = $cached['Geocode']['id'];
            }
            if($this->Geocode->save($savegeo)) {
                $success = true;
            } else {
                $success = false;
            }
            die(json_encode(array('success' => $success)));
        }
    }
    public function invalidate() {
        if($this->request->is('ajax')) {
            $savegeo = array('Geocode' => array(
                'address' => $this->request->data['address'],
                'longitude' => 0,
                'latitude' => 0,
                'invalid' => 1,
                'cached' => date( 'Y-m-d H:i:s', time())
            ));
            $cached = $this->Geocode->find('first', array(
                'conditions' => array(
                    'Geocode.address' => $savegeo['Geocode']['address']
                )
            ));
            if(is_array($cached) && $cached) {
                $savegeo['Geocode']['id'] = $cached['Geocode']['id'];
            }
            if($this->Geocode->save($savegeo)) {
                $success = true;
            } else {
                $success = false;
            }
            die(json_encode(array('success' => $success)));
        }
    }
}
