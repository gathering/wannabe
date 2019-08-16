<div class="page-header">
	<h1><?=__("Edit “%s”", $page['Wikipage']['title'])?> <small><?= !$page['Wikipage']['revision'] ? __("New") : __("Revision %s", $page['Wikipage']['revision']) ?></small></h1>
</div>
<div class="row">
	<div class="col-md-10">
		<form method="POST" action="<?=$this->Wb->eventUrl('/Wiki/'.$page['Wikipage']['title'].'/save')?>">
		<fieldset>
			<div class="clearfix">
				<label for="data[Wikipage][content]"><?=__("Content")?></label>
				<div class="input">
					<textarea class="form-control xxlarge" id="data[Wikipage][content]" name="data[Wikipage][content]" rows="25"><?=$page['Wikipage']['content']?></textarea>
					<span class="help-block">
						<?=__("Remember to use correct syntax. Check link to the right for more informastion.")?>
					</span>
				</div>
			</div>
			<div class="clearfix">
				<label for="data[Wikipage][comment]"><?=__("Comment")?></label>
				<div class="input">
					<input class="form-control" id="data[Wikipage][comment]" name="data[Wikipage][comment]" size="30" type="text" value="<?=$page['Wikipage']['comment']?>" placeholder="Comment">
				</div>
			</div>
		</fieldset>
		<div class="actions">
			<input type="submit" class="btn btn-default" value="<?=__("Save changes")?>">&nbsp;<a href="<?=$this->Wb->eventUrl("/Wiki/{$page['Wikipage']['title']}")?>" class="btn"><?=__("Cancel")?></a>
		</div>
		</form>
	</div>
	<div class="col-md-2">
		<h4><?=__("Need syntax help?")?></h4>
		<p><?=__("Check out how the wiki is formated ")?><a href="http://daringfireball.net/projects/markdown/syntax" target="_new"><?=__("here")?></a>.</p>
	</div>
</div>
