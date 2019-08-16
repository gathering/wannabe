<h3>Oppgaver som ikke er delegert</h3>

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
	<th>Deliger til</th>
	<th>&nbsp;</th>
</tr>
<? foreach($cases as $case) { ?>
	<tr>
		<td><?=$case['DispatchCase']['created']?></td>
        <td><?=@$priorities[$case['DispatchCase']['priority']]?></td>
		<td><?=$problemnames[$case['DispatchCase']['problem_id']]?></td>
		<td><?=$case['DispatchCase']['row']?></td>
		<td><?=$case['DispatchCase']['seat']?></td>
		<td><?=$case['DispatchCase']['switch']?></td>
        <td><?=$this->Html->link('Vis/Rediger', $this->Wb->eventUrl('/dispatch/cases/view/'.$case['DispatchCase']['id']))?></td>
		<td>
		    <form method="POST">
	    	    <?=$this->Form->hidden('DispatchCase.id', array('value'=>$case['DispatchCase']['id']))?>
		        <?=$this->Form->select('DispatchCase.delegated_user_id', $delegatednames)?>&nbsp;
		        <input type="submit" value="Deleger" />
		    </form>
		</td>
		<td>
		    <form method="POST">
    		    <?=$this->Form->hidden('DispatchCase.id', array('value'=>$case['DispatchCase']['id']))?>
		        <input type="submit" name="unresolved" value="<?=html_entity_decode('Kan ikke l&oslash;ses')?>" />
		    </form>
		</td>
	</tr>
<? } ?>
</table>
</p>
