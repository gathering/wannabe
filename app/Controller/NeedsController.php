<?php

class NeedsController extends AppController {
	var $layout = 'responsive-default';
	public $uses = array('Needs');
	public $allergies = array('Fish', 'Shellfish', 'Molluscs', 'Eggs', 'Nuts', 'Peanuts', 'Celery', 'Mustard', 'Sesame seeds', 'Soy', 'Sulphites', 'Lupin', 'Citrus', 'Milk', 'Flour', 'Lactose intolerant', 'Gluten intolerant', 'Vegetarian', 'Vegan');
	
	public function index() {
		$this->Needs->id = $this->Wannabe->user['User']['id'];
		
		//if form is submitted, handle it
		if ($this->request->is('post') || $this->request->is('put')) {	
			// Collect allergies selected and store in request->allergies. Also returned to browser if user does not provide consent
				$selectedAllergies = "";
				for($i=0; $i < sizeof($this->allergies); $i++){
					if($this->request->data['Needs']['allergies'.$this->allergies[$i]]){
						$selectedAllergies .= $this->allergies[$i].',';
					}
				}			
				$this->request->data['Needs']['allergies'] = $selectedAllergies;
					
			//require consent
			if(!$this->request->data['consent']){
				$this->Flash->error(__('consent-error'), 'error');
			}
			else {
				$data = $this->request->data;
				$data['Needs']['user_id'] = $this->Needs->id;
				
				if ($this->Needs->save($data))
					$this->Flash->info(__('Your information has been updated'), 'success');
				else
					$this->Flash->error(__('Unable to save your information'), 'error');

				$this->redirectEvent('/Needs');
			}
		} 
		//if form was not submitted, populate with data from database
		else {
            $this->request->data = $this->Needs->read();
        }
		
		// prepare allergies for the form
        $selectedAllergiesArray = explode(",", $this->request->data['Needs']['allergies']);

        $allergiesToPass = array();
        for($i=0; $i < sizeof($this->allergies); $i++) {
            for($j=0; $j < sizeof($selectedAllergiesArray); $j++) {
                if($this->allergies[$i] == $selectedAllergiesArray[$j]) {
                    $allergiesToPass[$this->allergies[$i]] = "1";
                    break;
                }
				else{
                    $allergiesToPass[$this->allergies[$i]] = "0";
                }
            }
        }
		
		$this->set('allergiesValues', $allergiesToPass);
        $this->set('allergies', $this->allergies);
		$this->set('title_for_layout', __("Needs"));
		$this->set('desc_for_layout', __("Medical and nutritional needs"));
		$this->set('savebutton', __("Update information"));
	}

}
