<div class="row">
<?php $news = $this->requestAction('frontNews/index/sort:created/direction:asc'); ?>
<?php foreach($news as $content): ?>
<?php if($content['FrontNews']['left_box'] == true): ?>
	<div class="col-md-6">
		<div class="front-news ">
		<h2><?=$content['FrontNews']['title']?></h2>
		<p><?=$content['FrontNews']['content']?></p>
	</div>
	</div>
<?php break; ?>
<?php endif; ?>
<?php endforeach; ?>
<?php foreach($news as $content): ?>
<?php if($content['FrontNews']['left_box'] == false): ?>
	<div class="col-md-6">
		<div class="front-news ">
			<h2><?=$content['FrontNews']['title']?></h2>
			<p><?=$content['FrontNews']['content']?></p>
		</div>
	</div>
<?php break; ?>
<?php endif; ?>
<?php endforeach; ?>
</div>
