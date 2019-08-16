var TYPE = {
    none : '',
    found : 'found',
    lost : 'lost'
};

$(document).ready(function() {

    selectType();

    $("#selectType").change(function() {
        selectType();
    });

    setDifferentUser();

    $("#lostDifferentUser").change(function() {
        setDifferentUser();
    });

    $("#foundDifferentUser").change(function() {
        setDifferentUser();
    })
});

var selectType = function() {
    var type = $("#selectType");
    switch(type.val()) {
        case TYPE.none:
            hideBoth();
            break;
        case TYPE.lost:
            showLost();
            break;
        case TYPE.found:
            showFound();
    }
};

var hideLost = function() {
    $(".lost").addClass("hidden");
};

var showLost = function() {
    $(".lost").removeClass("hidden");
    hideFound();
};

var hideFound = function() {
    $(".found").addClass("hidden");
};

var showFound = function() {
    $(".found").removeClass("hidden");
    hideLost();
};

var hideBoth = function() {
    hideLost();
    hideFound();
};

var setDifferentUser = function() {
    var checked = $("#lostDifferentUser").is(":checked") || $("#foundDifferentUser").is(":checked");
    if(checked)
        showDifferentUser();
    else
        hideDifferentUser();
};

var hideDifferentUser = function() {
    $(".differentUserWrapper").addClass("hidden");
    $(".differentUserWrapper > .input > input").attr("disabled", "disabled");
};

var showDifferentUser = function() {
    $(".differentUserWrapper").removeClass("hidden");
    $(".differentUserWrapper > .input > input").removeAttr("disabled");
};