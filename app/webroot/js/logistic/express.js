$(function(){
    var express_input = $('#express-input');
    var express_user_input = $('#express-input-user');

    var express_name= $('.express-name');
    var express_name_none = $('#express-name-none');
    var express_user_id = $('#express-user-id');

    var express_items = $('#express-items');
    var express_items_modal = $('#express-items-modal');
    var express_items_none = $('#express-items-none');

    var express_storages_template = $('#express-storages-template');
    var express_condition_template = $('#express-condition-template');

    var express_continue = $('#express-continue');
    var express_modal = $('#express-modal');
    var express_modal_cancel = $('#express-modal-cancel');

    var express_modal_visible = false;

    var express_bulk_modal = $('#express-bulk-modal');
    var express_bulk_modal_form = $('#express-bulk-modal-form');
    var express_bulk_modal_cancel = $('#express-bulk-modal-cancel');
    var express_bulk_AssetTag = $('#express-bulk-AssetTag');
    var express_bulk_name = $('#express-bulk-name');
    var express_bulk_amounts = $('#express-bulk-amounts');

    var express_bulk_first_input_field = null;

    var express_comment_modal = $('#express-comment-modal');
    var express_comment_modal_form = $('#express-comment-modal-form');
    var express_comment_field = $('#express-comment-field');
    var express_comment_modal_current_AssetTag = null;

    var express_crew_input = $('#express-crew-select');

    var express_user_crew = $('.express-user-crew');

    var express_user_crew_modal = $('.express-user-crew-modal');

    var express_creworuser = $('#express-creworuser');
    
    var children = [];

    //Functions start here

    var express_check_validity = function() {
        var valid = true;
        valid &= express_user_id.val() !== '';
        valid &= express_items.children().length > 1;
        if (express_mode === 'checkin') {
            $('.express-storages-dropdown').each(function() {
                valid &= $(this).val() !== '';
            });
        }
        express_continue.attr('disabled', valid ? null : 'disabled');
    };

    var express_set_user = function(user_id) {
        $.getJSON('./getUser/' + user_id, function(data){
            if (data === null) {
                alert('Invalid user');
                return;
            }
            express_name.html(data['name']);
            express_name_none.hide();
            express_user_id.val(data['id']);
            express_check_validity();
            express_input.focus();

            express_user_crew.html('User');
            express_user_crew_modal.html('User');
            express_creworuser.val('user');

            express_user_input.attr('disabled','disabled');
            express_crew_input.attr('disabled','disabled');
        });
    };

    var express_set_crew = function(crew_id) {
        $.getJSON('./getCrew/' + crew_id, function(data){
            if (data === null) {
                alert('Invalid crew');
                return;
            }
            express_name.html(data['name']);
            express_name_none.hide();
            express_user_id.val(data['id']);
            express_check_validity();
            express_input.focus();

            express_user_crew.html('Crew');
            express_user_crew_modal.html('Crew');
            express_creworuser.val('crew');

            express_user_input.attr('disabled','disabled');
            express_crew_input.attr('disabled','disabled');
        });
    };

    var express_show_bulk_modal = function(assetTag, item, storage_amounts, storages) {
        express_bulk_AssetTag.text(assetTag);
        express_bulk_name.html(item);
        express_bulk_amounts.empty();
        express_bulk_first_input_field = null;
        for (var storage_id in storages) {
            var storage_name = storages[storage_id];
            var storage_amount = (storage_id in storage_amounts ? storage_amounts[storage_id] : 0);
            if (express_mode === 'checkout' && storage_amount <= 0) {
                continue;
            }
            var input_field = $('<input type="text" />');
            if (express_bulk_first_input_field === null) {
                express_bulk_first_input_field = input_field;
            }
            var row = $('<tr class="express-amount-row" />').data('storage', storage_id);
            row.append($('<td />').text(storage_name));
            row.append($('<td class="number-column" />').text(storage_amount));
            row.append($('<td class="number-column" />').append(input_field));
            express_bulk_amounts.append(row);
        }
        express_bulk_modal.modal('show');
    };

    var express_remove_item = function(assetTag) {
        var rows = $('.express-row').filter(function() { return $(this).data('assetTag') == assetTag });
        rows.remove();
        express_check_validity();
        if (express_items.children().length <= 1) {
            express_items_none.show();
        }
    };

    var express_add_item = function(assetTag, item, storage_amounts, storages, comment) {
        var amount_list = $('<span>');
        if (storage_amounts !== undefined) {
            amount_list = $('<ul>');
            for (var storage_id in storage_amounts) {
                var storage_name = storages[storage_id];
                var storage_amount = storage_amounts[storage_id];
                var entry_text = (express_mode === 'checkout'
                    ? 'From' + storage_name + ': ' + storage_amount
                    : storage_name + ': ' + storage_amount);
                amount_list.append($('<li>').text(entry_text).append(
                    $('<input type="hidden" />')
                        .attr('name', 'amounts[' + assetTag.toLowerCase() + '][' + storage_id + ']')
                        .val(storage_amount)));
            }
        }
        var row = $('<tr class="express-row" />').data('assetTag', assetTag);
        row.append($('<td />').text(assetTag));
        if (express_mode === 'checkout') {
            row.append($('<td />').html(item).append(amount_list));
        } else {
            row.append($('<td />').html(item));
        }
        if (express_mode === 'checkin') {
            if (storage_amounts === undefined) {
                var storages_dropdown = express_storages_template
                    .clone()
                    .removeClass('hide')
                    .addClass('express-storages-dropdown')
                    .attr('id', '')
                    .change(function () {
                        express_check_validity();
                        var selected_option = $(this).find('option:selected');
                        $('[data-express-storage-id-for-assetTag=' + assetTag + ']').val(selected_option.val());
                        $('[data-express-storage-name-for-assetTag=' + assetTag + ']').text(selected_option.text());
                    });
                row.append($('<td />').append(storages_dropdown));
                var condition_dropdown = express_condition_template
                    .clone()
                    .removeClass('hide')
                    .attr('id', '')
                    .change(function () {
                        var selected_option = $(this).find('option:selected');
                        $('[data-express-condition-id-for-assetTag=' + assetTag + ']').val(selected_option.val());
                        $('[data-express-condition-name-for-assetTag=' + assetTag + ']').text(selected_option.text());
                        if (selected_option.val() != 'ok') {
                            express_show_comment_modal(assetTag);
                        }
                    });
                row.append($('<td />').append(condition_dropdown));
            } else {
                row.append($('<td />').append(amount_list));
                row.append($('<td>&mdash;</td>'));
            }
        }
        var remove_link = $('<a />')
            .addClass('btn btn-danger')
            .text('Remove')
            .click(function() { express_remove_item(assetTag); });
        row.append($('<td />').append(remove_link));
        express_items.append(row);
        var row = $('<tr class="express-row" />').data('assetTag', assetTag);
        row.append($('<td />').text(assetTag));
        if (express_mode === 'checkout') {
            row.append($('<td />').html(item).append(amount_list.clone()));
        } else {
            row.append($('<td />').html(item));
        }
        if (express_mode === 'checkin') {
            if (storage_amounts === undefined) {
                row.append($('<td />').append($('<span />').attr('data-express-storage-name-for-assetTag', assetTag)));
                row.append($('<td />').append($('<span />').attr('data-express-condition-name-for-assetTag', assetTag).text('OK')));
                row.append($('<input type="hidden" />')
                    .attr('name', 'storage[' + assetTag.toLowerCase() + ']')
                    .attr('data-express-storage-id-for-assetTag', assetTag));
                row.append($('<input type="hidden" />')
                    .attr('name', 'condition[' + assetTag.toLowerCase() + ']')
                    .attr('data-express-condition-id-for-assetTag', assetTag)
                    .val('ok'));
                row.append($('<input type="hidden" />')
                    .attr('name', 'comment[' + assetTag.toLowerCase() + ']')
                    .attr('data-express-comment-for-assetTag', assetTag)
                    .val(comment));
            } else {
                row.append($('<td />').append(amount_list.clone()));
                row.append($('<td>&mdash;</td>'));
            }
        }
        row.append($('<input type="hidden" />').attr('name', 'assetTags[]').val(assetTag.toLowerCase()));
        express_items_modal.append(row);

        express_items_none.hide();
        express_check_validity();
        express_input.focus();
        //check if there are more children to be added
        express_bulk_modal.modal('show');
        express_bulk_modal.modal('hide');

    };

    var express_process_input = function(input) {
        if (input === '') {
            express_show_modal();
            return;
        }
        express_process_assettag(input);
        $.getJSON('./getChildren/' + input,function(data){
            children = data['children'];
        });
    };

    var express_process_assettag = function (tag) {
        $.getJSON('./getItem/' + tag, function(data){
            if (data === null) {
                alert('Invalid AssetTag');
                return;
            }
            //var existing_assetTag_rows = $('.express-row').filter(function() { return data.item.toLowerCase() == tag.toLowerCase() });
            //if (existing_assetTag_rows.length > 0) {
            //    return;
            //}
            if (data.type === 'bulk') {
                //express_add_item(tag, data.item, data.storage_amounts, data.storages);
                express_show_bulk_modal(tag, data.item, data.storage_amounts, data.storages);
            } else {
                express_add_item(tag, data.item, undefined, undefined, data.comment);
            }
        });
    };

    var express_show_modal = function() {
        if (express_continue.attr('disabled') !== 'disabled') {
            express_modal.modal('show');
        }
    };

    var express_submit_bulk_modal = function() {
        var assetTag = express_bulk_AssetTag.text();
        var item = express_bulk_name.html();
        var storage_amounts = {};
        var storages = {};
        var total_amount = 0;
        express_bulk_amounts.children('tr').each(function(i, element) {
            var storage_id = $(element).data('storage');
            var storage_name = $(element).children('td').first().text();
            var storage_amount = $(element).find('input').val();
            if (storage_amount > 0) {
                storage_amounts[storage_id] = storage_amount;
                storages[storage_id] = storage_name;
                total_amount += storage_amount;
            }
        });
        if (total_amount > 0) {
            express_add_item(assetTag, item, storage_amounts, storages, '');
            express_bulk_modal.modal('hide');
        }
        express_input.focus();
        return false;
    };
    // used to trigger the addition of a new child only after the previous has been added and confirmed 
    var process_children = function(){
        if(children.length > 0){
            var child = children.pop();
            express_process_assettag(child['LogisticItem']['AssetTag']);
        }
    }
    //
    //Runtime starts here
    //

    //User
    express_user_input.focus();
    express_user_input.keypress(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            express_set_user(express_user_input.val());
            express_user_input.val('');
        }
    });
    express_crew_input.on('change', function(e) {
            express_set_crew(express_crew_input.val());
    });


    //AssetTag Input
    express_input.keypress(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            express_process_input(express_input.val());
            express_input.val('');
        }
    });

    express_continue.click(express_show_modal);
    express_modal_cancel.click(function() { express_modal.modal('hide'); });

    express_bulk_modal_form.submit(express_submit_bulk_modal);
    express_bulk_modal_cancel.click(function() { express_bulk_modal.modal('hide');  });

    express_modal.on('hidden.bs.modal',function(e){
        process_children();
    });
    express_bulk_modal.on('hidden.bs.modal',function(e){
        process_children();
    });

});