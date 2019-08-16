<div class="row">
  <div class="input-group span16">
    <form method="post">
      <?=$this->Form->input('term', array('div' => false, 'label' => false, 'class' => 'form-control', 'placeholder' => 'Wannabe ID / NFC', 'autofocus' => 'autofocus', 'value' => ''))?>
      <span class="input-group-btn">
        <?=$this->Form->button(__('Completed'), array('div' => false, 'class' => 'btn btn-error', 'type' => 'submit', 'name' => 'searchcomplete'))?>
        <?=$this->Form->button(__('Search'), array('div' => false, 'class' => 'btn btn-secondary', 'type' => 'submit', 'name' => 'search'))?>
      </span>
    </form>
  </div>
</div>
<?php if(isset($data)) { ?>
<div class="row">
  <div class="span16">
    <table class="zebra-striped bordered-table">
      <thead>
        <tr>
          <th><?=__('User')?></th>
          <th><?=__('Cleanup')?></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr>
            <form method="post">
              <td><?=$data['User']['realname']?> (#<?=$data['User']['id']?>)</td>
              <td>
                <?php if(!$data['CleanupPosition']['completed']) { ?>
                  <div class="form-group">
                    <select class="form-control" name="cleanup_id">
                      <?php foreach($cleanups as $cleanup) {
                        $selected = $cleanup['Cleanup']['id'] == $data['Cleanup']['id'] ? ' selected' : '';
                        $name = $cleanup['Cleanup']['time'].((!empty($cleanup['Cleanup']['description']) ? ' ('.$cleanup['Cleanup']['description'].')' : ''));
                        ?>
                      <option value="<?=$cleanup['Cleanup']['id']?>"<?=$selected?>><?=$name?></option>
                      <?php } ?>
                    </select>
                  </div>
                <?php } else { echo $data['Cleanup']['time'].((!empty($data['Cleanup']['description']) ? ' ('.$data['Cleanup']['description'].')' : '')); } ?>
              </td>
              <td>
                <div class="buttongroup">
                  <?php if($data['CleanupPosition']['id'] == 0) { ?>
                    <?=$this->Form->submit(__('Assign'), array('class' => 'btn success', 'name' => 'assign'))?>
                  <?php } else if($data['CleanupPosition']['completed']) { ?>
                    <?=$this->Form->submit(__('Undo'), array('class' => 'btn success', 'name' => 'undo'))?>
                  <?php } else { ?>
                    <?=$this->Form->submit(__('Completed'), array('class' => 'btn error', 'name' => 'completed'))?>
                  <?php } ?>
                </div>
              </td>
            </form>
          </tr>
      </tbody>
    </table>
  </div>
</div>
<?php } ?>
<hr />
<div class="row">
  <div class="span16">
    <a href="<?=$this->Wb->eventUrl('/Cleanup/Admin')?>" class="btn default"><?=__('Back')?></a>
  </div>
</div>
