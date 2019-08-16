<div class="row">
	<div class="span16">
		<form method="post">
			<fieldset>
				<legend><?=__("Settings")?></legend>
				<?=$this->Form->hidden('EnrollSetting.id', array('value' => $setting['EnrollSetting']['id']))?>
				<div class="clearfix">
					<label for="checkOptions"></label>
					<div class="input">
						<ul class="inputs-list">
							<li>
								<label>
									<?=$this->Form->checkbox('EnrollSetting.enrollaccept', array('div' => false, 'label' => false, 'checked' => $setting['EnrollSetting']['enrollaccept']?'checked':''))?>
									<span><?=__("Enable application processing")?></span>
								</label>
							</li>
							<li>
								<label>
									<?=$this->Form->checkbox('EnrollSetting.enrollactive', array('div' => false, 'label' => false, 'checked' => $setting['EnrollSetting']['enrollactive']?'checked':''))?>
									<span><?=__("Enable application viewing")?></span>
								</label>
							</li>
							<li>
								<label>
									<?=$this->Form->checkbox('EnrollSetting.greetingactive', array('div' => false, 'label' => false, 'checked' => $setting['EnrollSetting']['greetingactive']?'checked':''))?>
									<span><?=__("Enable greetings")?></span>
								</label>
							</li>
						</ul>
					</div>
				</div>
			</fieldset>
			<div class="actions">
				<?=$this->Form->submit(__("Update settings"), array('name' => 'save', 'div' => false, 'class' => 'btn success'))?>
			</div>
		</form>
	</div>
</div>
<div class="row">
	<div class="span16">
		<h3><?=__("Enrollment mails")?></h3>
		<table>
			<tr>
				<th><?=__("Type")?></th>
				<th><?=__("Subject")?></th>
				<th><?=__("View")?></th>
				<th><?=__("Edit")?></th>
				<th><?=__("Delete")?></th>
			</tr>
			<?php foreach($mails as $mail) { ?>
				<tr>
					<td><?=$types[$mail['EnrollMail']['type']]?></td>
					<td><?=$mail['EnrollMail']['subject']?></td>
					<td><a href="<?=$this->Wb->eventUrl('/EnrollAdmin/mail/'.$mail['EnrollMail']['id'])?>" class="btn"><?=__("View")?></a></td>
					<td><a href="<?=$this->Wb->eventUrl('/EnrollAdmin/edit/'.$mail['EnrollMail']['id'])?>" class="btn"><?=__("Edit")?></a></td>
					<td><a href="<?=$this->Wb->eventUrl('/EnrollAdmin/delete/'.$mail['EnrollMail']['id'])?>" class="btn danger"><?=__("Delete")?></a></td>
				</tr>
			<?php } ?>
		</table>
	</div>
</div>
<p><a href="<?=$this->Wb->eventUrl('/EnrollAdmin/create')?>" class="btn primary"><?=__("Create new mail")?></a></p>
