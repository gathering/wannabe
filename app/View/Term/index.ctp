<h3><?=$term['Term']['title']?></h3>
<p><?=$term['Term']['content']?></p>
<form method="POST">
    <div class="actions">
		<?=$this->Form->submit(__("Agree and continue"), array('div' => false, 'class' => 'btn btn-success','name'=>'accepted'))?> <a href="<?=$this->Wb->eventUrl('/User/logout')?>" class="btn btn-danger"><?=__("Disagree and log out")?></a>
    </div>
</form>
