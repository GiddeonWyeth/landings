$(document).ready(function () {

    $('#domain_ip, #domain_ip_edit').mask('099.099.099.099');

    $(document).on('click', '#domains tbody tr.domain td:first-child', function () {
        var name = $(this).parent().data('domain');
        $("#land_domain").val(name);
        $.ajax({
            url: "/landings/controllers/interface_controller.php",
            type: "post",
            dataType: "text",
            data: {
                name: name, action: 'get_landings'
            },
            success: function (ans) {
                $('#landings tbody').html(ans);
                $('#landings').attr('data-domen', name).fadeIn();
            }
        });
    });

    $(document).on('click', '#domains .add', function () {
        $("#add_domain").dialog({
            modal: true,
            title: "Создать домен",
            width: 400,
            height: 190
        });
    });

    $(document).on('click', '#landings .delete', function () {
        var name = $(this).parents('tr').find('td:first-child').text();
        var domain = $(this).parents('tr').data('domain');

        var c = confirm('Вы уверены, что хотите удалить лэндинг ' + name + ' с домена ' + domain);
        if (c) {
            $.ajax({
                url: "/landings/controllers/interface_controller.php",
                type: "post",
                dataType: "text",
                data: {
                    landing_name: name, domain_name: domain, action: 'delete_landing'
                },
                success: function (ans) {
                    $.LoadingOverlay("hide");
                    $('#landings tbody').html(ans);
                }
            });
        }
    });

    $(document).on('click', '#domains .delete', function () {
        var name = $(this).parents('tr').find('td:first-child').text();

        var c = confirm('Вы уверены, что хотите удалить домен ' + name + '?');
        if (c) {
            $.ajax({
                url: "/landings/controllers/interface_controller.php",
                type: "post",
                dataType: "text",
                data: {
                    domain_name: name, action: 'delete_domain'
                },
                success: function (ans) {
                    $.LoadingOverlay("hide");
                    if (ans != 'false') {
                        $('#domains tbody').html(ans);
                    } else {
                        alert('Сначала необходимо удалить все лэндинги на данном домене!')
                    }
                }
            });
        }
    });

    $(document).on('click', '#landings .add', function () {
        $("#add_landing").dialog({
            modal: true,
            title: "Добавить лэндинг",
            width: 400,
            height: 190
        });
    });

    $(document).on('click', '#domains .edit', function () {
        $('#edit_domain #domain_name_edit').val($(this).parents('tr').find('td:first-child').text());
        $('#edit_domain #domain_name_prev').val($(this).parents('tr').find('td:first-child').text());
        $('#edit_domain #domain_ip_edit').val($(this).parents('tr').find('td:nth-child(2)').text());
        $("#edit_domain").dialog({
            modal: true,
            title: "Редактировать домен",
            width: 400,
            height: 190
        });
    });

    $('#add_landing').submit(function (e) {
        e.preventDefault();
        $("#add_landing").dialog("close");
        var domain_name = $(this).find('#land_domain').val();
        var landing_name = $(this).find('#landing_name').val();

        $.LoadingOverlay("show");
        $.ajax({
            url: "/landings/controllers/interface_controller.php",
            type: "post",
            dataType: "text",
            data: {
                landing_name: landing_name, domain_name: domain_name, action: 'add_landing'
            },
            success: function (ans) {
                $.LoadingOverlay("hide");
                $('#landings tbody').html(ans);
            }
        });
    });

    $('#add_domain').submit(function (e) {
        e.preventDefault();
        var re = /^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/;
        var domain_name = $(this).find('#domain_name').val();
        var domain_ip = $(this).find('#domain_ip').val();
        if (re.test(domain_name)) {
            $("#add_domain").dialog("close");


            $.LoadingOverlay("show");
            $.ajax({
                url: "/landings/controllers/interface_controller.php",
                type: "post",
                dataType: "text",
                data: {
                    domain_name: domain_name, domain_ip: domain_ip, action: 'add_domain'
                },
                success: function (ans) {
                    $.LoadingOverlay("hide");
                    $('#domains tbody').html(ans);
                }
            });
        } else {
            alert('Введите корректный url');
        }
    });

    $('#edit_domain').submit(function (e) {
        e.preventDefault();
        var domain_name = $(this).find('#domain_name_edit').val();
        var domain_ip = $(this).find('#domain_ip_edit').val();
        var re = /^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/;
        if (re.test(domain_name)) {
            $("#edit_domain").dialog("close");

            var domain_name_prev = $(this).find('#domain_name_prev').val();
            $.LoadingOverlay("show");
            $.ajax({
                url: "/landings/controllers/interface_controller.php",
                type: "post",
                dataType: "text",
                data: {
                    domain_name_prev: domain_name_prev,
                    domain_name: domain_name,
                    domain_ip: domain_ip,
                    action: 'update_domain'
                },
                success: function (ans) {
                    $.LoadingOverlay("hide");
                    $('#domains tbody').html(ans);
                }
            });
        } else {
            alert('Введите корректный url');
        }
    });


    $(document).on('click', '.clone', function () {
        $("#clone_form #src").val($(this).parent().parent().find('td:first').text());
        $("#clone_form #domain").val($(this).parent().parent().data('domain'));
        $("#clone_form").dialog({
            modal: true,
            title: "Куда клонировать?",
            width: 400,
            height: 140
        });
    });

    $('#clone_form').submit(function (e) {
        e.preventDefault();
        $("#clone_form").dialog("close");
        var domain = $("#clone_form #domain").val();
        var src = '../lands/' + domain + '/' + $("#clone_form #src").val();
        var dest = '../lands/' + domain + '/' + $("#clone_form #dest").val();

        $.LoadingOverlay("show");
        $.ajax({
            url: "/landings/controllers/interface_controller.php?domain=" + domain,
            type: "post",
            dataType: "text",
            data: {
                src: src, dest: dest, action: 'copyr'
            },
            success: function (ans) {
                $.LoadingOverlay("hide");
                console.log(ans);
                $('#landings tbody').html(ans);
            }
        });
    });


});