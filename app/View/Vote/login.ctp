<form method="POST">                                                                                                                                                                                                                                             
    <fieldset>
    <legend><?=__("This page is password protected")?></legend>
        <label for="data[denialmessage]"><?=__("Password")?></label>
        <div class="input">
            <input type="password" name="passphrase" />
        </div>
        <div class="actions">
            <?=$this->Form->submit(__('Login'), array('name'=>'login', 'class' => 'btn success', 'div' => false))?>
        </div>
    </fieldset>
</form>
