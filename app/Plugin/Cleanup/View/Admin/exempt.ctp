<div class="row">
    <div class="span16">
    <?php if (empty($exempted_crews)) { ?>
        <p><?= __('There are no exempt crews for')?> <?=$event?></p>  
    <?php } else { ?>
        <table class="zebra-striped bordered-table">
            <thead>
                <tr>
                    <th><?=__("Crew")?></th>
                    <th><?=__("Exempted by user")?></th>
                    <th></th>
                </tr>
            </thead>
        <?php foreach ($exempted_crews as $exempted_crew) : ?>
            <tr>
                <td><?= $exempted_crew['Crew']['name'] ?></td>
                <td><?= $this->Wb->userLink($exempted_crew) ?></td>
                <td><a href="<?=$this->Wb->eventUrl('/Cleanup/Admin/remove/exempt:' . $exempted_crew['Crew']['id'])?>" class="btn small error delete"><?=__('Delete')?></a></td>
            </tr>
        <?php endforeach; ?>
        </table>
    <?php } ?> 
    </div>
</div>
<div class="row">
    <div class="span16">
        <hr />
        <form method="post" class="form-stacked" action="<?=$this->Wb->eventUrl('/Cleanup/Admin/exempt')?>">
            <fieldset>
                <legend><?=__("Choose crew")?></legend>
                <div class="clearfix">
                    <div class="input">
                        <select class="span3" name="crew_id" id="CrewID">
                            <? foreach ($crews as $crew_id => $name): ?>
                                <option value="<?=$crew_id?>"><?=$name?></option>
                            <? endforeach; ?>
                        </select>
                    </div>
                </div>
            </fieldset>
            <div class="actions">
                <?=$this->Form->submit(__('Exempt crew from cleanup'), array('class' => 'btn success', 'name'=>'save', 'div' => false))?> 
                <a href="<?=$this->Wb->eventUrl("/Cleanup/Admin")?>" class="btn default"><?=__('Done')?></a>
            </div>
        </form>
    </div>
</div>
