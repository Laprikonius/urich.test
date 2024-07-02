<?php
class CustomLoggingModuleClass
{
    public static function OnAfterIBlockElementAddHandler(&$arFields)
    {
        self::logEvent('ADD', $arFields);
    }

    public static function OnAfterIBlockElementUpdateHandler(&$arFields)
    {
        self::logEvent('UPDATE', $arFields);
    }

    public static function OnAfterIBlockElementDeleteHandler($arFields)
    {
        self::logEvent('DELETE', $arFields);
    }

    private static function logEvent($event, $arFields)
    {
        global $USER;
        $userId = $USER->GetID();
        $connection = \Bitrix\Main\Application::getConnection();
        $sqlHelper = $connection->getSqlHelper();

        $iblockId = intval($arFields['IBLOCK_ID']);
        $elementId = intval($arFields['ID']);
        $name = $sqlHelper->forSql($arFields['NAME']);
        $dateTime = date('Y-m-d H:i:s');
        $date = date('Y-m-d');

        $sql = "INSERT INTO custom_logging (EVENT, IBLOCK_ID, ELEMENT_ID, NAME, DATE_AND_TIME_RECORD, DATE_RECORD, USER_ID) VALUES 
                ('$event', $iblockId, $elementId, '$name', '$dateTime', '$date', $userId)";
        $connection->queryExecute($sql);
    }
}
?>
