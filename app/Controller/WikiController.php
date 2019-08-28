<?
/**
 * This wiki will be connected to the rest of Wannabe on some way, like, displaying
 * user profiles with the possibility to edit a text below it.
 *
 */

class WikiController extends AppController {
	public $uses = array( 'Event', 'Acl', 'User', 'Wikipage', 'Userinfo' );
	public $helpers = array('Html', 'Diff', 'Form');

	var $layout = 'responsive-default';

	/**
	 * This function acts as a delegator of tasks.
	 * It gets all requests to the wikithingie.
	 */
	public function index($test = null) {
		preg_match('/\/(\w+)\/(\w+)\/(.*)/', $this->here, $matches);
		array_splice($matches, 0, 3);
		$args = preg_split('[/]', $matches[0]);

		$num_args = sizeof($args);

		// Make sure the title is camelized.
		if ( $num_args > 0 && ($camelizedtitle = Inflector::camelize($args[0])) != $args[0] ) {
			$args[0] = $camelizedtitle;
			$this->redirect('/' . $this->Wannabe->event->reference . '/Wiki/' . join('/', $args));
			return;
		}

		switch ( $num_args ) {
			case 0:
				$this->redirect("/{$this->Wannabe->event->reference}/Wiki/Front");
				break;

			case 1:
				$args[0] = urldecode($args[0]);
				switch ($args[0]) {
					case 'History':
						$this->history($args[0]);
						break;
					default:
						if(isset($this->params['requested'])) {
							$output = $this->view($args[0]);
							return $output;
						} else {
							$this->view($args[0]);
						}
				}
				break;

			case 2:
				$command = array_pop($args);
				$args[0] = urldecode($args[0]);
				switch ($command) {
					case 'edit':
						$this->edit($args[0]);
						break;

					case 'delete':
						$this->delete($args[0]);
						break;

					case 'history':
						$this->history($args[0]);
						break;

					case 'diff':
						$this->diff($args[0]);
						break;

					case 'save':
						if ( $_SERVER['REQUEST_METHOD'] != 'POST' )
							throw new CakeException(__("Bad request."));
						$this->save($args[0]);
						break;

					default:
						throw new CakeException(null);
				}
				break;

			default:
				throw new CakeException("Exception made in WikiController");
		}
	}

	/**
	 * View a wiki page. This is also some kind of a delegator of tasks, it
	 * sends the user to the correct "sub pages".
	 */
	private function view($title) {
		$view = 'view';

		// is the requested page a for some special functionality?
		// like a user's own wikipage.
		if ( strpos($title, ':') !== false ) {
			list($command, $_title) = preg_split('/:/', $title, 2);
			#preg_match('/^(\d+|(\w+(:\w+){0,1}))/i', $_title, $matches);
			#$_title = $matches[0];
			if ( is_callable(array($this, 'view'.$command)) == false )
				throw new BadRequestException(__("Bad Request"));
			$view = $this->{'view'.$command}($_title);

		}

		// default conditions.
		$conditions = array(
			'title' => $title,
			'event_id' => $this->Wannabe->event->id
		);

		// display a specific revision? add it to conditions.
		if ( isset($_REQUEST['revision']) == true && (int)$_REQUEST['revision'] ) {
			$conditions['revision'] = (int)$_REQUEST['revision'];
		}

		// retrieve the page!
		$page = $this->Wikipage->find('first', array(
			'conditions' => $conditions,
			'order' => 'Wikipage.created DESC',
		));

		if ( $page == false ) {
		// we did not find a matching page,
		// display a dummy.
			$page = array(
				'Wikipage' => array('title'=>$title)
			);
			$view = 'create';
		} else {
			// run markdown on the content.
			$page = $this->Wikipage->format($page, $this);
		}
		if (isset($this->params['requested'])) {
			return $page;
		} else {
			$this->set('title_for_layout', $title);
			$this->set('desc_for_layout', __("Wiki"));
			$this->set('page', $page);
			$this->render($view);
		}
	}

	/**
	 * Displays history for a page or the wiki as a whole.
	 */
	private function history($title=null) {
		$conditions = array(
			'event_id' => $this->Wannabe->event->id
		);
		$diff = false;

		if ( $title != 'History' ) {
			$conditions['title'] = $title;
			$diff = true;
			$this->set('title', $title);
		}

		$pages = @$this->Wikipage->find('all', array(
			'conditions' => $conditions,
			'order' => 'Wikipage.created DESC'
		));
		$this->set('title_for_layout', $title);
		$this->set('desc_for_layout', __("History of wiki page"));
		$this->set('canDiff', $diff);
		$this->set('pages', $pages);
		$this->render('history');
	}

	/**
	 * View a user record as a wikipage (content that can be updated).
	 */
	private function viewUser($title) {
		return('viewmeta');
	}

	private function viewCrew($title) {
		return('viewmeta');
	}

	private function edit($title) {
		$page = $this->Wikipage->find('first', array(
			'conditions' => array(
				'title'=>$title,
				'event_id'=>(int)$this->Wannabe->event->id
			),
			'order' => 'Wikipage.revision DESC'
		));

		if ( $page == false ) {
			// could not find any page matching, that title.
			// display a dummy article.
			$page = array(
				'Wikipage' => array(
					'title' => $title,
					'revision' => 0,
					'content' => null
				)
			);
		}

		$page['Wikipage']['comment'] = null;
		$this->set('title_for_layout', $title);
		$this->set('desc_for_layout', __("Edit wiki page"));
		$this->set('page', $page);
		$this->render('edit');
	}

	private function diff($title) {
		$a = $this->Wikipage->find('first', array(
			'conditions' => array(
				'title'=>$title,
				'event_id'=>$this->Wannabe->event->id,
				'revision'=>(int)$_GET['a']
			)
		));
		$b = $this->Wikipage->find('first', array(
			'conditions' => array(
				'title'=>$title,
				'event_id'=>$this->Wannabe->event->id,
				'revision'=>(int)$_GET['b']
			)
		));

		if ( $a == false || $b == false )
			throw new CakeException(__("One or more of the versions does not exist."));

		$this->set('pagefirst', $a);
		$this->set('pagesecond', $b);
		$this->set('title_for_layout', $title);
		$this->set('desc_for_layout', __("Compare wiki pages"));
		$this->render('diff');
	}

	private function save($title) {
		$savedata['Wikipage']['title'] = $title;
		$savedata['Wikipage']['user_id'] = $this->Wannabe->user['User']['id'];
		$savedata['Wikipage']['event_id'] = $this->Wannabe->event->id;
		$savedata['Wikipage']['content'] = $this->data['Wikipage']['content'];
		$savedata['Wikipage']['comment'] = $this->data['Wikipage']['comment'];
		$this->Wikipage->save($savedata);
		$this->redirect('/'.$this->Wannabe->event->reference.'/Wiki/'.$title);
	}

	private function delete($title) {
		$this->set('title', $title);
		$this->render('delete');
	}
}
?>
