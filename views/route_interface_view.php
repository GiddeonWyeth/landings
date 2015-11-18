<? require_once 'header.php' ?>
    <h1>
        Панель роутинга
    </h1>
    <div id="add_redirect">
        <form>
            <label for="src">Откуда</label><input type="text" id="src" name="src" list="srcs" required>
            <datalist id="srcs">
                <? foreach ($global_landings as $landing) { ?>
                    <option value="<?= $landing['domain_name'] . '/' . $landing['name'] ?>"></option>
                <? } ?>
            </datalist>
            <label for="dest">Куда</label><input type="text" id="dest" name="dest" list="dests" required>
            <datalist id="dests">
                <? foreach ($global_landings as $landing) { ?>
                    <option value="<?= $landing['domain_name'] . '/' . $landing['name'] ?>" style="color: green">
                        Лэндинг
                    </option>
                <? } ?>

                <? foreach ($global_rotators as $rotator) { ?>
                    <option value="<?= $rotator['alias'] ?>" style="color: blue">Ротатор</option>
                <? } ?>
            </datalist>

            <span>Активировать:  </span><label for="active_y">Да</label><input type="radio" name="active" id="active_n"
                                                                               value="1" checked>
            <label for="active_n">Нет</label><input value="0" type="radio" name="active" id="active_n">
            <label for="type">Тип</label><select id="type">
                <option value="">Обычный редирект</option>
                <option value="">По правилу</option>
            </select>
            <fieldset style="padding-top: 10px;margin-top: 10px; display: none">
                <label for="device">Устройство</label>
                <select name="device" id="device">
                    <option value="">Любое</option>
                    <option value="iOS">iOS</option>
                    <option value="Android">Android</option>
                    <option value="Other">Другое</option>
                </select>

                <label for="sex">Пол</label>
                <select name="sex" id="sex">
                    <option value="">Любой</option>
                    <option value="m">Муж.</option>
                    <option value="w">Жен.</option>
                </select>

                <label for="geo">Местоположение</label>
                <select id="geo">
                    <option value="">Любое</option>
                    <option value="1">Спб</option>
                    <option value="2">Мск</option>
                </select>
            </fieldset>
            <input type="hidden" name="link_type">
            <button>Отправить</button>
        </form>
    </div>
    <div id="update_redirect">

    </div>
    <h2>
        Существующие редиректы
    </h2>
    <table>
        <thead>
        <tr>
            <th>Откуда</th>
            <th>Куда</th>
            <th>Активность</th>
            <th>Устройство</th>
            <th>Пол</th>
            <th>Геопозиция</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <? foreach ($redirects as $redirect) { ?>
            <tr class="redirect" data-id="<?= $redirect['id'] ?>">
                <td><?= $redirect['from'] ?></td>
                <td><?= $redirect['to'] ?></td>
                <td><?= $redirect['active'] ?></td>
                <td><?= $redirect['device'] ?></td>
                <td><?= $redirect['gender'] ?></td>
                <td></td>
                <td><a class="del" style="color: red">DEL</a><a class="edit">EDIT</a></td>
            </tr>
        <? } ?>
        </tbody>
    </table>
<? require_once 'footer.php' ?>