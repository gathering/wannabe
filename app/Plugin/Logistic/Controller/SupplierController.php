<?
class SupplierController extends LogisticAppController {

    public $uses = array('Logistic.LogisticSupplier', 'Logistic.LogisticLocation');
    var $layout = 'responsive-default';

    public function index() {
        $this->set('suppliers', $this->LogisticSupplier->find('all', array(
            'order' => 'company ASC'
        )));
        $this->set('title_for_layout', __("Suppliers"));
    }

    public function create() {
		if($this->request->is('post')) {
			if($this->LogisticSupplier->save($this->request->data)) {
				$this->Flash->success(__("%s was created", $this->request->data['LogisticSupplier']['company']));
				$this->redirectEvent('/logistic/supplier');
			}
		}
		$this->set('title_for_layout', __("Create new supplier"));
    }

    public function edit($id=0) {
		if($this->request->is('post')) {
			if($this->LogisticSupplier->save($this->request->data)) {
				$this->Flash->success(__("%s was updated", $this->request->data['LogisticSupplier']['company']));
				$this->redirectEvent('/logistic/supplier');
			}
		}
        if(!$id) {
            $this->Flash->info(__("Select supplier to edit"));
            $this->redirectEvent('/logistic/Supplier');
        }
		$this->set('title_for_layout', __("Edit supplier"));
        $supplier = $this->LogisticSupplier->find('first', array(
            'conditions' => array(
                'LogisticSupplier.id' => $id
            )
        ));
        $this->set('supplier', $supplier);
    }
    public function delete($id) {
        if(!$this->Acl->hasAccess('manage'))
            throw new ForbiddenException(__("You don't have access to manage this"));
		if($this->request->is('post')) {
			if($this->LogisticSupplier->delete($this->request->data['LogisticSupplier']['id'])) {
				$this->Flash->success(__("Supplier deleted"));
                                $this->redirectEvent('/logistic/supplier');
			}
		}
		if(!$id) {
			$this->Flash->warning(__("Select supplier to delete"));
                        $this->redirectEvent('/logistic/supplier');
		}
		$supplier = $this->LogisticSupplier->find('first', array(
			'conditions' => array(
				'LogisticSupplier.id' => $id
			)
		));
		if(!is_array($supplier)) {
			throw new BadRequestException(__("No such supplier"));
		}
		$this->set('supplier', $supplier);
		$this->set('title_for_layout', __("Delete supplier"));
		$this->set('desc_for_layout', $supplier['LogisticSupplier']['company']);
	}
}
