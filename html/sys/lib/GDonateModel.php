<?php

class GDonateModel
{
    private $mysqli;

    static function getInstance()
    {
        return new self();
    }

    private function __construct()
    {
        $this->mysqli = @new mysqli ('localhost','root','0995285101', 'csgo');
        /* проверка подключения */
        if (mysqli_connect_errno()) {
            throw new Exception('Не удалось подключиться к бд');
        }
    }

    function createPayment($gdonateId, $account, $sum, $itemsCount)
    {
        $query = '
            INSERT INTO
                gdonate_payments (gdonateId, account, sum, itemsCount, dateCreate, status)
            VALUES
                (
                    "'.$this->mysqli->real_escape_string($gdonateId).'",
                    "'.$this->mysqli->real_escape_string($account).'",
                    "'.$this->mysqli->real_escape_string($sum).'",
                    "'.$this->mysqli->real_escape_string($itemsCount).'",
                    NOW(),
                    0
                )
        ';

        return $this->mysqli->query($query);
    }

    function getPaymentByGDonateId($gdonateId)
    {
        $query = '
                SELECT * FROM
                    gdonate_payments
                WHERE
                    gdonateId = "'.$this->mysqli->real_escape_string($gdonateId).'"
                LIMIT 1
            ';
            
        $result = $this->mysqli->query($query);
        return $result->fetch_object();
    }

    function confirmPaymentByGDonateId($gdonateId)
    {
        $query = '
                UPDATE
                    gdonate_payments
                SET
                    status = 1,
                    dateComplete = NOW()
                WHERE
                    gdonateId = "'.$this->mysqli->real_escape_string($gdonateId).'"
                LIMIT 1
            ';
        return $this->mysqli->query($query);
    }
    
    function getAccountByName($account)
    {
        $sql = "
            SELECT
                *
            FROM
               account
            WHERE
               steamid = '".$this->mysqli->real_escape_string($account)."'
            LIMIT 1
         ";
         
        $result = $this->mysqli
            ->query($sql);
            
        return $result->fetch_object();
    }
    
    function donateForAccount($account, $count)
    {
        $query = "
            UPDATE
                account
            SET
                money = money + ".$this->mysqli->real_escape_string($count)."
            WHERE
                steamid = '".$this->mysqli->real_escape_string($account)."'
        ";
        
        return $this->mysqli->query($query);
    }
}