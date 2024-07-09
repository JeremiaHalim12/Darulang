<?php

class PDOUtil
{

    public static function createConnection()
    {
        // $link = new PDO('mysql:host=127.0.0.1;buyvegetables','darulang_admin','fitukm12345*');
        // $link = new PDO('mysql:host=127.0.0.1;buyvegetables','root','');

        // $link = new PDO('mysql:host=localhost;dbname=darulang_product', 'root', '');
        $link = new PDO('mysql:host=127.0.0.1;dbname=darulang_product', 'darulang_admin', 'fitukm12345*');
        $link->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
        $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $link;
    }

    public static function closeConnection($link)
    {
        $link = null;
    }
}
