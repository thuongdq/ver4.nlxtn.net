<?php
if (!defined('DUPLICATOR_PRO_VERSION')) exit; // Exit if accessed directly

/**
 * Lightweight abstraction layer for common simple database routines
 *
 * Standard: PSR-2
 *
 * @package SC\DupPro\DB
 *
 */

class DUP_PRO_DB
{

    /**
     * Get the requested MySQL system variable
     *
     * @param string $variable The database variable name to lookup
     *
     * @return string the server variable to query for
     */
    public static function mysqlVariable($variable)
    {
        global $wpdb;
        $row = $wpdb->get_row("SHOW VARIABLES LIKE '{$variable}'", ARRAY_N);
        return isset($row[1]) ? $row[1] : null;
    }

    /**
     * Gets the MySQL database version number
     *
     * @param bool $full    True:  Gets the full version if availibe i.e 10.2.3-MariaDB
     *                      False: Gets only the numeric portion i.e. 5.5.6 or 10.1.2 
     *
     * @return false|string 0 on failure, version number on success
     */
    public static function mysqlVersion($full = false)
    {
        if ($full) {
            $version = self::mysqlVariable('version');
        } else {
            $version = preg_replace('/[^0-9.].*/', '', self::mysqlVariable('version'));
        }

        return empty($version) ? 0 : $version;
    }
}