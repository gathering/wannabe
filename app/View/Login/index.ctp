<div class="row">
  <div class="col-md-9">
    <h2><?=$wannabe->event->name?></h2>
  </div>
  <div class="col-md-3 pull-right">

  </div>

</div>
<div class="row">
  <div class="col-md-12">
    <form method="POST">
      <div class="row">
        <div class="col-xs-6">
    			<input class="form-control login-fields" name="login" type="textfield" id="UserUsername" autofocus placeholder="<?=__("Login or email")?>" />
        </div>
        <div class="col-xs-6">
          <input class="form-control login-fields" name="pass" type="password" id="UserPassword" placeholder="<?=__("Password")?>" />
        </div>
      </div>
      <div class="row" style="margin-top: 10px;">
        <div class="col-xs-6">
          <div class="submit"><?=$this->Form->button(__("Login"), array('class' => 'btn btn-success', 'id' => 'login_submit'))?></div>
          <div class="remember-me">
            <label class="remember-label" for="remember"><?=$this->Form->checkbox('remember', array('label' => false, 'class'=>'remember', 'div' => false))?> <?=__("Remember me for 4 weeks")?></label>
          </div>

        </div>
        <div class="col-xs-6">
					<div><a id="createuser" href="/<?=$wannabe->event->reference?>/User/Register"><?=__("Create user")?></a></div>
					<div id="login_button_spacer"></div>
					<div><a id="forgotpassword" href="/<?=$wannabe->event->reference?>/User/Forgot"><?=__("Forgot password")?></a></div>
          <p class="pull-right" style="margin-top: 20px;">
            <span class="login_link_bracket">[ </span>
              <a id="changeevent" href="/<?=$wannabe->event->reference?>/Event"><?=__("change")?></a>
            <span class="login_link_bracket"> ]</span>
            |
            <span class="login_link_bracket">[ </span>
            <?=$this->Wb->eventLink(strtolower($olang[1]),"/User/Language/{$olang[0]}")?>
            <span class="login_link_bracket"> ]</span>
          </p>
        </div>
		</div>
	</form>
</div>
</div>
