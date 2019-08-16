<?php
class AccessController extends AppController
{

	public $uses = array('Access', 'Aclobject', 'AclobjectsRole', 'AclobjectsUser', 'Crew', 'User', 'AclobjectsCrew');

	public function index()
	{
		$this->set('acl_list', $this->Aclobject->find('all', array('order' => 'path ASC' ) ));
		$this->set('savebutton', __("Save"));
	}



	public function view()
	{
		$this->set('acl_list', $this->Aclobject->find('all', array('order' => 'path ASC' ) ));

		if ( !isset( $this->params['pass'][0] ) || !is_numeric( $this->params['pass'][0] ) )
		{
			$this->redirectEvent('/Access');
		}
		else // View Access Control object information
		{
			$this->set('access_crews', $this->Access->getCrews($this->params['pass'][0]) );
			$this->set('access_users', $this->Access->getUsers($this->params['pass'][0]) );
			$this->set('acl_object', $this->Aclobject->find('first', array( 'conditions' => array('Aclobject.id' => $this->params['pass'][0]) )));
            $this->set('crews', $this->Crew->getAllCrews(true, 0, true));
			$this->set('savebutton', __("Save"));
		}

		if (!empty($this->data))
		{
            if (isset($this->data['AclobjectsUser']))
            {
            	if ( $this->User->find('count', array('conditions' => array('User.id' => $this->data['AclobjectsUser']['user_id']))) > 0 )
            	{
            		$this->save('AclobjectsUser');
            	}
            	else
            	{
            		$this->Flash->error(__("User does not exist"));
            		$this->redirectEvent('/Access/View/'.$this->params['pass'][0]);
            	}
            }

            else if (isset($this->data['AclobjectsCrew']))
            {
            	if ( $this->Crew->find('count', array('conditions' => array('Crew.id' => $this->data['AclobjectsCrew']['crew_id']))) > 0 )
            	{
            		$this->save('AclobjectsCrew');
            	}
            	else
            	{
            		$this->Flash->error(__("Crew does not exist"));
            		$this->redirectEvent('/Access/View/'.$this->params['pass'][0]);
            	}
            }
        }

	}



	public function delete()
	{
		if (isset($this->params['pass'][0]) && isset($this->params['pass'][1]) && is_numeric($this->params['pass'][1]) && isset($this->params['pass'][2]) && is_numeric($this->params['pass'][2]))
		{
			if ($this->params['pass'][0] == 'Crew')
			{
				$this->AclobjectsCrew->deleteAll(array('AclobjectsCrew.crew_id' => $this->params['pass'][1], 'AclobjectsCrew.aclobject_id' => $this->params['pass'][2]), false);
				$this->Flash->success(__("Crew was deleted"));
            	$this->redirectEvent('/Access/View/'.$this->params['pass'][2]);
			}
			else if ($this->params['pass'][0] == 'User')
			{
				$this->AclobjectsUser->deleteAll(array('AclobjectsUser.user_id' => $this->params['pass'][1], 'AclobjectsUser.aclobject_id' => $this->params['pass'][2]), false);
				$this->Flash->success(__("User was deleted"));
            	$this->redirectEvent('/Access/View/'.$this->params['pass'][2]);
			}
			else if ($this->params['pass'][0] == 'Role')
			{
				$this->AclobjectsRole->deleteAll(array('AclobjectsRole.role' => $this->params['pass'][1], 'AclobjectsRole.aclobject_id' => $this->params['pass'][2]), false);
				$this->Flash->success(__("Role was deleted"));
            	$this->redirectEvent('/Access/Role');
			}
		}
		else if (isset($this->params['pass'][0]) && isset($this->params['pass'][1]) && is_numeric($this->params['pass'][1]))
		{
			if ($this->params['pass'][0] == 'Object')
			{
				// $this->Aclobject->deleteAll(array('Aclobject.id' => $this->params['pass'][1]), false);
				$this->Aclobject->deleteRecords($this->params['pass'][1]);
				$this->Flash->success(__("Object was deleted"));
            	$this->redirectEvent('/Access/Object');
			}
		}
	}

	public function object()
	{
		if (!empty($this->request->data))
		{
			if ($this->Aclobject->save($this->request->data))
				$this->Flash->success(__("Object was added"));
			else
				$this->Flash->error(__("Unable to add object"));

			$this->redirectEvent('/Access/Object');
		}
		$this->set('savebutton', __("Save"));
		$this->set('acl_list', $this->Aclobject->find('all', array('order' => 'path ASC' ) ));
	}

	public function modifyObject()
	{
		if (!empty($this->request->data))
		{
			if ($this->Aclobject->save($this->request->data))
				$this->Flash->success(__("Object was modified"));
			else
				$this->Flash->error(__("Unable to modify object"));

			$this->redirectEvent('/Access/Object');
		}
	}

	public function role()
	{
		$this->set('acl_list', $this->Aclobject->find('all', array('order' => 'path ASC' ) ));

		if (!empty($this->request->data))
		{
			$data = $this->request->data;
            //die(var_dump($data));

			if ($this->AclobjectsRole->save($data))
				$this->Flash->success(__("Role was added"));
			else
				$this->Flash->error(__("Unable to add role"));

			$this->redirectEvent('/Access/Role');
		}
		$this->set('role_list', $this->AclobjectsRole->getRoles());
		$this->set('savebutton', __("Save"));
		$this->set('roles', $this->Crew->getUserRoles());
	}

	private function save($model)
	{
		$error_message = '';

    	$data = $this->request->data;
    	$data[$model]['aclobject_id'] = $this->params['pass'][0];

    	if (!(isset($data[$model]['read']) || isset($data[$model]['write']) || isset($data[$model]['manage']) || isset($data[$model]['superuser'])))
    	{
    		$this->Flash->error(__("No parameter was chosen"));
            $this->redirectEvent('/Access/View/'.$this->params['pass'][0]);
    	}
        else
        {
            if ($this->$model->save($data))
            {
            	$this->Flash->success(__("User added"));
            	$this->redirectEvent('/Access/View/'.$this->params['pass'][0]);
            }
            else
            {
				foreach( $this->$model->invalidFields() as $val )
					$error_message .= $val[0];
							$this->Flash->error($error_message);
            	$this->redirectEvent('/Access/View/'.$this->params['pass'][0]);
            }
        }
	}


}
