<?
class SearchController extends AppController {
	public $uses = array('Event', 'User', 'Crew', 'Acl');

	public function index() {
		$this->set('crews', $this->Crew->getAllCrews(true));
		$this->set('desc_for_layout', "");
	}

	public function process() {
		if((!isset($_GET['query']) || !$_GET['query']) && !isset($_GET['crew_id']) && !isset($_GET['assigned'])) {
			throw new BadRequestException(__("Empty search not allowed"));
		}
		$query = null;
		$crew_id = false;
		$assigned = false;
		if(isset($_GET['query'])) $query = $_GET['query'];
		if(isset($_GET['crew_id'])) $crew_id = $_GET['crew_id'];
		if(isset($_GET['assigned'])) $assigned = $_GET['assigned'];
		$users = $this->User->search(str_replace(" ", "%", $query),$crew_id,$assigned);

		if (sizeof($users) == 1) {
			$this->redirectEvent('/Profile/View/'.$users[0]['User']['id']);
			return;
		}

		$this->set('search', array(
			'query' => $query,
			'crew_id' => $crew_id,
			'assigned' => $assigned
		));

		$this->set('users', $users);
		$this->set('crews', $this->Crew->getAllCrews(true));
		$this->set('title_for_layout', __("Results"));
		$this->set('desc_for_layout', "");
		$this->render('results');
	}
}
?>
