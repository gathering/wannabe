<div class="row">
    <div class="col-md-12">
            <form method="post">
                <div class="clearfix <? if($this->Form->error('Crew.name')) echo "error"; ?>">
                    <div class="input-group">
                        <span class="input-group-addon"><?=__("Name")?></span>
                        <?=$this->Form->input('Crew.name', array('class' => 'form-control', 'div' => false, 'error' => false, 'label' => false))?>
                    </div>
                    <span class="help-block"><?=$this->Form->error('Crew.name')?></span>
                </div>
                <div class="clearfix <? if($this->Form->error('Crew.crew_id')) echo "error"; ?>">
                    <div class="input-group">
                        <span class="input-group-addon"><?=__("Parent crew")?></span>
                        <?=$this->Form->select('Crew.crew_id', $crewlist, array('class' => 'form-control', 'empty' => __("None"), 'div' => false, 'error' => false, 'label' => false))?>
                        <span class="help-block"><?=$this->Form->error('Crew.crew_id')?></span>
                    </div>
                </div>
                <div class="clearfix">
                    <br>
                    <ul class="inputs-list">
                        <li>
                            <label>
                                <?=$this->Form->checkbox('Crew.hidden', array('div' => false, 'error' => false, 'label' => false))?>
                                <span><?=__("Hide this crew from the crew list")?></span>
                            </label>
                        </li>
                        <li>
                            <label>
                                <?=$this->Form->checkbox('Crew.canapply', array('div' => false, 'error' => false, 'label' => false))?>
                                <span><?=__("Open for applications")?></span>
                            </label>
                        </li>
                    </ul>
                </div>
                <div class="clearfix">
                    <label for="data[Crew][content]"><?=__("Description")?></label>
                    <textarea name="data[Crew][content]" id="CrewContent" class="form-control" style="height: 100px;"></textarea>
                    <span class="help-block"><?=__("Help with")?> <a href="http://daringfireball.net/projects/markdown/syntax">syntax</a>?</span>
                </div>
                <div class="actions">
                    <?=$this->Form->submit(__("Create"), array('div' => false, 'label' => false, 'name' => 'save-settings', 'class' => 'btn btn-default primary'))?>
                </div>
            </form>
    </div>
</div>