<?php
/**
 * Created by PhpStorm.
 * User: PONTES_STEFANE-ESIG
 * Date: 27.09.2018
 * Time: 10:51
 */

require_once(dirname(__DIR__)."/config.php");

class Connection
{
    public static function getConnection()
    {

        $connection = new PDO(DB_DRIVE.":host=".DB_HOSTNAME.";dbname=".DB_DATABASE.";charset=".DB_ENCODING, DB_USERNAME, DB_PASSWORD);

        //$connection = new MyPDO();
        return $connection;
    }
}