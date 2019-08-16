$(document).ready(function() {

    $("#addStoragePlace").click(function(e) {
        e.preventDefault();
        addStoragePlace();
        $("#LostAndFoundStoragePlaceName").val("");
    });

    updateBoth();
});

$(document).on("click", ".setStoragePlaceActive", function() {
    setStoragePlaceActiveState($(this), false);
});

$(document).on("click", ".setStoragePlaceInactive", function() {
    setStoragePlaceActiveState($(this), true);
});

var updateBoth = function() {
    updateActiveStoragePlaces();
    updateInactiveStoragePlaces();
};

var updateActiveStoragePlaces = function() {
    var activeCategoriesElement = $("#activeStoragePlaces").find("tbody");
    getStoragePlaces(activeCategoriesElement, true);
    var updatedActive = $("#activeUpdate");
    updatedActive.html("<i class='fa fa-spinner fa-spin'></i> Updating active storage places!");
};

var updateInactiveStoragePlaces = function() {
    var inactiveCategoriesElement = $("#inactiveStoragePlaces").find("tbody");
    getStoragePlaces(inactiveCategoriesElement, false);
    var updatedActive = $("#inactiveUpdate");
    updatedActive.html("<i class='fa fa-spinner fa-spin'></i> Updating inactive storage places!");
};

var getStoragePlaces = function(selector, active) {
    $.post("storagePlacesList", {'active': active}).success(function(data) {
        selector.html(data);
    }).error(function() {
        console.log("Could not get active storage places.");
    }).always(function() {
        $(selector).parent().parent().find("div.updater").html("");
    });
};

var addStoragePlace = function() {
    removeError();
    $("#addStoragePlaceForm").ajaxSubmit({
        success: function(data) {
            if(data) {
                var message = JSON.parse(data);
                setError(message);
            }
            else {
                updateActiveStoragePlaces();
            }
        },
        error: function() {
        }
    });
};

var setStoragePlaceActiveState = function(element, active) {
    var id = $(element).attr("data-storage-place-id");
    var url = "setStoragePlaceActiveState";

    $.post(url, { 'id': id, 'active': active }).success(function() {
        updateBoth();
    }).error(function() {
        console.log("Could not set storage place " + (active ? "active" : "inactive"));
    });
};

var setError = function(message) {
    $(".validate.clearfix").addClass("error");
    $(".help-block").text(message.name);
};

var removeError = function() {
    $(".validate.clearfix").removeClass("error");
    $(".help-block").text("");
};


