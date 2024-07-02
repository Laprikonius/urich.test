<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && check_bitrix_sessid()) {
    echo "<p>Тестовый Модуль удален.</p>";
    echo "<script>setTimeout(function(){ document.location.href='/bitrix/admin/module_admin.php?lang=".LANGUAGE_ID."'; }, 3000);</script>";
} else {
?>
<form action="<?= $APPLICATION->GetCurPage() ?>" method="post">
    <?= bitrix_sessid_post() ?>
    <p>Удалить логи Тестового Модуля?</p>
    <input type="checkbox" name="delete_logs" value="Y"> Yes
    <br><br>
    <input type="submit" value="Uninstall Module">
</form>
<?php
}
?>