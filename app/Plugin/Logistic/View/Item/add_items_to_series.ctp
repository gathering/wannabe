<form action="" method="post" role="form">
	<fieldset>
		<div class="clearfix">
		    <label><?=__("Items")?></label>
		    <div class="input">
                        <table id="item-table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><?=__('AssetTag')?></th>
                                    <th><?=__('Serial number (optional)')?></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="item-row-template" style="display: none;">
                                    <td>
                                        <input type="text" class="text-AssetTag" name="AssetTags[]" />
                                    </td>
                                    <td>
                                        <input type="text" class="text-serialnumber" name="serialnumbers[]" />
                                    </td>
                                    <td>
                                        <button class="btn btn-warning">
                                            <?=__('Delete row')?>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button id="button-add-item-row" class="btn btn-primary">
                            <?=__('Add new row')?>
                        </button>
		    </div>
		</div>
	</fieldset>
        <!-- The following is copied from create_new.ctp -->

        <fieldset id="regaction">
            <legend><?=__("Registration action")?></legend>
            <div class="clearfix">
                <label for="data[Item][regimode]"><?=__("Action")?></label>
                <div class="input">
                    <select name="data[Item][regimode]" onchange="registration(this[selectedIndex].value)">
                            <option value="register"><?=__('Just register')?></option>
                            <option value="stock"><?=__('Place in stock')?></option>
                            <option value="handout"><?=__('Hand out')?></option>
                    </select>
                </div>
            </div>
        </fieldset>

        <fieldset id="stock" style="display:none;">
            <legend><?=__("Storage unit")?></legend>
            <div class="clearfix">
                <label for="data[Item][storage_id]"><?=__("Storage unit")?></label>
                <div class="input">
                    <?=$this->Form->select('Item.storage_id', $storages, array('div' => false, 'error' => false, 'label' => false, 'empty' => __("Choose")))?>
                </div>
            </div>
        </fieldset>
        <fieldset id="handout" style="display:none;">
            <legend><?=__("Hand out to user")?></legend>
            <div class="clearfix">
                <label for="data[Item][user_id]"><?=__("User ID")?></label>
                <div class="input">
                    <?=$this->Form->input('Item.user_id', array('div' => false, 'error' => false, 'label' => false, 'id' => 'realname', 'type' => 'text'))?><div id="results"></div>
                </div>
            </div>
        </fieldset>
        <script type="text/javascript">
                var element = document.getElementById("realname");
                element.onkeypress = function(e){
                    if(e.keyCode == 13){
                        var value = element.value;
                        if(value.match("E") != "E"){
                            value = value.replace('%','');
                            value = value.replace('_','');
                            foundzero = true;
                            id = "";
                            for(var i = 0; i < value.length;i++){
                                if(value.charAt(i) == '0' && foundzero == true){

                                }else{
                                    foundzero = false;
                                    id += value.charAt(i);
                                }
                            }
                            element.value = id;
                            return false;
                        }
                        else{
                            element.value = "ERROR";
                            return false;
                        }
                        return false;
                    }
                }
        </script>
        <input type="hidden" name="data[Item][regvalue]" id="registrationbox" style="width: 200px;" disabled="disabled" />
        <!-- End of code copied from create_new.ctp -->

	<div class="actions">
        <?=$this->Form->submit('Add items', array('class' => 'btn success', 'div' => false))?> <a href="<?=$this->Wb->eventUrl('/Logistic/Bulk/view/'.$id)?>" class="btn btn-primary"><?=__("Back to series")?></a>
    </div>
</form>

<?php $this->Html->scriptStart( array('block' => 'bottom')); ?>
    $(function() {
        var item_row_template = $('#item-row-template');
        var add_new_row = function() {
            return item_row_template
                .clone()
                .show()
                .appendTo('#item-table')
                .find('.button-delete-row')
                .click(function(e) {
                    e.preventDefault();
                    $(this).parent().parent().remove();
                })
                .end()
                .find('.text-AssetTag')
                .keypress(function(e) {
                    if (e.keyCode == 13) {
                        e.preventDefault();
                        $(this).parent().parent().find('.text-serialnumber').focus();
                    }
                })
                .end()
                .find('.text-serialnumber')
                .keypress(function(e) {
                    if (e.keyCode == 13) {
                        e.preventDefault();
                        add_new_row().find('.text-AssetTag').focus();
                    }
                })
                .end();
        };
        $('#button-add-item-row').click(function() { add_new_row(); return false; });
        add_new_row();
    });

    function registration(modus) {
        var stock = document.getElementById('stock');
        var handout = document.getElementById('handout');
        var registrationbox = document.getElementById('registrationbox');
        registrationbox.value = modus;
        if (modus == 'stock') {
            stock.style.display = 'block';
            handout.style.display = 'none';
        }
        else if (modus == 'handout') {
            stock.style.display = 'none';
            handout.style.display = 'block';
        }
        else if (modus == 'register') {
            stock.style.display = 'none';
            handout.style.display = 'none';
        }
    }
    registration('register');

<?php $this->Html->scriptEnd(); ?>