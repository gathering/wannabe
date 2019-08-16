$(document).ready(function() {

    $("#addCategory").click(function(e) {
        e.preventDefault();
        addCategory();
        $("#LostAndFoundCategoryName").val("");
    });

    updateBothCategories();
});

$(document).on("click", ".setCategoryActive", function() {
    setCategoryActiveState($(this), false);
});

$(document).on("click", ".setCategoryInactive", function() {
    setCategoryActiveState($(this), true);
});

var updateBothCategories = function() {
    updateActiveCategories();
    updateInactiveCategories();
};

var updateActiveCategories = function() {
    var activeCategoriesElement = $("#activeCategories").find("tbody");
    getCategories(activeCategoriesElement, true);
    var updatedActive = $("#activeUpdate");
    updatedActive.html("<i class='fa fa-spinner fa-spin'></i> Updating active categories!");
};

var updateInactiveCategories = function() {
    var inactiveCategoriesElement = $("#inactiveCategories").find("tbody");
    getCategories(inactiveCategoriesElement, false);
    var updatedActive = $("#inactiveUpdate");
    updatedActive.html("<i class='fa fa-spinner fa-spin'></i> Updating inactive categories!");
};

var getCategories = function(selector, active) {
    $.post("categoriesList", {'active': active}).success(function(data) {
        selector.html(data);
    }).error(function() {
        console.log("Could not get active categories.");
    }).always(function() {
        $(selector).parent().parent().find("div.updater").html("");
    });
};

var addCategory = function() {
    removeError();
    $("#addCategoryForm").ajaxSubmit({
        success: function(data) {
            if(data) {
                var message = JSON.parse(data);
                setError(message);
            }
            else {
                updateActiveCategories();
            }
        },
        error: function() {
        }
    });
};

var setCategoryActiveState = function(element, active) {
    var id = $(element).attr("data-category-id");
    var url = "setCategoryActiveState";

    $.post(url, { 'id': id, 'active': active }).success(function() {
        updateBothCategories();
    }).error(function() {
        console.log("Could not set category " + (active ? "active" : "inactive"));
    });
};

var setError = function(message) {
    $(".validate.clearfix").addClass("error");
    $(".help-block").text(message.name)
};

var removeError = function() {
    $(".validate.clearfix").removeClass("error");
    $(".help-block").text("");
};