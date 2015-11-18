$(document).ready(function () {

    $(document).on('change', '#type', function () {
        $(this).parents('form').find('fieldset').toggle();
    });

    $(document).on('submit', 'form', function (e) {
        e.preventDefault();
        $.LoadingOverlay("show");
        var data = $(this).serialize();
        var action = $(this).parent().attr('id');
        if (action == 'update_redirect') {
            $('#update_redirect').dialog("close");
        }
        var id = $(this).parent().data('id');
        $.ajax({
            url: "/landings/controllers/route_interface_controller.php?" + data + "&id=" + id,
            type: "post",
            dataType: "text",
            data: {
                action: action
            },
            success: function (ans) {
                $.LoadingOverlay("hide");
                $('table tbody').html(ans);
            }
        });
    });

    $(document).on('click', '.edit', function () {
        var tr = $(this).parents('tr');
        $('#update_redirect').html($('#add_redirect').html());
        $('#update_redirect').attr('data-id', tr.data('id'));
        $('#update_redirect form #src').val(tr.find('td:first-child').text());
        $('#update_redirect form #dest').val(tr.find('td:nth-child(2)').text());
        $('#update_redirect form input[value="' + tr.find('td:nth-child(3)').text() + '"]').attr('checked', true);

        var options = $('#dests')[0].options;
        var val = tr.find('td:nth-child(2)').text();
        for (var i = 0; i < options.length; i++) {
            if (options[i].value === val) {
                $('#update_redirect form').find('input[name="link_type"]').val(options[i].text)
            }
        }

        if (tr.find('td:nth-child(4)').text() == '' && tr.find('td:nth-child(5)').text() == '' && tr.find('td:nth-child(6)').text() == '') {
            $('#update_redirect form select option:first-child').attr('selected', true);
            $('#update_redirect form fieldset').hide();
        } else {
            $('#update_redirect form #type option:nth-child(2)').attr('selected', true);
            $('#update_redirect form fieldset').show();
            $('#update_redirect form #device option[value="' + tr.find('td:nth-child(4)').text() + '"]').attr('selected', true);
            $('#update_redirect form #sex option[value="' + tr.find('td:nth-child(5)').text() + '"]').attr('selected', true);
            $('#update_redirect form #geo option[value="' + tr.find('td:nth-child(6)').text() + '"]').attr('selected', true);
        }
        $('#update_redirect').dialog({
            modal: true,
            title: "Редактировать редирект",
            width: 870,
            height: 220
        });
    });

    $(document).on('click', '.del', function () {
        var id = $(this).parents('tr').data('id');
        var c = confirm('Вы уверены, что хотите удалить данное правило редиректа?');
        if (c) {
            $.ajax({
                url: "/landings/controllers/route_interface_controller.php?id=" + id,
                type: "post",
                dataType: "text",
                data: {
                    action: 'delete_redirect'
                },
                success: function (ans) {
                    $('table tbody').html(ans);
                }
            });
        }
    });

    $(document).on('change', '#dest', function () {
        var form = $(this).parent();
        var options = $('#dests')[0].options;
        var val = $(this).val();
        for (var i = 0; i < options.length; i++) {
            if (options[i].value === val) {
                form.find('input[name="link_type"]').val(options[i].text)
            }
        }
    });
});