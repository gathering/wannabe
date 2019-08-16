<div class="row">
    <div class="span16">
        <div class="page-header">
        <h2>Assign cleanup <small><?=__("for")?> <?=isset($members)?$crews[$this->params['named']['crew']]:''?></small></h2>
        </div>
        <?php if(isset($members)): ?>
            <table class="zebra-striped bordered-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?=__("User")?></th>
                        <th><?=__("Time")?></th>
                        <th></th>
                    </tr>
                </thead>
            <?php foreach ($members as $member): ?>
                <tr>
                    <td><?=$member['User']['id']?></td>
                    <td><?=$this->Wb->userLink($member)?></td>
                    <?php if(isset($member['CleanupPosition']['completed']) && $member['CleanupPosition']['completed']): ?>
                        <td class="green">✔ <?=__("Completed")?></td>
                    <?php elseif(isset($member['Cleanup'])): ?>
                        <td class="moment format"><?=$member['Cleanup']['unixtime']?></td>
                    <?php else: ?>
                        <td class="red">✘ <?=__("Not set")?></td>
                    <?php endif; ?>
                    <td class="buttongroup">
                        <?php if(!isset($member['CleanupPosition']['completed']) || !$member['CleanupPosition']['completed']): ?>
                            <form method="post" class="form-table">
                                <input type="hidden" name="user_id" value="<?=$member['User']['id']?>">
                                <?php if(isset($member['Cleanup']['time'])): ?>
                                    <a href="<?=$this->Wb->eventUrl('/Cleanup/Admin/remove/user:' . $member['User']['id'])?>" class="btn small error delete"><?=__('Delete')?></a>
                                <?php else: ?>
                                    <?php if($isFull): ?>
                                        <?=__("Cleanup is full")?>
                                    <?php else: ?>
                                        <?=$this->Form->submit(__('Add'), array('class' => 'btn small success', 'name'=>'save', 'div' => false))?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</div>
<div class="row">
    <div class="span16">
        <form method="post" class="form-stacked">
            <?php if(!isset($members)): ?>
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
            <?php else: ?>
                <input type="hidden" name="crew_id" value="<?=$this->params['named']['crew']?>">
            <?php endif; ?>
            <div class="actions">
                <?php if(isset($members)): ?>
                    <?=$this->Form->submit(__('Add whole crew to cleanup'), array('class' => 'btn success', 'name'=>'save', 'div' => false))?>
                    <a href="<?=$this->Wb->eventUrl('/Cleanup/Admin/assign/crew:' . $this->params['named']['crew'])?>" class="btn default"><?=__('Back to crew overview')?></a>
                    <a href="<?=$this->Wb->eventUrl('/Cleanup/Admin/assign/cleanup:' . $this->params['named']['cleanup'])?>" class="btn default"><?=__('Back to crew selection')?></a>
                <?php else: ?>
                    <?=$this->Form->submit(__('Next'), array('class' => 'btn success', 'name'=>'next', 'div' => false))?>
                    <a href="<?=$this->Wb->eventUrl('/Cleanup/Admin')?>" class="btn default"><?=__('Back')?></a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>
