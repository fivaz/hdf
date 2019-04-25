<?php
/**
 * Created by PhpStorm.
 * User: Frank Théodoloz
 * Date: 24.09.2018
 * Time: 15:07
 */

require_once(dirname(__DIR__)."/config.php");

/**
 * Class MyPDO : Creates a constructor for PDO-MySQL connection
 * Reference: https://stackoverflow.com/a/9328613 and https://stackoverflow.com/a/18684115
 */
class myPDO extends PDO
{
    public function __construct($dsn = null, $username = null, $password = null, array $driver_options = null)
    {
        $dbServer = DB_HOSTNAME;
        $dbName = DB_DATABASE;
        $username = DB_USERNAME;
        $password = DB_PASSWORD;
        $dsn = "mysql:host=$dbServer;dbname=$dbName;charset=utf8";

        $driver_options = array(
            PDO::MYSQL_ATTR_FOUND_ROWS => TRUE,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        parent:: __construct($dsn, $username, $password, $driver_options);
    }
}
