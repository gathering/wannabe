<ul class="tabs">
  <li class="active"><a href="#">Access control list</a></li>
  <li><a href="/<?=$wannabe->event->reference?>/Access/Object">Manage ACL objects</a></li>
  <li><a href="/<?=$wannabe->event->reference?>/Access/Role">Manage ACL roles</a></li>
</ul>
<div class="row">
  <div class="span5">
    <h6><?=('Access control list objects')?></h6>
    <ul>
        <?php
        foreach ($acl_list as $l) {
        	echo '<li><a href="/'.$wannabe->event->reference.'/Access/View/'.$l['Aclobject']['id'].'">' . $l['Aclobject']['path'] . '</a></li>'."\n";
        }
        ?>
    </ul>
  </div>

<div class="span10">
<h1><?=__('Access control')?></h1>

<?php
if (isset($acl_object)) {
	echo '<p><strong>Path:</strong> '.$acl_object['Aclobject']['path'].'</p>';
?>

<h4>Crews with access</h4>
<?php
if (!count($access_crews) > 0)
	echo '-- empty --';
else
{
  
  echo '<table class="condensed-table">
  <thead>
    <tr>
      <th width="50">#</th>
      <th>Crew</th>
      <th width="150">Privileges</th>
      <th width="50">Action</th>
    </tr>
  </thead>
  <tbody>';
  foreach ($access_crews as $crew) {
    $privileges = array();
    if ($crew['AclobjectsCrew']['read'] == 1)
      $privileges[count($privileges)] = 'read';
    if ($crew['AclobjectsCrew']['write'] == 1)
      $privileges[count($privileges)] = 'write';
    if ($crew['AclobjectsCrew']['manage'] == 1)
      $privileges[count($privileges)] = 'manage';
    if ($crew['AclobjectsCrew']['superuser'] == 1)
      $privileges[count($privileges)] = 'superuser';

    $privileges = implode(", ", $privileges);
    echo '
    <tr>
      <td>'.$crew['Crew']['id'].'</td>
      <td><strong>'.$crew['Crew']['name'].'</strong></td>
      <td>'.$privileges.'</td>
      <td><a href="/'.$wannabe->event->reference.'/Access/Delete/Crew/'.$crew['Crew']['id'].'/'.$acl_object['Aclobject']['id'].'">[ Slett ]</a></td>
    </tr>';
  }
  echo '</tbody></table>';
}
?>


<h4>Users with access</h4>

<?php
if (!count($access_users) > 0)
	echo '-- empty --';
else
{
  echo '<table class="condensed-table">
  <thead>
    <tr>
      <th width="50">#</th>
      <th>Crew</th>
      <th width="150">Privileges</th>
      <th width="50">Action</th>
    </tr>
  </thead>
  <tbody>';
  foreach ($access_users as $user) {
    $privileges = array();
    if ($user['AclobjectsUser']['read'] == 1)
      $privileges[count($privileges)] = 'read';
    if ($user['AclobjectsUser']['write'] == 1)
      $privileges[count($privileges)] = 'write';
    if ($user['AclobjectsUser']['manage'] == 1)
      $privileges[count($privileges)] = 'manage';
    if ($user['AclobjectsUser']['superuser'] == 1)
      $privileges[count($privileges)] = 'superuser';

    $privileges = implode(", ", $privileges);
    echo '
    <tr>
      <td>'.$user['User']['id'].'</td>
      <td><strong>'.$user['User']['realname'].'</strong></td>
      <td>'.$privileges.'</td>
      <td><a href="/'.$wannabe->event->reference.'/Access/Delete/User/'.$user['User']['id'].'/'.$acl_object['Aclobject']['id'].'">[ Slett ]</a></td>
    </tr>';
  }
  echo '</tbody></table>';
}

?>



<hr></hr>

<h4>Add user</h4>
<form id="AclobjectsUser" method="post">
<div class="clearfix">
    <div class="input">
        <div class="input-prepend">
            <span class="add-on"><?=__("User ID")?></span>
            <input class="span3" name="data[AclobjectsUser][user_id]" type="text" id="newmemberId" pattern="[0-9]+" required>
        </div>
    </div>
    <div class="input">
        <ul class="inputs-list">
            <li>
              <label>
                <input type="checkbox" name="data[AclobjectsUser][read]" value="1">
                <span>Lesetilgang</span>
              </label>
            </li>
            <li>
              <label>
                <input type="checkbox" name="data[AclobjectsUser][write]" value="1">
                <span>Skrivetilgang</span>
              </label>
            </li>
            <li>
              <label>
                <input type="checkbox" name="data[AclobjectsUser][manage]" value="1">
                <span>Administrere rettigheter for dette objektet</span>
              </label>
            </li>
            <li>
              <label class="disabled">
                <input type="checkbox" name="data[AclobjectsUser][superuser]" value="1">
                <span>Superbruker</span>
              </label>
            </li>
          </ul>
    </div>


</div>

<div class="actions">
    <?=$this->Form->submit($savebutton, array('class' => 'btn success', 'name' => 'save'))?>
</div>
</form>

<h4>Add crew</h4>
<form id="AclobjectsCrew" method="post">
<div class="clearfix">
    <label for="normalSelect">Crew</label>
    <div class="input">
        <?=$this->Form->select('AclobjectsCrew.crew_id', $crews, array('empty' => __("Choose"), 'div' => false, 'error' => false, 'id' => 'normalSelect'))?>
    </div>
    <div class="input">
        <ul class="inputs-list">
            <li>
              <label>
                <input type="checkbox" name="data[AclobjectsCrew][read]" value="1">
                <span>Lesetilgang</span>
              </label>
            </li>
            <li>
              <label>
                <input type="checkbox" name="data[AclobjectsCrew][write]" value="1">
                <span>Skrivetilgang</span>
              </label>
            </li>
            <li>
              <label>
                <input type="checkbox" name="data[AclobjectsCrew][manage]" value="1">
                <span>Administrere rettigheter for dette objektet</span>
              </label>
            </li>
            <li>
              <label class="disabled">
                <input type="checkbox" name="data[AclobjectsCrew][superuser]" value="1">
                <span>Superbruker</span>
              </label>
            </li>
          </ul>
    </div>
</div>

<div class="actions">
    <?=$this->Form->submit($savebutton, array('class' => 'btn success', 'name' => 'save'))?>
</div>
</form>

<?php
}
else {
	echo 'lolnub';
}
?>

</div>
</div>
