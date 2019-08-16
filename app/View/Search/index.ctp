<div class="row">
	<div class="span16">
		<form class="form-stacked" method="GET" action="<?=$this->Wb->eventUrl('/Search/process')?>">
			<fieldset>
				<div class="clearfix">
					<label for="assigned"><?=__("Member")?></label>
					<div class="input">
						<ul class="inputs-list">
							<li>
								<label>
									<?=$this->Form->checkbox("assigned", array('checked' => $search['assigned'], 'name' => 'assigned'))?>
									<span><?=__("Check if you only want to search through users with membership to %s", $wannabe->event->name)?></span>
								</label>
							</li>
						</ul>
					</div>
				</div>
				<div class="clearfix">
					<label for="crew_id"><?=__("Member of")?></label>
					<div class="input">
						<?=$this->Form->select("crew_id", $crews, array('value' => $search['crew_id'],  'name' => 'crew_id', 'empty' => __("Select crew")))?>
						<span class="help-block"><strong><?=__("Help")?>:</strong> <?=__("Narrow results to selected crew")?></span>
					</div>
				</div>
				<div class="clearfix">
					<label for="query"><?=__("Search for")?></label>
					<div class="input">
						<input type="text" id="field" name="query" value="<?=isset($search)?$search['query']:null?>" placeholder="<?=__("Name/Nick/Email")?>" />
					</div>
				</div>
				<div class="actions">
					<input type="submit" class="btn success" value="<?=__("Search")?>" />
				</div>
			</fieldset>
		</form>
	</div>
</div>
