<?php

/**
 * Component that handles caching of geocoded addresses
 */
class GeocodeCacheComponent extends Component {

    var $userAddress = '';
    var $cache = array();
    var $userNeedGeocodeUpdate = false;

	public function initialize(&$controller) {
        $this->apiKey = Configure::read('GoogleMaps.apiKey');

        if(isset($controller->Wannabe->user['User']) && $controller->Acl->hasMembershipToEvent($controller->Wannabe->user)) {
            $this->userAddress = $controller->Wannabe->user['User']['address']." ".$controller->Wannabe->user['User']['postcode']." ".$controller->Wannabe->user['User']['town'];
            $this->cache = $this->loadGeocodeCache();
            $match = false;
            if(is_array($this->cache) && $this->cache) {
                foreach($this->cache as $id => $geocode) {
                    if($geocode['Geocode']['address'] == $this->userAddress) {
                        $match = true;
                        if($geocode['Geocode']['invalid']) {
                            $match = true;
                        } elseif(strtotime($geocode['Geocode']['cached']) < strtotime("-1 week")) {
                            unset($this->cache[$id]);
                            $match = false;
                        }
                    }
                }
            }
            if(!$match) {
                $this->userNeedGeocodeUpdate = true;
            }
        }
	}

    private function loadGeocodeCache() {
        App::import('Model', 'Geocode');
        $geocodeModel = new Geocode();
        return $geocodeModel->find('all');
    }
}
