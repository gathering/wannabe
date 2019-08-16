<ul class="tabs">
<li><a href="/<?=$wannabe->event->reference?>/Access/">Access control list</a></li>
  <li class="active"><a href="#">Manage ACL objects</a></li>
  <li><a href="/<?=$wannabe->event->reference?>/Access/Role">Manage ACL roles</a></li>
</ul>

<div class="row">

  <div class="span7">

    <form id="Aclobject" method="post">
      <div class="clearfix">

        <div class="input">
            <h4><?=__('Add ACL object')?></h4>
            <div class="input-prepend">
                <span class="add-on"><?=__("Path")?></span>
                <input class="span3" name="data[Aclobject][path]" type="text" id="newmemberId" required>
            </div>
        </div>

        <div class="actions">
            <?=$this->Form->submit($savebutton, array('class' => 'btn success', 'name' => 'save'))?>
        </div>
      </div>
    </form>
  </div>

  <div class="span9">
    <table class="zebra-striped condensed-table">
      <thead>
        <th><?=__('ID')?></th>
        <th><?=__('Path')?></th>
        <th><?=__('Action')?></th>
      </thead>
      <tbody>
        <?php
          foreach ($acl_list as $o)
          {
            echo '<tr><td>'.$o['Aclobject']['id'].'</td><td id="acl_'.$o['Aclobject']['id'].'" data-id="'.$o['Aclobject']['id'].'">'.$o['Aclobject']['path'].'</td><td><a href="/'.$wannabe->event->reference.'/Access/Delete/Object/'.$o['Aclobject']['id'].'">'.__('delete').'</a></td></td>';
          }
        ?>
        
      </tbody>
    </table>
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
