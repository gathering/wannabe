<?php

class SlideshowController extends AppController
{
	public $uses = array('Slideshow', 'SlideshowsSlide');
	var $layout = 'responsive-default';

	public function beforeFilter() {
		if(
			$this->request->params['action'] == 'RunSlideshow' ||
			$this->request->params['action'] == 'RunSlideshow720' ||
			$this->request->params['action'] == 'RunSlideshowLoFi' ||
			$this->request->params['action'] == 'getSlideShow'
		) {
			$this->requireLogin = false;
		}
		parent::beforeFilter();
	}

	public function index()
	{
		$this->set('savebutton', __("Save"));
		$this->set('slideshows', $this->Slideshow->find('all', array(
            'conditions' => array(
                'Slideshow.event_id' => $this->Wannabe->event->id
            ),
            'order' => array('Slideshow.name ASC')
            )
        ));


		if (!empty( $this->request->data ))
		{
            $this->request->data['Slideshow']['event_id'] = $this->Wannabe->event->id;
			if ( $this->Slideshow->save($this->request->data) )
				$this->Flash->success(__("Slideshow saved"));
			else
				$this->Flash->error(__("Unable to save slideshow"));

			$this->redirectEvent('/Slideshow/');
		}

		#$this->set('test', $show_id = $this->Session->read('runSlideShowId'));

	    #$this->set('slides', $this->SlideshowsSlide->find('all', array(
        #    'conditions' => array(
        #        'SlideshowsSlide.show_id' => 5
        #    ))
        #));
	}


	public function runSlideshow($show_id = 0)
	{
		if($show_id == 0)
			$this->redirectEvent('/Slideshow/Edit/'.$show_id);
		else
			$this->Session->write('runSlideShowId', $show_id);
		$this->render('run_slideshow','empty');

	}

    public function runSlideshow720($show_id = 0)
    {

        if($show_id == 0)
            $this->redirectEvent('/Slideshow/Edit/'.$show_id);
        else
            $this->Session->write('runSlideShowId', $show_id);
        $this->render('run_slideshow720','empty');
    }

    /**
     * Same slides as runSlideshow, only without the animated background
     *
     * @param int $show_id
     */
    public function runSlideshowLofi($show_id = 0)
    {

        if($show_id == 0)
            $this->redirectEvent('/Slideshow/Edit/'.$show_id);
        else
            $this->Session->write('runSlideShowId', $show_id);
        $this->render('run_slideshow_lofi','empty');
    }

    public function getSlideShow()
	{
		$show_id 	= $this->Session->read('runSlideShowId') < 1 ? 1 : $this->Session->read('runSlideShowId');
		$slides 	= $this->SlideshowsSlide->find('all', array('conditions' => array('SlideshowsSlide.show_id' => $show_id), 'order' => 'SlideshowsSlide.title'));
		$show = $this->Slideshow->find('first', array('conditions' => array('Slideshow.id' => $show_id)));

		if($show['Slideshow']['master'] != 0 && $show['Slideshow']['master'] != null && $show['Slideshow']['master'] != "0") {
			$slides = $this->SlideshowsSlide->find('all', array(
			    'joins' => array(
			        array(
			            'table' => 'wb4_slideshows',
			            'alias' => 'Slideshows',
			            'type' => 'INNER',
			            'conditions' => array(
			                'Slideshows.id = SlideshowsSlide.show_id'
			            )
			        )
			    ),
			    'conditions' => array(
						'SlideshowsSlide.show_id' => array($show_id, $show['Slideshow']['master'])
			    ),
			    'fields' => array('Slideshows.*', 'SlideshowsSlide.*'),
			    'order' => 'Slideshows.master ASC'
			));
		}


		$return = array();
		$count = 0;

		for ($i = 0; $i < count($slides); $i++) {
			if ($slides[$i]['SlideshowsSlide']['date_from'] != null && $slides[$i]['SlideshowsSlide']['date_from'] > date("Y-m-d H:i:s")) continue;
			if ($slides[$i]['SlideshowsSlide']['date_to'] != null && $slides[$i]['SlideshowsSlide']['date_to'] < date("Y-m-d H:i:s")) continue;

			$return[$count++] = array(
					'id' => $slides[$i]['SlideshowsSlide']['id'],
					'title' => $slides[$i]['SlideshowsSlide']['title'],
					'duration' => isset($slides[$i]['SlideshowsSlide']['duration']) ? $slides[$i]['SlideshowsSlide']['duration'] * 1000 : 10000,
					'content' => $slides[$i]['SlideshowsSlide']['content'],
					'bg_url' => $slides[$i]['SlideshowsSlide']['bg_url'],
					'type' => $slides[$i]['SlideshowsSlide']['type'],
					'url' => $slides[$i]['SlideshowsSlide']['url']
			);
		}

        $json = json_encode($return);
        $this->set('json', $json);
        $this->render('ajax-slideshow', 'empty');
	}

	/* Edit functions
	------------------------------------------------ */

	public function edit($show_id = 0)
	{
		$this->set('slides', $this->SlideshowsSlide->find('all', array('conditions' => array('SlideshowsSlide.show_id' => $show_id), 'order' => 'SlideshowsSlide.title')));
		$this->set('show_id', $show_id);

		$show = $this->Slideshow->find('first', array('conditions' => array('Slideshow.id' => $show_id)));
		$this->set('show', $show);

		$masters = $this->Slideshow->find('list', array(
            'conditions' => array(
                'Slideshow.event_id' => $this->Wannabe->event->id,
								'Slideshow.master' => 0,
								'Slideshow.id !=' => $show_id
            ),
            'order' => array('Slideshow.name ASC'),
						'fields' => array('id','name')
					));
		$this->set('masters', $masters);
		$this->set('savebutton', __("Save"));

	}
	public function SaveMaster($show_id = 0, $master = 0)
	{
		$this->Slideshow->save($this->request->data);
		$this->redirectEvent('/Slideshow/Edit/'.$this->request->data['Slideshow']['id']);
	}



	/* Editor functions
	------------------------------------------------ */

	public function text($show_id = 0, $slide_id = null)
	{
		$show = $this->Slideshow->find('first', array('Slideshow.id' => $show_id));
		if (isset($slide_id))
			$this->data = $this->SlideshowsSlide->find('first', array('conditions' => array('SlideshowsSlide.id' => $slide_id)));
		$this->set('show_id', $show_id);
		$this->set('duration', isset($this->request->data['SlideshowsSlide']['duration']) ? $this->request->data['SlideshowsSlide']['duration'] : '60' );
		$this->set('date_from', isset($this->request->data['SlideshowsSlide']['date_from']) ? $this->request->data['SlideshowsSlide']['date_from'] : date('Y-m-d H:i:s') );
		$this->set('date_to', isset($this->request->data['SlideshowsSlide']['date_to']) ? $this->request->data['SlideshowsSlide']['date_to'] : date('Y-m-d H:i:s', strtotime(' +1 day')) );
	}

	public function scheduleitem($show_id = 0, $slide_id = null)
	{
		$show = $this->Slideshow->find('first', array('Slideshow.id' => $show_id));
		if (isset($slide_id))
			$this->data = $this->SlideshowsSlide->find('first', array('conditions' => array('SlideshowsSlide.id' => $slide_id)));
		$this->set('show_id', $show_id);
		$this->set('duration', isset($this->request->data['SlideshowsSlide']['duration']) ? $this->request->data['SlideshowsSlide']['duration'] : '60' );
		$this->set('date_from', isset($this->request->data['SlideshowsSlide']['date_from']) ? $this->request->data['SlideshowsSlide']['date_from'] : date('Y-m-d H:i:s'));
        $this->set('date_to', isset($this->request->data['SlideshowsSlide']['date_to']) ? $this->request->data['SlideshowsSlide']['date_to'] : date('Y-m-d H:i:s', strtotime(' +1 day')) );
	}

	public function url($show_id = 0, $slide_id = null)
	{
		$show = $this->Slideshow->find('first', array('Slideshow.id' => $show_id));
		if (isset($slide_id))
			$this->data = $this->SlideshowsSlide->find('first', array('conditions' => array('SlideshowsSlide.id' => $slide_id)));
		$this->set('show_id', $show_id);
		$this->set('name', isset($this->request->data['SlideshowsSlide']['name']) ? $this->request->data['SlideshowsSlide']['name'] : '' );
		$this->set('duration', isset($this->request->data['SlideshowsSlide']['duration']) ? $this->request->data['SlideshowsSlide']['duration'] : '60' );
		$this->set('url', isset($this->request->data['SlideshowsSlide']['url']) ? $this->request->data['SlideshowsSlide']['url'] : '' );
        $this->set('date_from', isset($this->request->data['SlideshowsSlide']['date_from']) ? $this->request->data['SlideshowsSlide']['date_from'] : date('Y-m-d H:i:s'));
        $this->set('date_to', isset($this->request->data['SlideshowsSlide']['date_to']) ? $this->request->data['SlideshowsSlide']['date_to'] : date('Y-m-d H:i:s', strtotime(' +1 day')) );
		$this->set('savebutton', __("Save"));
	}

	public function stream($show_id = 0, $slide_id = null)
	{
		$show = $this->Slideshow->find('first', array('Slideshow.id' => $show_id));
		if (isset($slide_id))
			$this->data = $this->SlideshowsSlide->find('first', array('conditions' => array('SlideshowsSlide.id' => $slide_id)));
		$this->set('show_id', $show_id);
		$this->set('name', isset($this->request->data['SlideshowsSlide']['name']) ? $this->request->data['SlideshowsSlide']['name'] : '' );
		$this->set('duration', isset($this->request->data['SlideshowsSlide']['duration']) ? $this->request->data['SlideshowsSlide']['duration'] : '900' );
		$this->set('url', isset($this->request->data['SlideshowsSlide']['url']) ? $this->request->data['SlideshowsSlide']['url'] : '' );
        $this->set('date_from', isset($this->request->data['SlideshowsSlide']['date_from']) ? $this->request->data['SlideshowsSlide']['date_from'] : date('Y-m-d H:i:s'));
        $this->set('date_to', isset($this->request->data['SlideshowsSlide']['date_to']) ? $this->request->data['SlideshowsSlide']['date_to'] : date('Y-m-d H:i:s', strtotime(' +1 day')) );
		$this->set('savebutton', __("Save"));
	}



	/* Save functions
	------------------------------------------------ */

	public function saveSlide($type = 'text')
	{
		$this->SlideshowsSlide->save($this->data);
		$this->redirectEvent('/Slideshow/Edit/'.$this->data['SlideshowsSlide']['show_id']);
	}



	/* Delete functions
	------------------------------------------------ */

	public function deleteShow($show_id = -1)
	{
		if ($show_id != -1)
		{
			$this->Slideshow->deleteAll(array('Slideshow.id' => $show_id));
			$this->Flash->success(__("Slideshow was deleted"));
		}
		else
		{
			$this->Flash->error(__("Unable to delete slideshow"));
		}
        $this->redirectEvent('/Slideshow/');
	}

	public function deleteSlide($show_id = -1, $slide_id = -1)
	{
		if ($show_id != -1)
		{
			$this->SlideshowsSlide->deleteAll(array('SlideshowsSlide.id' => $slide_id));
			$this->Flash->success(__("Slide was deleted"));
		}
		else
		{
			$this->Flash->error(__("Unable to delete slide"));
		}
        $this->redirectEvent('/Slideshow/Edit/'.$show_id);
	}

}
