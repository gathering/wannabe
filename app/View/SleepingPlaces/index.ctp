<script type="text/javascript">

    var section = {
        ManyAvailable: 0,
        FewAvailable: 1,
        NonAvailable: 2,
        Disabled: 3
    }

    function getSelectedDropdownItemByText() {
        var e = document.getElementById("chooseSection");
        return e.options[e.selectedIndex].innerHTML;
    }

    function postStatus(section, value) {
        $.post('/<?=WB::$event->reference?>/SleepingPlaces/updateStatus/' + section + '/' + value, function(event) {
            refreshBaseMap();
        });
    }

    function refreshBaseMap() {
       var e = document.getElementById("basemap");
       e.src = e.src;
    }

    $(document).ready(function() {
        $('#updateMany').click(function(e) {
            e.preventDefault()
            postStatus(getSelectedDropdownItemByText(), section.ManyAvailable);
        })
        $('#updateFew').click(function(e) {
            e.preventDefault()
            postStatus(getSelectedDropdownItemByText(), section.FewAvailable);
        })
        $('#updateNone').click(function(e) {
            e.preventDefault()
            postStatus(getSelectedDropdownItemByText(), section.NonAvailable);
        })
        $('#disable').click(function(e) {
            e.preventDefault()
            postStatus(getSelectedDropdownItemByText(), section.Disabled);
        })
    })
</script>

<form>
    <h3 style="margin-bottom: 30px;">Choose a section to update</h3>
    
    <select name="chooseSection" id="chooseSection">
        <? foreach($sleepingplaces as $sleepingPlace) { ?>
            <option value="<?= $sleepingPlace["SleepingPlaces"]["section"] ?>"><?= $sleepingPlace["SleepingPlaces"]["section"]; ?></option>
        <? } ?>
    </select>
    
    <button class="btn success" id="updateMany"><?=__("Many spots available")?></button>
    <button class="btn" style="background: #faa732; color: white; border-color: #f89406 #f89406 #ad6704; text-shadow    : none;" id="updateFew"><?=__("Few spots available")?></button>
    <button class="btn danger" id="updateNone"><?=__("No spots avaiable")?></button>
    <button class="btn" id="disable"><?=__("Disable section")?></button>
</form>

<iframe src="https://infosystems.gathering.org/sleepingplaces/new/index.html?sleepingPlacesSize=fullscreen" frameborder="0" style="margin-top: 20px;" width="725px" height="380px" id="basemap"></iframe>
