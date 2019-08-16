<h3>Oppgaver som er under arbeid</h3>

<p>
<p><?=$this->Html->link('Hovedside', $this->Wb->eventUrl('/dispatch/'))?></p>

<table class="list" cellpadding="0" cellspacing="0">
<tr>
	<th>Opprettet</th>
	<th>Prioritet</th>
	<th>Deligert til</th>
	<th>Problem</th>
	<th>Rad</th>
	<th>Sete</th>
	<th>Switch</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
</tr>
<? foreach($cases as $case) { ?>
	<tr>
		<td><?=$case['DispatchCase']['created']?></td>
        <td><?=$priorities[$case['DispatchCase']['priority']]?></td>
		<td><?=$delegatednames[$case['DispatchCase']['delegated_user_id']]?></td>
		<td><?=$problemnames[$case['DispatchCase']['problem_id']]?></td>
		<td><?=$case['DispatchCase']['row']?></td>
		<td><?=$case['DispatchCase']['seat']?></td>
		<td><?=$case['DispatchCase']['switch']?></td>
		<td><?=$html->link('Vis/Rediger', $wb->eventUrl('/dispatch/cases/view/'.$case['DispatchCase']['id']))?></td>
		<td>
		    <form method="POST">
    		<?=$this->Form->hidden('DispatchCase.id', array('value'=>$case['DispatchCase']['id']))?>
	        <input type="submit" name="resolved" value="<?=html_entity_decode('Utf&oslash;rt')?>" />&nbsp;
	        <input type="submit" name="unresolved" value="<?=html_entity_decode('Fors&oslash;kt')?>" />&nbsp;
	        <input type="submit" name="reopen" value="<?=html_entity_decode('Gjenopprett sak')?>" />
		    </form>
		</td>
	</tr>
<? } ?>
</table>
</p>
