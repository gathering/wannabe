var useRFID = true;


$(document).ready(function() {

    var apiFields = $(".apiUserId");

    $.each(apiFields, function(index, field) {
        console.log($(field).closest(".apiUserIdContainer"));
        var checkboxWrapper =
            '<div class="clearfix input" style="margin-top: 15px">' +
                '<input id="apiBox' + index + '" type="checkbox" class="apiUserIdTrigger" checked data-api-id="' + index + '"> ' +
                '<label for="apiBox' + index + '" style="float: none; width: inherit">I want to scan RFID from badge or bracelet.' + '</label>' +
            '</div>';
        var apiMessageSpan = '<span class="apiUserIdMessage' + index + ' help-block"></span>';
        var linkSpan = '<span class="apiUserIdLink' + index + '"></span>';

        $(field).closest(".apiUserIdContainer").prepend(checkboxWrapper);
        $(field).attr("data-api-id", index);
        $(linkSpan).insertAfter($(this));
        $(apiMessageSpan).insertAfter($(this));
        //$(linkSpan).insertAfter($(apiMessageSpan));
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
});