<div class="col-md-12">
    <ul class="nav nav-tabs">
        <li role="presentation"><a href="/<?=$wannabe->event->reference?>/Access/">Access control list</a></li>
        <li role="presentation"><a  href="/<?=$wannabe->event->reference?>/Access/Object">Manage ACL objects</a></li>
        <li role="presentation" class="active"><a href="#">Manage ACL roles</a></li>
    </ul>
    <div class="tab-content clearfix">
        <?php
            $roles[-1] = __("Non-member");
        ?>
        <div class="col-md-5">
            <form id="AclobjectsRole" method="post">
                <fieldset>
                    <h4><?=__('Add ACL role')?></h4>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="form-group">
                            <label for="birthday" class="col-xs-4 control-label"><h5><?=__('Role')?></h5></label>
                            <div class="col-xs-4">
                                <div class="form-inline">
                                    <div class="form-group">
                                        <select name="data[AclobjectsRole][role]" class="form-control" id="sel1">
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
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label for="birthday" class="col-xs-4 control-label"><h5><?=__('Access control list object')?></h5></label>
                            <div class="col-xs-4">
                                <div class="form-inline">
                                    <div class="form-group">
                                        <select name="data[AclobjectsRole][aclobject_id]" class="form-control" id="sel1">
                                            <option>--</option>
                                              <?php
                                                foreach ($acl_list as $l) {
                                                    echo '<option value="'.$l['Aclobject']['id'].'">'.$l['Aclobject']['path'].'</option>'."\n";
                                                }
                                              ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-xs-4 col-xs-offset-4">
                                <div class="checkbox">
                                    <label><input type="checkbox"  name="data[AclobjectsRole][read]" value="1"><span><?=__('Read')?></span></label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox"  name="data[AclobjectsRole][write]" value="1"><span><?=__('Write')?></span></label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox"  name="data[AclobjectsRole][manage]" value="1"><span><?=__('Manage')?></span></label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox"  name="data[AclobjectsRole][superuser]" value="1"><span><?=__('Superuser')?></span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="actions col-xs-6 col-xs-offset-3">
                        <?=$this->Form->submit($savebutton, array('class' => 'btn btn-block btn-success', 'name' => 'save'))?>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="col-md-6">
            <table class="table">
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
</div>
