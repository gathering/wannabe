<?php if($image) { ?>
<div class="row">
	<div class="col-md-12">
		<ul class="nav nav-tabs">
			<li class="<? if($tab == 'current') { echo 'active'; } else { echo ''; } ?>"><a data-toggle="tab" href="#current"><?=__("Current")?></a></li>
			<li class="<? if($tab == 'crop') { echo 'active'; } else { echo ''; } ?>"><a data-toggle="tab" href="#crop"><?=__("Crop")?></a></li>
			<li class="<? if($tab == 'upload') { echo 'active'; } else { echo ''; } ?>"><a data-toggle="tab" href="#upload"><?=__("Upload")?></a></li>
		</ul>
		<div id="crew-tab-content" class="tab-content">
			<div class="tab-pane fade <? if($tab == 'current') { echo 'in active'; } else { echo ''; } ?>" id="current">
				<div class="row">
					<div class="col-md-3">
						<h2><?=__("Changing your picture")?></h2>
						<p><?=__("On this page you change your picture.")?></p>
						<p><?=__("You can choose to upload a new picture or crop your existing photo. For further profile actions se buttons below.")?></p>
						<p><a href="<?=$this->Wb->eventUrl('/Profile/edit')?>" class="btn btn-default"><?=__("Edit profile")?></a></p>
						<p><a href="<?=$this->Wb->eventUrl('/Profile/password')?>" class="btn btn-default"><?=__("Update password")?></a></p>
						<p><a href="<?=$this->Wb->eventUrl('/Profile/email')?>" class="btn btn-default"><?=__("Change email")?></a></p>
					</div>
					<div class="col-md-9">
						<h3><?=__("Your current picture")?></h3>
						<ul class="media-grid">
							<li>
								<div>
									<img class="thumbnail" src="/<?=$image?>_320.png" alt="">
									<div class="media-comment"><?=__("%s px", "320")?></div>
								</div>
							</li>
							<li>
								<div>
									<img class="thumbnail" src="/<?=$image?>_100.png" alt="">
									<div class="media-comment"><?=__("%s px", "100")?></div>
								</div>
							</li>
							<li>
								<div>
									<img class="thumbnail" src="/<?=$image?>_50.png" alt="">
									<div class="media-comment"><?=__("%s px", "50")?></div>
								</div>
							</li>
						</ul>
					</div>

				</div>
			</div>
			<div class="tab-pane fade <? if($tab == 'crop') { echo 'in active'; } else { echo ''; } ?>" id="crop">
				<div class="row">
					<div class="col-md-12">
						<h3><?=__("Crop your original image")?></h3>
						<p><?=__("Drag the mouse pointer until you have a picture that shows only your face, the image will then be updated to only show the selected area.")?></p>
						<ul class="media-grid">
							<li id="picture">
								<div>
									<div id="profile-crop-container">
										<img id="profile-crop-image" src="/<?=$image?>_original.png" id="photo" />
									</div>
									<div class="media-comment"><?=__("Original image")?></div>
								</div>
							</li>
							<li id="preview">
								<div id="picture-preview"></div>
							</li>
						</ul>
							<form action="Picture?act=resize" method="post" class="form-stacked">
								<div class="actions" id="saveCroppedDiv">
									<input type="hidden" name="x" value="" />
									<input type="hidden" name="y" value="" />
									<input type="hidden" name="height" value="" />
									<input type="hidden" name="width" value="" />
									<input type="submit" class="btn success" value="<?=__("Save cropped image")?>" id="saveCroppedBtn" />
								</div>
							</form>
						</div>
					</div>
			</div>
			<div class="tab-pane fade <? if($tab == 'upload') { echo 'in active'; } else { echo ''; } ?>" id="upload">
<? } ?>
				<form action="Picture?act=upload" method="post" enctype="multipart/form-data">
					<div class="row">
						<div class="col-md-4">
							<fieldset>
								<legend><?=__("Upload new image")?></legend>
								<div class="clearfix">
									<label for="photoimg"><?=__("Choose picture")?></label>
									<div class="input">
										<input type="file" class="form-control" name="photoimg" id="photoimg" />
									</div>
								</div>
							</fieldset>
						</div>
						<div class="col-md-8">
							<h2><?=__("Image rules")?></h2>
                            <p><?=__("The profile picture is used on your personal ID-card. The card is used as identification and gives you access to the event. Your picture must therefore identify you in the best possible way, and comply with the following rules for quality and design:")?></p>
                            <?php if(!empty($rules)) { ?>
                                <ul>
                                    <?php foreach($rules as $id => $rule) { ?>
                                        <li <?=(isset($denied_id)&&$denied_id==$id)?"style='color: #DA4F49;'":''?>><?=$rule?></li>
                                    <?php } ?>
                                </ul>
                            <?php } else { ?>
                                <ul>
                                    <li><?=__("No rules")?></li>
                                </ul>
                            <?php } ?>
                            <p><?=__("If your picture does not comply with these rules, you will be asked to upload a new picture. It’s possible to change your picture as long as it has not been approved in the picture approval process. An email will be sent out in advance informing you that the process is starting.")?></p>
						</div>
					</div>
					<div class="actions">
						<input type="submit" name="submit" class="btn btn-success btn-lg" value="<?=__("Upload")?>" />
					</div>
				</form>
<? if($image) { ?>
			</div>
		</div>
	</div>
</div>
<?=$this->Html->css('cropper.min.css')?>
<?=$this->Html->script('jquery/cropper.min.js', array('block' => 'bottom'))?>
<?=$this->Html->script('wannabe/imagecrop.js', array('block' => 'bottom'))?>
<script type="text/javascript">
  var factor = <?=$factor?>;
  var size1 = <?=$size[0]?>;
  var size2 = <?=$size[1]?>;
  var image = '<?=$image?>';
  var previewtext = '<?=__('Preview')?>';
</script>
<? } ?>
