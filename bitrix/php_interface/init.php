<?php
/**
 * Created by PhpStorm.
 * User: ninjacat
 * Date: 9/24/16
 * Time: 5:08 PM
 */

$event = new Bitrix\Main\Event("main", "OnPageStart");
$event->send();
// echo '<pre>'.print_r($event->getReults(),true).'</pre>';
foreach ($event->getResults() as $eventResult)
{
    switch($eventResult->getType())
    {
        case \Bitrix\Main\EventResult::ERROR:
            // обработка ошибки
        case \Bitrix\Main\EventResult::SUCCESS:
            // успешно
            $handlerRes = $eventResult->getParameters(); // получаем то, что вернул нам обработчик события

        case \Bitrix\Main\EventResult::UNDEFINED:
            break;
    }
}

print_r($handlerRes);

use Bitrix\Main;
use Bitrix\Main\Diag\Debug;
Main\EventManager::getInstance()->addEventHandler(
    'sale',
    'OnSaleBasketBeforeSaved',
    'myFunction'
);

function myFunction(Main\Event $event)
{
    /** @var Basket $basket */
    $basket = $event->getParameter("ENTITY");

        die(print_r(get_class_methods($basket)));
    echo Main\Diag\Debug::dump($basket);
    Debug::dump($basket, $varName = "", $return = false);

        return new Main\EventResult(Main\EventResult::ERROR);

}
