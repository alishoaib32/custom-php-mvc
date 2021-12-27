<?php

namespace system;

use PDO;

/**
 * Base model
 */
abstract class Model
{

    /**
     * Get the PDO database connection
     *
     * @return mixed
     */
    public static function getDB()
    {
        static $db = null;
        global $logger;
        if ($db === null) {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
            try {
                $db = new PDO($dsn, DB_USER, DB_PASS);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            } catch (PDOException $e) {
                $logger->critical("FAILED TO CONNECT TO DATABASE USING PROVIDED CONFIG", [
                    "Error" => $e->getMessage(),
                    "CONFIG" => [
                        "Host" => DB_HOST,
                        "Database" => DB_NAME,
                        "Username" => DB_USER,
                        "Password" => DB_PASS
                    ]
                ]);
                die("Connection failed! check the logs.");
            }
        }
        return $db;
    }
}