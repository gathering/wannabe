<form method="get">
<div class="row">
    <div class="col-md-12">
        <button style="float:right" class="btn btn-info" id="hideGiven">Skjul/vis utdelte</button>
        <br/>
        <br/>
        <table class="table table-bordered table-striped">
            <tr>
                <th><?=__('User id')?></th>
                <th><?=__('Nickname')?></th>
                <th><?=__('Real name')?></th>
                <?php foreach($itemTitles as $key => $title) { ?>
                    <th><?=$title['Items']['title']?></th>
                <?php } ?>
                <th><?=__('Given')?></th>
            </tr>
        <?php foreach ($data as $key => $order) { ?>
            <tr <?php if($order['given']) echo 'class="success"'; ?>>
                <td><?=$key?></td>
                <td><?=$order['nick']?></td>
                <td><?=$order['realname']?></td>
                <?php foreach($itemTitles as $titlekey => $title) { ?>
                    <td><?=$order[$title['Items']['title']]?></td>
                <?php } ?>
<td><?=$this->Form->checkbox('CrewEffectsOrder.'.$key.'.givenfree', array('label' => false, 'div' => 'false', 'checked' => $order['given'], 'id' => $key))?></td>
            </tr>
        <?php } ?>
        </table>
    </div>
</div>
<div class="actions">
    <a href="<?=$this->Wb->eventUrl('/CrewEffectsOrder/overview')?>" class="btn btn-default"><?=__("Back")?></a>
</div>
</form>


<?php
$this->start('bottom');
?>

<script type="text/javascript">
    $(document).ready(function() {
        $(':checkbox').click(function() {
            var cb = $(this);
            $.post('/<?=WB::$event->reference?>/CrewEffectsOrder/logistics/<?=$action?>/' + cb.attr('id') + '/' + (cb.is(':checked') ? '1' : '0'), function(data) {
                if(cb.is(':checked')) {
                    cb.parent().parent().addClass('success');
                } else {
                    cb.parent().parent().removeClass('success');
                }
            });
        });
        $('#hideGiven').click(function(e){
            e.preventDefault();
            $('.success').toggle();
        });
    });
</script>

<?php
$this->end();
