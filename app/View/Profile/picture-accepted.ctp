<div class="row">
    <div class="col-md-9">
        <h3><?=__("Your current picture")?></h3>
        <ul class="media-grid">
            <li>
                <div>
                    <img class="thumbnail" src="/<?=$wannabe->user['User']['image']?>_320.png" alt="">
                    <div class="media-comment"><?=__("%s px", "320")?></div>
                </div>
            </li>
            <li>
                <div>
                    <img class="thumbnail" src="/<?=$wannabe->user['User']['image']?>_100.png" alt="">
                    <div class="media-comment"><?=__("%s px", "100")?></div>
                </div>
            </li>
            <li>
                <div>
                    <img class="thumbnail" src="/<?=$wannabe->user['User']['image']?>_50.png" alt="">
                    <div class="media-comment"><?=__("%s px", "50")?></div>
                </div>
            </li>
        </ul>
    </div>
    <div class="col-md-3">
        <h2><?=__("Picture approved")?></h2>
        <p><?=__("On %s, your profile picture was approved for ID-card printing. This means you cannot change your picture anymore. The ID-card is your personal identification and gives you access to the event. If you, for various reasons, feel that you need to change you picture, please notify us in #support on slack or by email at %s so that we may reset you picture. Picture requests close to the event start date will not be accomodated, as we produce the ID-cards prior to the event.", strftime(__("%b %e %G, %H:%M"), strtotime($wannabe->user['PictureApproval']['updated'])), '<a href="mailto:'.$wannabe->event->email.'">'.$wannabe->event->email.'</a>')?></p>
        <p><?=__("Edit other aspects of your profile below")?></p>
        <p><a href="<?=$this->Wb->eventUrl('/Profile/edit')?>" class="btn btn-default"><?=__("Edit profile")?></a></p>
        <p><a href="<?=$this->Wb->eventUrl('/Profile/password')?>" class="btn btn-default"><?=__("Update password")?></a></p>
        <p><a href="<?=$this->Wb->eventUrl('/Profile/email')?>" class="btn btn-default"><?=__("Change email")?></a></p>
    </div>
</div>
