<? require_once 'header.php' ?>
    <h1>
        Панель арбитража
    </h1>
    <table id="domains" style="float: left">
        <thead>
        <tr>
            <th>URL</th>
            <th>IP</th>
            <th>ACTIONS</th>
        </tr>
        </thead>
        <tbody>
        <? foreach ($domains as $domain) { ?>
            <tr class="domain" data-domain="<?= $domain['domain_name'] ?>">
                <td><?= $domain['domain_name'] ?></td>
                <td><?= $domain['ip'] ?></td>
                <td><a class="delete" style="color: red">DEL</a> <a
                        class="edit">EDIT</a></td>
            </tr>
        <? } ?>
        <tr>
            <td colspan="3" style="text-align: center"><a class="add" style="color: green">ADD</a></td>
        </tr>
        </tbody>
    </table>

    <table id="landings" style="float: left; display: none">
        <thead>
        <tr>
            <th>Landing name</th>
            <th>ACTIONS</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
    <div style="width: 170px">
        <a href="?param=route_interface">К панели роутинга</a>
    </div>


<? require_once __DIR__ . '/../forms/forms.php' ?>
<? require_once 'footer.php' ?>