<?php

namespace Core;

use PDO;
use Core\Config;

/** 
 * Base model
 *
 * PHP version 7.0
 */
abstract class Model
{

    /**
     * Get the PDO User database connection
     * 
     * @param string DB name
     * @return mixed
     */
    protected static function getDB()
    {
        static $db = null;
        
        if ($db === null) { 

            $socket = !empty(Config::get('DB_SOCKET')) ? ';unix_socket=' . Config::get('DB_SOCKET') : '';
            $charset = !empty(Config::get('DB_CHARSET')) ? ';unix_socket=' . Config::get('DB_CHARSET') : '';

            $dsn = 'mysql:host=' . Config::get('DB_HOST') . ';dbname=' . Config::get('DB_NAME') . $charset . $socket;
            $db = new PDO($dsn, Config::get('DB_USER'), Config::get('DB_PASSWORD'));
            
            // Throw an Exception when an error occurs
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
         
        return $db;
    }

    /**
     * Convert searchterm for mysql "where like" query
     * 
     * @param string $string String to convert
     * @return string Converted string
     */
    protected static function whereLike($string) 
    {
        return '%' . $string . '%';
    }

    /**
     * Escape variables which can not be prepared to prevent sql injections
     * 
     * @param string $string String to ecscape
     * @return string Ecscape string
     */
    protected static function escapeVar($string) 
    {
        return "`" . str_replace("`", "", $string) . "`";
    }

    /**
     * Validate sort order to prevent sql injections
     * 
     * @param string $string String to validate
     * @return string Validate string
     */
    protected static function validateSortOrder($string) 
    {
        return $string == 'ASC' || $string == 'asc' || $string == 'DESC' || $string == 'desc' ? $string : 'ASC';
    }
}
