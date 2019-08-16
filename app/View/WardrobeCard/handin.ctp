<div class="row">
    <div class="span8">
        <h3><?=__("Item description") . ": " . $card_id . ", " . __("Serialnumber") . ": " . $wardrobe ?></h3>

        <hr />
        <table class="zebra-striped bordered-table">
            <tr>
                <td>Name</td>
                <td class="tryLoadLink"><?=$borrower['WardrobeCardBorrower']['name']?></td>
            </tr>
            <? if($borrower['WardrobeCardBorrower']['phone'] != "#placeholder#") { ?>
                <tr>
                    <td>Phone</td>
                    <td><?=$borrower['WardrobeCardBorrower']['phone']?></td>
                </tr>
                <tr>
                    <td>Row</td>
                    <td><?=$borrower['WardrobeCardBorrower']['row']?></td>
                </tr>
                <tr>
                    <td>Seat</td>
                    <td><?=$borrower['WardrobeCardBorrower']['seat']?></td>
                </tr>
            <? } ?>
            <tr>
                <td>Deposit</td>
                <td><?=$borrower['WardrobeCardBorrower']['deposit']?></td>
            </tr>
            <tr>
                <td>Comment</td>
                <td><?=$borrower['WardrobeCardBorrower']['deposit_comment']?></td>
            </tr>
            
        </table>
    </div>
</div>

<form method="post">
    <div class="actions">
        <?=$this->Form->submit(__("Hand in"), array('div' => false, 'label' => false, 'class' => 'btn success'))?>
        <a href="<?=$this->Wb->eventUrl("/WardrobeCard")?>" class="btn">Back</a>
    </div>
</form>

<script>
    $(document).ready(function() {

        var loadLinks = $(".tryLoadLink");

        $.each(loadLinks, function(index, element) {
            var that = $(this);
            var matches = /(https?:[^\s]+)/.exec(that.html());

            if(!matches) return;
            var url = matches[1];
            that.html('<a href="' + url + '" target="_blank">Link to user</a>');
        });
    });
</script>