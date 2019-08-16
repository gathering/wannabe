$(document).ready(function() {

    var loadLinks = $(".tryLoadLink");

    $.each(loadLinks, function(index, element) {
        var that = $(this);
        var matches = /(https?:[^\s]+)/.exec(that.val());

        if(!matches) return;
        var url = matches[1];
        var linkSpan = '<span class="apiUserIdLink help-block"><a href="' + url + '">Link to user</a></span>';

        $(linkSpan).insertAfter(that);
    });
});