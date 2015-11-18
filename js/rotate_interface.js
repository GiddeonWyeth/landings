$(document).ready(function () {


    $(document).on('click', '.add', function () {
        $('#rotate_form').dialog({
            modal: true,
            title: "Создать ротатор",
            width: 870,
            height: 340,
            close: function (event, ui) {
                $("#rotate_form").attr('data-update', 0);
                $('#rotate_form select option:selected').attr('selected', false);
                $('#rotate_procents').empty();
                $('#rotate_form input[name="rotator_name"]').val('');
            }
        });
    });

    $('#rotate_form select').change(function () {
        var procents = [];
        var rotate_procents = $('#rotate_procents input');
        console.log(rotate_procents[0]);
        $('option:selected', this).each(function (index, elem) {
            if (typeof rotate_procents[index] != 'undefined') {
                procents[index] = rotate_procents[index].value;
            }
        });

        var inputs = '';
        $('#rotate_form select option:selected').each(function (index) {
            if (typeof procents[index] == 'undefined') {
                procents[index] = '';
            }
            inputs += '<label>' + $(this).text() + ' %</label><input type="text" name="procents[]" value="' + procents[index] + '" required><br>';
        });
        $('#rotate_procents').html(inputs);
    });

    $('#rotate_form').submit(function (e) {
        e.preventDefault();
        var data = $(this).serialize();
        var action = ($(this).data('update') == 1) ? 'update_rotator' : 'add_rotator';
        console.log(action);
        $("#rotate_form").dialog("close");
        $.ajax({
            url: "/landings/controllers/rotate_interface_controller.php?" + data,
            type: "post",
            dataType: "text",
            data: {
                action: action
            },
            success: function (ans) {
                $('#rotators tbody').html(ans);
            }
        });
    });

    $(document).on('click', '.delete', function () {
        var name = $(this).parents('tr').find('td:first-child').text();
        var c = confirm('Вы уверены, что хотите удалить данный ротатор?');
        if (c) {
            $.ajax({
                url: "/landings/controllers/rotate_interface_controller.php?name=" + name,
                type: "post",
                dataType: "text",
                data: {
                    action: 'delete_rotator'
                },
                success: function (ans) {
                    $('table tbody').html(ans);
                }
            });
        }
    });

    $(document).on('click', '.edit', function () {
        $('#rotate_form').attr('data-update', 1);
        $('#rotate_procents').html('');
        var lands = $(this).parents('tr').find('td:nth-child(2)').text().split(',');
        var name = $(this).parents('tr').find('td:first-child').text();
        var procents = $(this).parents('tr').find('td:nth-child(3)').text().split(',');
        $.each(lands, function (index, elem) {
            $('#rotate_form select option:contains(' + elem + ')').attr('selected', true);
            $('#rotate_procents').append('<label>' + elem + ' %</label><input type="text" name="procents[]" value="' + procents[index] + '" required><br>')
        });
        $('#rotate_form input[name="rotator_name"]').val(name);
        $('#rotate_form input[name="hidden_rotator_name"]').val(name);
        $('#rotate_form').dialog({
            modal: true,
            title: "Редактировать ротатор",
            width: 870,
            height: 340,
            close: function (event, ui) {
                $("#rotate_form").attr('data-update', 0);
                $('#rotate_form select option:selected').attr('selected', false);
                $('#rotate_procents').empty();
                $('#rotate_form input[name="rotator_name"]').val('');
            }
        });
    });

});