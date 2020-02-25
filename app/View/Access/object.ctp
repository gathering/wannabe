<div class="col-md-12">
    <ul class="nav nav-tabs">
        <li role="presentation"><a href="/<?=$wannabe->event->reference?>/Access/">Access control list</a></li>
        <li role="presentation" class="active"><a  href="#">Manage ACL objects</a></li>
        <li role="presentation"><a href="/<?=$wannabe->event->reference?>/Access/Role">Manage ACL roles</a></li>
    </ul>
    <div class="tab-content clearfix">
        <div class="col-md-5">
            <h4><?=__('Add ACL object')?></h4>
            <form id="Aclobject" method="post">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><?=__("Path")?></span>
                    <input type="text" class="form-control" name="data[Aclobject][path]" id="newmemberId" required>
                </div>
                <div class="actions">
                    <?=$this->Form->submit($savebutton, array('class' => 'btn btn-success', 'name' => 'save'))?>
                </div>
            </form>
        </div>
        <div class="col-md-5">
            <table class="table">
                <thead>
                    <th><?=__('ID')?></th>
                    <th><?=__('Path')?></th>
                    <th><?=__('Action')?></th>
                </thead>
                <tbody>
                    <?php
                        foreach ($acl_list as $o)
                        {
                            echo '
                                <tr>
                                    <td>'.$o['Aclobject']['id'].'</td>
                                    <td id="acl_'.$o['Aclobject']['id'].'" data-id="'.$o['Aclobject']['id'].'">'.$o['Aclobject']['path'].'</td>
                                    <td><a href="/'.$wannabe->event->reference.'/Access/Delete/Object/'.$o['Aclobject']['id'].'">'.__('delete').'</a></td>
                                </tr>';

                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
var lastUsedParent    = '';
var id                = '';
var content           = '';
var dataId            = '';

$('td').click(function() {

  if (!$(this).hasClass('used'))
  {

    if (id)
    {
      $(id).html(content);
      $(lastUsedParent).removeClass('used');
    }
    dataId = $(this).attr('data-id');
    lastUsedParent = this;
    id = '#'+$(this).attr('id');
    content = $(id).html();

    $(this).addClass('used');
    $(id).html('<form method="post" action="/<?=WB::$event->reference?>/Access/ModifyObject"><input autofocus type="hidden" name="data[Aclobject][id]" value="'+dataId+'"><input type="text" name="data[Aclobject][path]" value="'+content+'"></form>');
    $(id+ ' input').focus();
  }

});
</script>
