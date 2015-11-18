<? require_once 'header.php' ?>
    <h1>
        Панель ротации
    </h1>

    <table id="rotators" style="float: left">
        <thead>
        <tr>
            <th>Имя ротатора</th>
            <th>Лэндинги в нем</th>
            <th>%</th>
            <th>ACTIONS</th>
        </tr>
        </thead>
        <tbody>
        <? foreach ($rotators as $rotator) { ?>
            <tr class="rotator">
                <td><?= $rotator['alias'] ?></td>
                <td><?= $rotator['landing'] ?></td>
                <td><?= $rotator['procent'] ?></td>
                <td><a class="delete" style="color: red">DEL</a> <a
                        class="edit">EDIT</a></td>
            </tr>
        <? } ?>
        <tr>
            <td colspan="3" style="text-align: center"><a class="add" style="color: green">ADD</a></td>
        </tr>
        </tbody>
    </table>
<? require_once __DIR__ . '/../forms/forms.php' ?>
<? require_once 'footer.php' ?>