<?php
use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;
use Bitrix\Iblock;

Loader::includeModule('iblock');
Loader::includeModule('custom.loggingmodule');

$iblocks = [];
$res = Iblock\IblockTable::getList([
    'select' => ['ID', 'NAME'],
    'filter' => ['ACTIVE' => 'Y'],
]);

while ($iblock = $res->fetch()) {
    $iblocks[$iblock['ID']] = $iblock['NAME'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && check_bitrix_sessid()) {
    $selectedIblocks = $_POST['iblocks'] ?? [];
    Option::set('custom.loggingmodule', 'selected_iblocks', serialize($selectedIblocks));
}

$selectedIblocks = Option::get('custom.loggingmodule', 'selected_iblocks', '[]');
$selectedIblocks = unserialize($selectedIblocks) ?: [];

?>

<form method="POST">
    <?= bitrix_sessid_post() ?>
    <label for="iblocks">Выберите инфоблоки для логирования событий:</label>
    <select name="iblocks[]" id="iblocks" multiple>
        <?php foreach ($iblocks as $id => $name): ?>
            <option value="<?= $id ?>" <?= in_array($id, $selectedIblocks) ? 'selected' : '' ?>><?= $name ?></option>
        <?php endforeach; ?>
    </select>
    <br><br>
    <input type="submit" value="Сохранить настройки">
</form>
