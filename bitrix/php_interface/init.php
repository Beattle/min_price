<?php
/**
 * Created by PhpStorm.
 * User: ninjacat
 * Date: 9/24/16
 * Time: 5:08 PM
 */



use Bitrix\Main;
use Bitrix\Main\Application;




Main\EventManager::getInstance()->addEventHandler(
    'sale',
    'OnSaleBasketBeforeSaved',
    'changePrice'
);


function changePrice(Main\Event $event)
{


    $basket = $event->getParameter("ENTITY");
    $just_add_id = (int)$_GET['id'];

    foreach ($basket as $item){
        $id = $item->getProductId();
        if($just_add_id == $id){
            $cur_Price_with_disc = $item->getPrice();
            $db_res = CPrice::GetList(
                array(),
                array(
                    "PRODUCT_ID" => $id,
                    "CATALOG_GROUP_ID" => 3
                )
            );
            if ($ar_res = $db_res->Fetch()) {
                $min_price = (int)$ar_res["PRICE"];
                $price = $cur_Price_with_disc < $min_price ? $min_price : $cur_Price_with_disc;



                $item->setFields(array(
                    'PRODUCT_PROVIDER_CLASS' => '',
                    // 'PRICE'=>420,
                    'BASE_PRICE' => $price,
                //    'CUSTOM_PRICE'=>'Y',
         //           'IGNORE_CALLBACK_FUNC' => '',
                    'DISCOUNT_PRICE' => 0,
                ));


                $item->save();


            }
        }
    }



      return new Main\EventResult(Main\EventResult::SUCCESS);

}


