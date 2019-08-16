<?php
class DispatchProblem extends AppModel {
	public $name = 'DispatchProblem';

	public function generateList ($conditions=null, $order=null, $limit=null, $keyPath=null, $valuePath=null)
	{
		if(!$order)
		{
			$order = 'name ASC';
		}
		return $this->find('list', $conditions, $order, $limit, $keyPath, $valuePath);
	}
}
