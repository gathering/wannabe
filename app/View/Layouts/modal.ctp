<div class="modal-header">
	<a href="#" class="close">×</a>
	<h3><?php echo $title_for_layout?></h3>
</div>
<?php
if(isset($form)):
	echo "<form style='margin-bottom: 0' method='POST' action='".$form['action']."'>";
endif;
?>
<div class="modal-body">
	<div class="messages">
		<?=$this->Session->flash('modal')?>
	</div>
	<?php echo $content_for_layout ?>
</div>
<?php if(isset($form)): ?>
<div class="modal-footer">
<?php foreach($form['button'] as $button): ?>
	<button type="<?=$button['type']?>" class="btn <?=$button['class']?>" id="<?=$button['id']?>"><?=$button['text']?></button>
<?php endforeach; ?>
</div>
</form>
<?php endif; ?>
