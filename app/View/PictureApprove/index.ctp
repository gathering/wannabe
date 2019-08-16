<?=$this->Html->script('wannabe/picture_approval')?>
<div class="row">
    <div class="span16">
            <form method="POST">
                    <?
                    if($count <= 0){
                    echo __("No pictures need approval, good work!", $count);

                    echo "<br> <br>".$this->Wb->eventLink(__("Show users without picture"),'/PictureApprove/noPicture/');
                    } else {
                        ?> <ul class="media-grid"> <?php
                    foreach ( $members as $member ) { ?>

                        <li>
                            <div>
                                <? if ( $member['wb4_users']['image'] ) { ?>
                                    <img id="PictureApproval<?=$member['wb4_users']['id']?>Process" name="data[PictureApproval][<?=$member['wb4_users']['id']?>]" class="thumbnail PictureApproval<?=$member['wb4_users']['id']?>Process" src="/<?=$member['wb4_users']['image']?>_200.png" alt="" border="0" width="200" height="267"/>
                                    <div id="PictureApproval<?=$member['wb4_users']['id']?>Process1F" class="thumbnail-overlay white-bg media200 PictureApproval<?=$member['wb4_users']['id']?>Process" style="display:none;">
                                        <div>
                                            <span><?=__("Breaks rule")?></span>
                                            <?=$this->Form->select("PictureApproval.{$member['wb4_users']['id']}.rule_broken", $rules, array('empty' => __("None"), 'div' => false, 'error' => false, 'class' => 'span3'))?>
                                            <span><?=__("Message for user")?></span>
                                            <?=$this->Form->textarea("PictureApproval.{$member['wb4_users']['id']}.user_message", array('div' => false, 'error' => false, 'label' => false, 'placeholder' => __("Message for user"), 'class' => 'span3', 'rows' => '3'))?>
                                        </div>
                                    </div>
                                    <div id="PictureApproval<?=$member['wb4_users']['id']?>Process1D" class="thumbnail-overlay media200 PictureApproval<?=$member['wb4_users']['id']?>Process" style="display:none;">
                                        <img src="/img/denied.png" alt="" border="0" />
                                    </div>
                                    <div id="PictureApproval<?=$member['wb4_users']['id']?>Process2D" class="thumbnail-overlay media200 PictureApproval<?=$member['wb4_users']['id']?>Process" style="display:none;">
                                        <img src="/img/approved.png" alt="" border="0" />
                                    </div>
                                <? } ?>
                                <div class="media-comment">
                                   <?=$this->Wb->userLink($member['wb4_users']['id'])?> <br/> <br/>
                                    <?=$this->Wb->eventLink($member['wb4_crews']['name'],'/Crew/View/'.$member['wb4_crews']['name'])?>
                                    <?php
                                        list($width, $height) = getimagesize(APP . DS . WEBROOT_DIR . DS ."{$member['wb4_users']['image']}_200.png");
                                        $ratio = round($width/$height, 2).":1";
                                    ?>
                                    <div>
                                        <?=__("Ratio: %s width: %s height: %s", $ratio, $width, $height)?>
                                    </div>
                                    <div>
                                        <?=_("Picture")?>: <a href="/<?=$member['wb4_users']['image']?>_200.png" target="_blank"><?=__("Cropped")?></a>&nbsp;-&nbsp;<a href="/<?=$member['wb4_users']['image']?>_original.png" target="_blank"><?=__("Original")?></a>
                                    </div>
                                    <div>
                                        <?=$this->Form->radio("PictureApproval.{$member['wb4_users']['id']}.process", array('2' => __("Approve"), '1' => __("Deny"), '0' => __("Skip")), array('value'=>'0','legend' => false, 'class' => 'PictureApproval'.$member['wb4_users']['id'].'ProcessR'))?>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <? } ?>
                </ul>
                <div class="actions">
                    <?=$this->Form->submit(__("Process"), array('div' => false, 'label' => false, 'class' => 'btn success'))?> <a class="btn small pull-right" <?=$this->Wb->eventLink(__("Show users without picture"),'/PictureApprove/noPicture/')?>
                </div>
                <?php } ?>
            </form>
</div>
