<form method="post" id="clone_form" style="display: none">
    <input type="hidden" id="src" name="src">
    <input type="hidden" id="domain" name="domain">
    <label for="dest">Куда</label><input type="text" id="dest" name="dest" required>
    <input type="submit">
</form>

<form method="post" id="add_domain" style="display: none">
    <label for="domain_name">Имя домена</label><input type="text" id="domain_name" required><br/>
    <label for="domain_ip">IP</label><input type="text" id="domain_ip" required>
    <input type="submit">
</form>

<form method="post" id="add_landing" style="display: none">
    <input type="hidden" id="land_domain">
    <label for="landing_name">Имя лэндинга</label><input type="text" id="landing_name" required><br/>
    <input type="submit">
</form>

<form method="post" id="edit_domain" style="display: none">
    <input type="hidden" id="domain_name_prev">
    <label for="domain_name_edit">Имя домена</label><input type="text" id="domain_name_edit" required><br/>
    <label for="domain_ip_edit">IP</label><input type="text" id="domain_ip_edit" required>
    <input type="submit">
</form>

<form method="post" id="rotate_form" style="display: none" data-update="0">
    <input type="hidden" id="rotator_name" name="hidden_rotator_name"><br/>
    <label for="rotator_name">Имя ротатора(на англ.)</label><input type="text" id="rotator_name" name="rotator_name"
                                                                   required><br/>
    <label for="rotate_landings"></label><select id="rotate_landings" name="rotate_landings[]" multiple size="10"
                                                 required>
        <? foreach ($global_landings as $landing) { ?>
            <option value="<?= $landing['id'] ?>"><?= $landing['domain_name'] . '/' . $landing['name'] ?></option>
        <? } ?>
    </select>

    <div id="rotate_procents">

    </div>
    <input type="submit">
</form>

