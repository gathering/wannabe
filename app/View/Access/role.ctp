<ul class="tabs">
<li><a href="/<?=$wannabe->event->reference?>/Access/">Access control list</a></li>
<li><a href="/<?=$wannabe->event->reference?>/Access/Object">Manage ACL objects</a></li>
  <li class="active"><a href="#">Manage ACL roles</a></li>
</ul>
<div class="row">
<?php
    $roles[-1] = __("Non-member");
?>
  <div class="span5">
    <form id="AclobjectsRole" method="post">
    <fieldset>
        <h4><?=__('Add ACL role')?></h4>
      <div class="clearfix">
        <label><?=__('Role')?></label>
          <div class="input">

              <select name="data[AclobjectsRole][role]" class="span2">
                <option value="null">--</option>
                <?php
                for ($i = -1; $i < count($roles)-1; $i++)
                {
                  echo '<option value="'.$i.'">'.$roles[$i].'</option>';
                }
                ?>
              </select>
          </div>
        </div>
        <div class="clearfix">
          <label for="normalSelect"><?=__('Access control list object')?></label>
          <div class="input">

              <select name="data[AclobjectsRole][aclobject_id]" class="span2">
                <option>--</option>
                  <?php
                    foreach ($acl_list as $l) {
                        echo '<option value="'.$l['Aclobject']['id'].'">'.$l['Aclobject']['path'].'</option>'."\n";
                    }
                  ?>
              </select>

          </div>
        </div>
        <div class="clearfix">
          <div class="input">
              <ul class="inputs-list">
                  <li>
                    <label>
                      <input type="checkbox" name="data[AclobjectsRole][read]" value="1">
                      <span><?=__('Read')?></span>
                    </label>
                  </li>
                  <li>
                    <label>
                      <input type="checkbox" name="data[AclobjectsRole][write]" value="1">
                      <span><?=__('Write')?></span>
                    </label>
                  </li>
                  <li>
                    <label>
                      <input type="checkbox" name="data[AclobjectsRole][manage]" value="1">
                      <span><?=__('Manage')?></span>
                    </label>
                  </li>
                  <li>
                    <label class="disabled">
                      <input type="checkbox" name="data[AclobjectsRole][superuser]" value="1">
                      <span><?=__('Superuser')?></span>
                    </label>
                  </li>
                </ul>
          </div>
      </div>
    </fieldset>

      <div class="actions">
          <?=$this->Form->submit($savebutton, array('class' => 'btn success', 'name' => 'save'))?>
      </div>
    </form>
  </div>


  <div class="span11">
    <table class="zebra-striped condensed-table">
      <thead>
        <th><?=__('Role')?></th>
        <th><?=__('Access Control List Object')?></th>
        <th><?=__('Privileges')?></th>
        <th><?=__('Action')?></th>
      </thead>
      <tbody>
        <?php
        foreach ($role_list as $role)
        {
          $privileges = array();
          if ($role['Role']['read'] == 1)
            $privileges[count($privileges)] = __('Read');
          if ($role['Role']['write'] == 1)
            $privileges[count($privileges)] = __('Write');
          if ($role['Role']['manage'] == 1)
            $privileges[count($privileges)] = __('Manage');
          if ($role['Role']['superuser'] == 1)
            $privileges[count($privileges)] = __('Superuser');

          $privileges = implode(", ", $privileges);
          echo '<tr>
              <td>'.$roles[$role['Role']['role']].'</td>
              <td>'.$role['ACLObject']['path'].'</td>
              <td>'.$privileges.'</td>
              <td><a href="/'.$wannabe->event->reference.'/Access/Delete/Role/'.$role['Role']['role'].'/'.$role['Role']['aclobject_id'].'">'.__('delete').'</a></td>
            </tr>';
        }
        ?>
      </tbody>
    </table>
  </div>

</div>
