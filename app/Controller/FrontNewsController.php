<?php
/**
 * FrontNews Controller
 *
 */
class FrontNewsController extends AppController {

	public $uses = array('FrontNews');

	public $requireLogin = false;

	function index() {
		$news = Cache::read('news'.$this->Wannabe->lang);
		if(!$news) {
			$news = $this->FrontNews->find('all', array(
				'conditions' => array(
					'FrontNews.active' => 1
				),
				'order' => array(
					'FrontNews.created' => 'desc'
				)
			));
			Cache::write('news'.$this->Wannabe->lang, $news);
		}
		if (isset($this->params['requested'])) {
			return $news;
		} else {
			$this->redirect('/');
		}
	}
}
