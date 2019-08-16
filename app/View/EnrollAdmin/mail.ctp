<div class="row">
	<div class="span16">
		<table class="bordered-table">
			<tr>
				<th><?=__("Name")?></th>
				<th><?=__("Name as Header")?></th>
				<th><?=__("Content")?></th>
				<th><?=__("Position")?></th>
				<th><?=__("Edit")?></th>
				<th><?=__("Delete")?></th>
			</tr>
			<?php foreach($mail['EnrollMailfield'] as $field) { ?>
				<tr>
					<td><?=$field['name']?></td>
					<td><?=$field['name_as_header']?__("Yes"):__("No")?></td>
					<td><pre class="prettyprint lang-html"><?=htmlentities($field['content'], ENT_COMPAT | 'ENT_HTML5', "UTF-8")?></pre></td>
					<td><?=$field['position']?></td>
					<td><a href="<?=$this->Wb->eventUrl('/EnrollAdmin/fieldedit/'.$field['id'])?>" class="btn"><?=__("Edit")?></a></td>
					<td><a href="<?=$this->Wb->eventUrl('/EnrollAdmin/fielddelete/'.$field['id'])?>" class="btn danger"><?=__("Delete")?></a></td>
				</tr>
			<?php } ?>
		</table>
	</div>
</div>
<div class="row">
	<div class="span16">
		<a href="<?=$this->Wb->eventUrl('/EnrollAdmin/fieldcreate/'.$mail['EnrollMail']['id'])?>" class="btn primary"><?=__("Create field")?></a> <a href="<?=$this->Wb->eventUrl('/EnrollAdmin')?>" class="btn"><?=__("Back")?></a>
	</div>
</div>
