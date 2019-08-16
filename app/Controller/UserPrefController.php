<?php
class UserPrefController extends AppController
{
	public function index() {
		$this->set('title_for_layout', __("User preferences"));
	}
}
