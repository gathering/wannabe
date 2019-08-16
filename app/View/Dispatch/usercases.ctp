<h3>Mine saker</h3>

<p>
<p><?=$this->Html->link('Hovedside', $this->Wb->eventUrl('/dispatch/'))?></p>

<table class="list" cellpadding="0" cellspacing="0">
<tr>
	<th>Opprettet</th>
	<th>Prioritet</th>
	<th>Problem</th>
	<th>Rad</th>
	<th>Sete</th>
	<th>Switch</th>
	<th>&nbsp;</th>
</tr>
<? if( count($cases) ) { foreach($cases as $case) { ?>
	<tr>
		<td><?=$case['DispatchCase']['created']?></td>
		<td><?=$priorities[$case['DispatchCase']['priority']]?></td>
		<td><?=$problemnames[$case['DispatchCase']['problem_id']]?></td>
		<td><?=$case['DispatchCase']['row']?></td>
		<td><?=$case['DispatchCase']['seat']?></td>
		<td><?=$case['DispatchCase']['switch']?></td>
		<td><?=$html->link('Vis/Rediger', $wb->eventUrl('/dispatch/cases/view/'.$case['DispatchCase']['id']))?></td>
	</tr>
<? }} ?>
</table>
</p>
