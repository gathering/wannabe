<h3>Dispatch</h3>

<br />

<p>
<?=$this->Html->link('Legg til sak', $this->Wb->eventUrl('/dispatch/createCase') )?><br />
<? if( isset($canManageProblems) ) { ?>
    <?=$this->Html->link('Endre/legg til problemtyper', $this->Wb->eventUrl('/dispatch/problems') ).'<br />'?>
<? } ?>
</p>
<p>
<?=$this->Html->link('Mine saker', $this->Wb->eventUrl('/dispatch/usercases'))?> <br />
<?=$this->Html->link('Udeligerte saker', $this->Wb->eventUrl('/dispatch/undelegatedcases'))?> <?=($undelegatednum ? "($undelegatednum nye)" : '')?> <br />
<?=$this->Html->link('Saker under arbeid', $this->Wb->eventUrl('/dispatch/delegatedCases'))?> <?=($delegatednum ? "($delegatednum nye)" : '')?> <br />
<?=$this->Html->link(html_entity_decode('Lukkede, men ul&oslash;ste saker'), $this->Wb->eventUrl('/dispatch/cases/unresolved'))?> <?=($unresolvednum ? "($unresolvednum nye)" : '')?> <br />
<?=$this->Html->link(html_entity_decode('Lukkede og l&oslash;ste saker'), $this->Wb->eventUrl('/dispatch/cases/resolved'))?> <?=($resolvednum ? "($resolvednum nye)" : '')?> <br />
</p>

<hr />
<? if(isset($cases) && count($cases)) { ?>
<h3>Saker under arbeid</h3>

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
            <form method="POST" action=<?=$wb->eventUrl('/dispatch/cases/delegated')?>>
            <?=$form->hidden('DispatchCase.id', array('value'=>$case['DispatchCase']['id']))?>
            <input type="submit" name="resolved" value="<?=html_entity_decode('Utf&oslash;rt')?>" />&nbsp;
            <input type="submit" name="unresolved" value="<?=html_entity_decode('Fors&oslash;kt')?>" />&nbsp;
            <input type="submit" name="reopen" value="<?=html_entity_decode('Gjenopprett sak')?>" />
            </form>
        </td>
    </tr>
<? } ?>
</table>
<? } else { ?>
<h3>Det er ingen saker under arbeid</h3>
<? } ?>
