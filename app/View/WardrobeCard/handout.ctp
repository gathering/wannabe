<?=$this->Html->css('lostandfound/lostandfound')?>

<form method="post">
    <fieldset>
       <?=$this->Form->hidden('WardrobeCardBorrower.wardrobe_card_id', array('value' => $card_id))?>
        <legend><?=__("Description of item") . ": " . $card_id . ", " . __("Serialnumber") . ": " . $wardrobe ?></legend>
        
        <div class="row">
            <div class="span12">
                <div id="checkboxplaceholder"></div>
                <div id="rfid" class="apiUserIdContainer">
                    <div class="clearfix <? if($this->Form->error('WardrobeCardBorrower.rfid')) echo "error"; ?>">
                        <label for="WardrobeCardBorrowerRFID"><?=__("Scan RFID card")?></label>
                        <div class="input">
                            <?=$this->Form->textarea('WardrobeCardBorrower.RFID', array('div' => false, 'error' => false, 'label' => false, 'class' => 'apiUserId tryLoadLink', 'autofocus' => 'autofocus'))?>
                            <span class="help-block"><?=$this->Form->error('WardrobeCardBorrower.rfid')?></span>
                        </div>
                    </div>
                </div>
                <div id="manual" style="display: none">
                    <div class="clearfix <? if($this->Form->error('WardrobeCardBorrower.name')) echo "error"; ?>">
                        <label for="data[WardrobeCardBorrower][name]"><?=__("Name")?> </label>
                        <div class="input">
                            <?=$this->Form->input('WardrobeCardBorrower.name', array('div' => false, 'error' => false, 'label' => false))?>
                            <span class="help-block"><?=$this->Form->error('WardrobeCardBorrower.name')?></span>
                        </div>
                    </div>
                    <div class="clearfix <? if($this->Form->error('WardrobeCardBorrower.phone')) echo "error"; ?>">
                        <label for="data[WardrobeCardBorrower][phone]"><?=__("Phone")?> </label>
                        <div class="input">
                            <?=$this->Form->input('WardrobeCardBorrower.phone', array('div' => false, 'error' => false, 'label' => false))?>
                            <span class="help-block"><?=$this->Form->error('WardrobeCardBorrower.phone')?></span>
                        </div>
                    </div>
                    <div class="clearfix <? if($this->Form->error('WardrobeCardBorrower.row')) echo "error"; ?>">
                        <label for="data[WardrobeCardBorrower][row]"><?=__("Row")?> </label>
                        <div class="input">
                            <?=$this->Form->input('WardrobeCardBorrower.row', array('div' => false, 'error' => false, 'label' => false))?>
                            <span class="help-block"><?=$this->Form->error('WardrobeCardBorrower.row')?></span>
                        </div>
                    </div>
                    <div class="clearfix <? if($this->Form->error('WardrobeCardBorrower.seat')) echo "error"; ?>">
                        <label for="data[WardrobeCardBorrower][seat]"><?=__("Seat")?> </label>
                        <div class="input">
                            <?=$this->Form->input('WardrobeCardBorrower.seat', array('div' => false, 'error' => false, 'label' => false))?>
                            <span class="help-block"><?=$this->Form->error('WardrobeCardBorrower.seat')?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <hr />
        
        <div class="row">
            <div class="span8">
                <div class="clearfix <? if($this->Form->error('WardrobeCardBorrower.deposit')) echo "error"; ?>">
                    <label for="data[WardrobeCardBorrower][deposit]"><?=__("Deposit")?> </label>

                    <div class="input">
                        <?=$this->Form->input('WardrobeCardBorrower.deposit', array('div' => false, 'error' => false, 'label' => false))?>
                        <span class="help-block"><?=$this->Form->error('WardrobeCardBorrower.deposit')?></span>
                    </div>
                </div>
                <div class="clearfix <? if($this->Form->error('WardrobeCardBorrower.deposit_comment')) echo "error"; ?>">
                    <label for="data[WardrobeCardBorrower][deposit_comment]"><?=__("Comment")?> </label>

                    <div class="input">
                        <?=$this->Form->textarea('WardrobeCardBorrower.deposit_comment', array('div' => false, 'error' => false, 'label' => false))?>
                        <span class="help-block"><?=$this->Form->error('WardrobeCardBorrower.deposit_comment')?></span>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <div class="actions">
        <?=$this->Form->submit(__("Save changes"), array('div' => false, 'label' => false, 'class' => 'btn success'))?>
        <a href="<?=$this->Wb->eventUrl("/WardrobeCard")?>" class="btn">Back</a>
    </div>
</form>

<script>
    var useRFID = <? echo $usesRFID ?>;

    $(document).ready(function() {
        var apiFields = $(".apiUserId");

        $.each(apiFields, function(index, field) {
            var checkboxWrapper =
                '<div id="iwanttouserfid" class="clearfix input" style="margin-top: 15px">' +
                    '<input id="apiBox' + index + '" type="checkbox" class="apiUserIdTrigger" ' + (useRFID ? "checked" : "") + ' data-api-id="' + index + '" name="data[UsesRFID]"> ' +
                    '<label for="apiBox' + index + '" style="float: none; width: inherit">I want to scan RFID from badge or bracelet.' + '</label>' +
                '</div>';
            var apiMessageSpan = '<span class="apiUserIdMessage' + index + ' help-block"></span>';
            var linkSpan = '<span class="apiUserIdLink' + index + '"></span>';

            $(field).closest(".apiUserIdContainer").prepend(checkboxWrapper);
            $(field).attr("data-api-id", index);
            $(linkSpan).insertAfter($(this));
            $(apiMessageSpan).insertAfter($(this));
        });

        $("input.apiUserIdTrigger").change(function() {
            var allCheckboxes = $("input.apiUserIdTrigger");
            var state = $(this).is(":checked");

            $.each(allCheckboxes, function(index, element) {
                $(element).prop("checked", state);
            });

            useRFID = state;
        });

        $(".apiUserId").keypress(function(e) {

            if(useRFID === false) { return true; }
            var that = $(this);

            if(e.keyCode == 13) {
                var value = that.val().replace(/\s/g, "");
                var eventReference = wannabeEventReference();

                $.get("/" + eventReference + "/GeekeventsApi/getUserInfo/" + value, function(data) {
                    data = JSON.parse(data);

                    var dataApiId = that.attr("data-api-id");
                    var apiUserIdMessage = $("span.apiUserIdMessage" + dataApiId);
                    var apiUserIdLink = $("span.apiUserIdLink" + dataApiId);

                    if(data.status == 0) {
                        apiUserIdMessage.removeClass("text-success");
                        apiUserIdMessage.addClass("text-danger");
                        apiUserIdMessage.text("User was not found!");
                        apiUserIdLink.val("");
                    }
                    else {
                        if(data.valid_ticket == 0) {
                            apiUserIdMessage.removeClass("text-success");
                            apiUserIdMessage.addClass("text-danger");
                            apiUserIdMessage.text("User was found, but does not have a valid ticket!");
                            that.val(data.user_url);
                            apiUserIdLink.html('<a href="' + data.user_url + '">Link to user</a>');
                        }
                        else if(data.valid_ticket == 1) {
                            apiUserIdMessage.removeClass("text-error");
                            apiUserIdMessage.addClass("text-success");
                            apiUserIdMessage.text("User was found and has a valid ticket!");
                            that.val(data.user_url);
                            apiUserIdLink.html('<a href="' + data.user_url + '">Link to user</a>');
                        }
                    }
                }).done(function() {
                }).fail(function() {
                }).always(function() {
                })
            }
        })

        var showManual = function() {
            $("#manual").show();
            $("#rfid").hide();
            $("#iwanttouserfid").appendTo($("#checkboxplaceholder"));
        }

        var showRFID = function() {
            $("#manual").hide();
            $("#rfid").show();
        }

        if(!useRFID)
            showManual();
        
 
        $(document).on("change", "input.apiUserIdTrigger", function() {
            var state = $(this).is(":checked");
            if(state) {
                showRFID();
            }
            else {
                showManual();
            }
        });

        $("form").submit(function() {
            if(useRFID) {
                $("#WardrobeCardBorrowerRFID").addClass("form-error");
            }
            else {
                $("#WardrobeCardBorrowerRFID").removeClass("form-error");
            }
        });
    }); 
</script>

<?=$this->Html->script('geekevents/tryloadlink.js')?>
