<?php
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Application;
use Bitrix\Main\EventManager;

class custom_loggingmodule extends CModule
{
    public function __construct()
    {
        $arModuleVersion = array();
        include(__DIR__ . "/version.php");

        $this->MODULE_ID = 'custom.loggingmodule';
        $this->MODULE_VERSION = $arModuleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        $this->MODULE_NAME = GetMessage('CUSTOM_LOGGING_MODULE_NAME');
        $this->MODULE_DESCRIPTION = GetMessage('CUSTOM_LOGGING_MODULE_DESCRIPTION');
        $this->PARTNER_NAME = GetMessage('CUSTOM_LOGGING_MODULE_PARTNER_NAME');
        $this->PARTNER_URI = GetMessage('CUSTOM_LOGGING_MODULE_PARTNER_URI');
    }

    public function DoInstall()
    {
        global $APPLICATION;
        $this->InstallFiles();
        $this->InstallDB();
        $this->InstallEvents();
        ModuleManager::registerModule($this->MODULE_ID);
        $APPLICATION->IncludeAdminFile("Installing custom Тестовый Модуль", __DIR__ . "/step.php");
    }

    public function DoUninstall()
    {
        global $APPLICATION;
        $this->UnInstallEvents();
        $this->UnInstallDB();
        $this->UnInstallFiles();
        ModuleManager::unRegisterModule($this->MODULE_ID);
        $APPLICATION->IncludeAdminFile("Uninstalling custom Тестовый Модуль", __DIR__ . "/unstep.php");
    }

    public function InstallDB()
    {
        $connection = Application::getConnection();
        $sql = "CREATE TABLE IF NOT EXISTS custom_logging (
            ID INT AUTO_INCREMENT PRIMARY KEY,
            EVENT VARCHAR(50),
            IBLOCK_ID INT,
            ELEMENT_ID INT,
            NAME VARCHAR(255),
            DATE_AND_TIME_RECORD DATETIME,
            DATE_RECORD DATE,
            USER_ID INT
        )";
        $connection->queryExecute($sql);
    }

    public function UnInstallDB()
    {
        if ($_POST['delete_logs'] == 'Y') {
            $connection = Application::getConnection();
            
            $sql = "DROP TABLE IF EXISTS custom_logging";
            $connection->queryExecute($sql);
        }
    }

    public function InstallEvents()
    {
        EventManager::getInstance()->registerEventHandler('iblock', 'OnAfterIBlockElementAdd', $this->MODULE_ID, 'CustomLoggingModuleClass', 'OnAfterIBlockElementAddHandler');
        EventManager::getInstance()->registerEventHandler('iblock', 'OnAfterIBlockElementUpdate', $this->MODULE_ID, 'CustomLoggingModuleClass', 'OnAfterIBlockElementUpdateHandler');
        EventManager::getInstance()->registerEventHandler('iblock', 'OnAfterIBlockElementDelete', $this->MODULE_ID, 'CustomLoggingModuleClass', 'OnAfterIBlockElementDeleteHandler');
    }

    public function UnInstallEvents()
    {
        EventManager::getInstance()->unRegisterEventHandler('iblock', 'OnAfterIBlockElementAdd', $this->MODULE_ID, 'CustomLoggingModuleClass', 'OnAfterIBlockElementAddHandler');
        EventManager::getInstance()->unRegisterEventHandler('iblock', 'OnAfterIBlockElementUpdate', $this->MODULE_ID, 'CustomLoggingModuleClass', 'OnAfterIBlockElementUpdateHandler');
        EventManager::getInstance()->unRegisterEventHandler('iblock', 'OnAfterIBlockElementDelete', $this->MODULE_ID, 'CustomLoggingModuleClass', 'OnAfterIBlockElementDeleteHandler');
    }

    public function InstallFiles()
    {
        CopyDirFiles(__DIR__ . "/admin", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/admin", true, true);
    }

    public function UnInstallFiles()
    {
        DeleteDirFiles(__DIR__ . "/admin", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/admin");
    }
}
?>
