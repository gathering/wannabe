<form method="get">
<script type="text/javascript">
$(document).ready(function() {
    $(':checkbox').click(function() {
        var cb = $(this);
        $.post('/<?=WB::$event->reference?>/CrewEffectsOrder/economy/' + cb.attr('id') + '/' + (cb.is(':checked') ? '1' : '0'), function(data) {
            if(cb.is(':checked')) {
                cb.parent().parent().css('background-color', '#5BB75B');
                cb.parent().parent().css('color', 'white');
                var time = "#time_" + cb.attr('id');
                data = $.parseJSON(data)
                console.log(data);
                if(data.success) {
                    $(time).html(data.date);
                }
                cb.hide();
            } else {
                cb.parent().parent().css('background-color', 'white');
                cb.parent().parent().css('color', 'black');
            }
        });
    });
});
</script>
<div class="row">
    <div class="col-md-12">
        <table>
            <tr>
                <th><?=__('User id')?></th>
                <th><?=__('Nickname')?></th>
                <th><?=__('Real name')?></th>
                <th><?=__('Amount to pay')?></th>
                <th><?=__('Paid')?></th>
                <th><?=__('Paid time')?></th>
            </tr>
        <?php foreach($orders as $i => $order) { ?>
            <tr <?php if($order['CrewEffectsOrder']['paid']) echo 'style="background-color: #5BB75B; color: white;"'; ?>>
                <td><?=$order['User']['id']?></td>
                <td><?=$order['User']['nickname']?></td>
                <td><?=$order['User']['realname']?></td>
                <td><?=$order[0]['sum(CrewEffectsOrder.item_amount * CrewEffectsItem.price)']?></td>
                <td>
                <?php if(!$order['CrewEffectsOrder']['paid']) { ?>
                <?=$this->Form->checkbox('CrewEffectsOrder.'.$i.'.paid', array('label' => false, 'div' => 'false', 'checked' => $order['CrewEffectsOrder']['paid'], 'id' => $order['User']['id'], 'time' => $order['CrewEffectsOrder']['paid_time']))?>
                <?php } ?>
                </td>
                <td id="time_<?=$order['User']['id']?>">
                <?php if($order['CrewEffectsOrder']['paid']) { echo strftime(__("%b %e %G, %H:%M"), strtotime($order['CrewEffectsOrder']['paid_time'])); } ?>
                </td>
            </tr>
        <?php } ?>
        </table>
    </div>
</div>
<div class="actions">
    <a href="<?=$this->Wb->eventUrl('/CrewEffectsOrder/overview')?>"       class="btn"><?=__("Back")?></a>
</div>
</form>
