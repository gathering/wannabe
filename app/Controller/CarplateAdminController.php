<?php
class CarplateAdminController extends AppController
{
	public $uses = array('Carplate');

	public function index()
	{
		$this->set('carplates', $this->Carplate->getCarplates());
		$this->set('searchbutton', __("Search"));
	}

}
