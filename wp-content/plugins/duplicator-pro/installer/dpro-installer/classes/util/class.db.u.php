<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (!class_exists('DUPX_DB_U'))
{
	class DUPX_DB_U
	{	
		public static function query_column_to_array($dbh, $sql, $column_index = 0)
		{		
			$result_array = array();
			
			$full_result_array = self::query_to_array($dbh, $sql);
			
			for($i = 0; $i < count($full_result_array); $i++)
			{
				$result_array[] = $full_result_array[$i][$column_index];
			}
			
			return $result_array;
		}
		
		public static function query_to_array($dbh, $sql)
		{
			$result = array();
			
			DUPX_Log::Info("calling mysqli query on $sql");
			$query_result = mysqli_query($dbh, $sql);
			
			if($query_result !== false)
			{				
				if (mysqli_num_rows($query_result) > 0)
				{
					while ($row = mysqli_fetch_row($query_result))
					{
						$result[] = $row;
					}
				}
			}
			else
			{
				$error = mysqli_error($dbh);
				
				throw new Exception("Error executing query {$sql}.<br/>{$error}");
			}
		
			return $result;
		}
		
		public static function query_noreturn($dbh, $sql)
		{
			$query_result = mysqli_query($dbh, $sql);
			
			if($query_result === false)
			{
				$error = mysqli_error($dbh);
				
				throw new Exception("Error executing query {$sql}.<br/>{$error}");
			}
		}
		
		public static function rename_table($dbh, $existing_name, $new_name, $delete_if_conflict)
		{
			if($delete_if_conflict)
			{
				if(self::table_exists($dbh, $new_name))
				{
					self::drop_table($dbh, $new_name);
				}
			}
			
			self::query_noreturn($dbh, "RENAME TABLE $existing_name TO $new_name");			
		}
		
		// If cached_table_names is null requery the database, otherwise use those for the list
		public static function table_exists($dbh, $table_name, $cached_table_names = null)
		{			
			if($cached_table_names === null)
			{
				// RSR TODO: retrieve full list of tables
				$cached_table_names = self::query_column_to_array($dbh, "SHOW TABLES");
			}
			
			return in_array($table_name, $cached_table_names);
		}
		
		public static function drop_table($dbh, $table_name)
		{		
			self::query_noreturn($dbh, "DROP TABLE IF EXISTS $table_name");
		}
	}
}