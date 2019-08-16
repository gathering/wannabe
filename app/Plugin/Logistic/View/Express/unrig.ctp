<ul class="breadcrumb"><li><a href="<?=$this->Wb->eventUrl('/Logistic')?>"><?=__('Logistics')?></a> <span class="divider"></span></li><li class="active"><?=$title_for_layout?></li></ul>
<div id="unrig">
    <form>
        <p id="step1">
            <select class="form-control">
                <option><?=__('Choose checkin storage in order to begin')?></option>
                <?php foreach ($storages as $storage_id => $storage_name): ?>
                    <option value="<?=$storage_id?>"><?=$storage_name?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p id="step2" style="display: none;">
            <input type="text" class="form-control" name="query" placeholder="<?=__("Scan AssetCode for item")?>" autocomplete="off" />
            <br/>
            <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></button>
        </p>
    </form>
    <table class="table table-striped table-borderd">
        <tr>
            <td class="column-icon"><i class="fa fa-spin fa-spinner"></i></td>
            <td class="column-text">
                <span class="before-AssetTag"></span><span class="AssetTag"></span><span class="after-AssetTag"></span>
            </td>
            <td class="column-time"></td>
        </tr>
    </table>
</div>


<style type="text/css">
    #unrig .row-error { color: #cc0000; }
    #unrig .row-ok.column-icon { color: #009900; }
</style>

<?php $this->Html->scriptStart( array('block' => 'bottom')); ?>
var unrig_step1 = $('#step1');
var unrig_step2 = $('#step2');

var unrig_form = $('#unrig form');
var unrig_select = $('#unrig form select');
var unrig_input = $('#unrig form input');
var unrig_table = $('#unrig table');
var unrig_row_template = $('#unrig table tr');

unrig_step1.find('select').change(function() {
    unrig_step1.hide();
    unrig_step2.show();
    unrig_input.focus();
});

unrig_form.submit(function() {
    var AssetTag = unrig_input.val();
    unrig_input.val('');
    var time = new Date().toTimeString().split(' ')[0];
    var row = unrig_row_template
        .clone()
        .removeClass('hide')
        .find('.column-time')
            .text(time)
        .end()
        .find('.before-AssetTag')
            .text('<?=__('Checking in ')?>')
        .end()
        .find('.AssetTag')
            .text(AssetTag)
        .end();
    unrig_table.prepend(row);

    var blink_color = function(color) {
        console.log('blink_color', color);
        row.find('td').css('background-color', color);
        row.find('td').css('color', 'white');
        window.setTimeout(function() {
            row.find('td').css('background-color', '');
            row.find('td').css('color', '');
        }, 3000);
    }

    var storage_id = unrig_select.find('option:selected').val();
    $.getJSON(
        '<?=$this->Wb->eventUrl('/logistic/Express/performUnrig/')?>' + AssetTag,
        { 'storage_id': storage_id },
        function(data){
            console.log(data);
            if (!('status' in data) || data['status'] !== 'ok') {
                blink_color('red');
                row
                    .find('td')
                        .addClass('danger')
                    .end()
                    .find('i')
                        .removeClass('fa-spin fa-spinner')
                        .addClass('fa-exclamation')
                    .end()
                    .find('.before-AssetTag')
                        .text('<?=__('Error for ')?> ')
                    .end()
                    .find('.after-AssetTag')
                        .text(': ' + data['error'])
                    .end();
                return;
            }
            blink_color('green');
            row
                .find('td')
                    .addClass('success')
                .end()
                .find('i')
                    .removeClass('fa-spin fa-spinner')
                    .addClass('success')
                .end()
                .find('.before-AssetTag')
                    .text('<?=__('Item')?> "' + data['item'] + '" <?=__('checked in')?> (')
                .end()
                .find('.after-AssetTag')
                    .text(')')
                .end();
        }
    );
    return false;
});
<?php $this->Html->scriptEnd(); ?>