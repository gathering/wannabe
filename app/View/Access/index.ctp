<ul class="tabs">
  <li class="active"><a href="#">Access control list</a></li>
  <li><a href="/<?=$wannabe->event->reference?>/Access/Object">Manage ACL objects</a></li>
  <li><a href="/<?=$wannabe->event->reference?>/Access/Role">Manage ACL roles</a></li>
</ul>

<div class="row">
	<div class="span5">
		<h6><?=('Access control list objects')?></h6>
		<ul>
			<?php
			foreach ($acl_list as $l)
			{
				echo '<li><a href="/'.$wannabe->event->reference.'/Access/View/'.$l['Aclobject']['id'].'">' . $l['Aclobject']['path'] . '</a></li>'."\n";
			}
			?>
		</ul>
	</div>


	<div class="span10">
		<h1><?=__('Access control')?></h1>
	</div>
</div>
