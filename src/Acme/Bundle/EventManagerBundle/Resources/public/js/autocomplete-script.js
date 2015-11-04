/**
 * Created by bezimienny on 04.11.15.
 */
$(function () {
    $("#user_data_country").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "http://localhost/sites/EMW-Platform/web/app_dev.php/api/v1/countries",
                dataType: 'json',
                data: {
                    searchTerm: request.term,
                    limit: 5,
                    order: 'ASC'
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        minLength: 1,
        dataType: 'json',
        select: function (event, ui) {
            // feed hidden id field
            $("#user_data_country").val(ui.item.id);
            // update number of returned rows
            $('#results_count').html('');
        },
        open: function (event, ui) {
            // update number of returned rows
            var len = $('.ui-autocomplete > li').length;
            $('#results_count').html('(#' + len + ')');
        },
        close: function (event, ui) {
            // update number of returned rows
            $('#results_count').html('');
        },
        // mustMatch implementation
        change: function (event, ui) {
            if (ui.item === null) {
                $(this).val('');
                $('#user_data_country').val('');
            }
        }
    });
    $("#user_data_faculty_name").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "http://localhost/sites/EMW-Platform/web/app_dev.php/api/v1/faculties",
                dataType: 'json',
                data: {
                    searchTerm: request.term,
                    limit: 5,
                    order: 'ASC'
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        minLength: 1,
        dataType: 'json'
    });
    $("#user_data_university_name").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "http://localhost/sites/EMW-Platform/web/app_dev.php/api/v1/universities",
                dataType: 'json',
                data: {
                    searchTerm: request.term,
                    limit: 5,
                    order: 'ASC'
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        minLength: 1,
        dataType: 'json',
        change: function (event, ui) {
            $("#user_data_university_name").val(ui.item ? ui.item.value : "");
            if (ui.item) {
                $("#user_data_university_address").val(ui.item.address);
            }
        },
        select: function (event, ui) {
            $("#user_data_university_name").val(ui.item ? ui.item.value : "");
            $("#user_data_university_address").val(ui.item.address);
        }
    });
});