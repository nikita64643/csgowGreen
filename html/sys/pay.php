<?php

error_reporting(0);

include 'api.php';
include 'lib/GDonateModel.php';
include 'lib/GDonate.php';

class GDonateEvent{
    public function check($params)
    {    
         $GDonateModel = GDonateModel::getInstance();         
         
         if ($GDonateModel->getAccountByName($params['account']))
         {
            return true;      
         }  
         return 'Character not found';
    }

    public function pay($params)
    {
         $GDonateModel = GDonateModel::getInstance();
         $GDonateModel->donateForAccount($params['account'], $params['sum']);
    }
}

$payment = new GDonate(
    new GDonateEvent()
);

echo $payment->getResult($privategdonate);
?>