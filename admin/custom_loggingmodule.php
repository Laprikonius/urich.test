<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php";
CModule::IncludeModule('custom.loggingmodule');

$APPLICATION->SetTitle('Настройки модуля логирования');

require __DIR__ . '/../options.php';

require_once $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php";
?>
