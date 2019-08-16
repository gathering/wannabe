<h2>Defineer problemtyper</h2>
<?=$this->element('simplelist', array(
                                            'fields' => array('name' => 'Navn'),
                                            'list' => $problems,
                                            'modelname' => 'DispatchProblem',
                                            'editfields' => true,
                                            'newitems' => 1
                                            ))?>
<p><?=$this->Html->link('Dispatch', '/'.WB::$event->reference.'/dispatch/')?></p>
