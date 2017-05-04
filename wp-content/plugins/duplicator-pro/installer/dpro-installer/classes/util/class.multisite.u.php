<?php
require_once(dirname(__FILE__) . '/class.db.u.php');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (!class_exists('DUPX_Multisite_U'))
{
	class DUPX_Multisite_U
	{
		public static function convert_subsite_to_standalone($subsite_id, $dbh, $base_prefix, $wp_content_dir)
		{
			DUPX_Log::Info("#### Convert subsite to standalone {$subsite_id}");
			self::make_subsite_database_standalone($subsite_id, $dbh, $base_prefix);
			self::make_subsite_files_standalone($subsite_id, $wp_content_dir);
		}

		private static function make_subsite_files_standalone($subsite_id, $wp_content_dir)
		{
			$success = true;

			$uploads_dir = $wp_content_dir . '/uploads';
			$uploads_sites_dir = $uploads_dir . '/sites';

			DUPX_Log::Info("#### Make subsite files standalone for {$subsite_id} in content dir {$wp_content_dir}");

			if ($subsite_id === 1)
			{
				try
				{
					DUPX_Log::Info("#### Since subsite is one deleting the entire upload sites dir");
					DUPX_U::del_directory($uploads_sites_dir, true);
				}
				catch (Exception $ex)
				{
					//RSR TODO: Technically it can complete but this should be brought to their attention more than just writing info
					DUPX_Log::Info("Problem deleting $uploads_sites_dir. {$ex->getMessage()}");
				}
			}
			else
			{
				$subsite_uploads_dir = "{$uploads_sites_dir}/{$subsite_id}";

				DUPX_Log::Info("#### Subsites uploads dir={$subsite_uploads_dir}");

				try
				{
					DUPX_Log::Info("#### Recursively deleting $uploads_dir except subdirectory sites");

					// Get a list of all files/subdirectories within the core uploads dir. For all 'non-sites' directories do a recursive delete. For all files, delete.

					$filenames = array_diff(scandir($uploads_dir), array('.', '..'));

					foreach ($filenames as $filename)
					{
						$full_path = "$uploads_dir/$filename";

						if (is_dir($full_path))
						{
							DUPX_Log::Info("#### Recursively deleting $full_path");
							if ($filename != 'sites')
							{
								DUPX_U::del_directory($full_path, true);
							}
							else
							{
								DUPX_Log::Info("#### Skipping $full_path");
							}
						}
						else
						{
							$success = @unlink($full_path);
						}
					}
				}
				catch (Exception $ex)
				{
					// Technically it can complete but this should be brought to their attention
					DUPX_Log::Error("Problem deleting $uploads_dir");
				}

				DUPX_Log::Info("#### Recursively copying {$subsite_uploads_dir} to {$uploads_dir}");
				// Recursively copy files in /wp-content/uploads/sites/$subsite_id to /wp-content/uploads
				DUPX_U::copy_directory($subsite_uploads_dir, $uploads_dir);

				try
				{
					DUPX_Log::Info("#### Recursively deleting $uploads_sites_dir");
					// Delete /wp-content/uploads/sites (will get rid of all subsite directories)					
					DUPX_U::del_directory($uploads_sites_dir, true);
				}
				catch (Exception $ex)
				{
					// Technically it can complete but this should be brought to their attention					
					DUPX_Log::Error("Problem deleting $uploads_sites_dir");
				}
			}
		}

		// If necessary, removes extra tables and renames
		public static function make_subsite_database_standalone($subsite_id, $dbh, $base_prefix)
		{
			DUPX_Log::Info("#### make subsite_database_standalone {$subsite_id}");

			self::purge_other_subsite_tables($subsite_id, $dbh, $base_prefix);
			self::purge_redundant_data($subsite_id, $dbh, $base_prefix);

			if ($subsite_id !== 1)
			{
				// RSR DO THIS??		self::copy_data_to_subsite_table($subsite_id, $dbh, $base_prefix);			
				self::rename_subsite_tables_to_standalone($subsite_id, $dbh, $base_prefix);
				//self::remove_usermeta_duplicates($dbh);
				// **RSR TODO COMPLICATION: How plugins running in single mode would behave when it was installed in multisite mode. Could be other data complications				
			}


			self::purge_multisite_tables($dbh, $base_prefix);

			return $success;
		}

		// Purge non_site where meta_key in wp_usermeta starts with data from other subsite or root site,
		private static function purge_redundant_data($retained_subsite_id, $dbh, $base_prefix)
		{
			$subsite_ids = self::get_subsite_ids($dbh, $base_prefix);
			$usermeta_table_name = "{$base_prefix}usermeta";

			/* -- Purge from usermeta data -- */
			foreach ($subsite_ids as $subsite_id)
			{
				$subsite_prefix = self::get_subsite_prefix($subsite_id, $base_prefix);

				$escaped_subsite_prefix = self::esc_sql($subsite_prefix);

				DUPX_Log::Info("#### purging redundant data. Considering {$subsite_prefix}");

				// RSR TODO: remove records that mention
				if ($subsite_id != $retained_subsite_id)
				{
					$sql = "DELETE FROM $usermeta_table_name WHERE meta_key like '{$escaped_subsite_prefix}%'";

					DUPX_Log::Info("#### {$subsite_id} != {$retained_subsite_id} so executing {$sql}");

					DUPX_DB_U::query_noreturn($dbh, $sql);

					//$sql = "SELECT * FROM $usermeta_table_name WHERE meta_key like '{$escaped_subsite_prefix}%'";
					//DUPX_Log::Info("#### {$subsite_id} != {$retained_subsite_id} so executing {$sql}");				
					//$ret_val = DUPX_DB_U::query_to_array($dbh, $sql);
					//DUPX_Log::Info("#### return value = " . print_r($ret_val, true));													
				}
			}

			// RSR: No longer deleting base prefix since user capability related stuff is here
			// Need to ONLY delete the base prefix stuff not the subsite prefix stuff
			if ($retained_subsite_id != 1)
			{
				$retained_subsite_prefix = self::get_subsite_prefix($retained_subsite_id, $base_prefix);

				$escaped_base_prefix = self::esc_sql($base_prefix);
				$escaped_retained_subsite_prefix = self::esc_sql($retained_subsite_prefix);

				//	$sql = "DELETE FROM $usermeta_table_name WHERE meta_key LIKE '$escaped_base_prefix%' AND meta_key NOT LIKE '$escaped_retained_subsite_prefix%'";
				//	DUPX_Log::Info("#### Subsite {$retained_subsite_id} != 1 so deleting all data with base_prefix and not like retained prefix. SQL= {$sql}");
				//	DUPX_DB_U::query_noreturn($dbh, $sql);
			}
		}

//		private static function copy_data_to_subsite_table($subsite_id, $dbh, $base_prefix)
//		{
//			// Read values from options table and stuff into the subsite options table
//			$subsite_prefix = "{$base_prefix}{$subsite_id}_";
//			
//			$subsite_options_table = "{$subsite_prefix}options";
//			$standard_options_table = "{$base_prefix}options";
//			
//			// RSR TODO: BUT have to make sure we don't overwrite anything since want the subsite table to take precident
//			$sql = "INSERT INTO {$subsite_options_table} (option_name, option_value, autoload) SELECT option_name, option_value, autoload FROM {$standard_options_table};";
//			
//			DUPX_DB_U::query_noreturn($dbh, $sql);
//		}

		private static function get_subsite_prefix($subsite_id, $base_prefix)
		{
			return "{$base_prefix}{$subsite_id}_";
		}

		private static function get_subsite_ids($dbh, $base_prefix)
		{
			// Note: Can ignore the site_id field since WordPress never implemented multiple network capability and site_id is really network_id and blog_id is subsite_id.
			$query = "SELECT blog_id from {$base_prefix}blogs";
			$subsite_ids = DUPX_DB_U::query_column_to_array($dbh, $query);

			return $subsite_ids;
		}

		private static function mysqldb_escape_mimic($inp)
		{
			if (is_array($inp))
				return array_map(__METHOD__, $inp);

			if (!empty($inp) && is_string($inp))
			{
				return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp);
			}

			return $inp;
		}

		private static function esc_sql($sql)
		{
			$sql = addcslashes($sql, "%_");

			$sql = self::mysqldb_escape_mimic($sql);

			return $sql;
			//return str_replace('_', "\\_", $sql);
			//	return str_replace(array($e, '_', '%'), array($e.$e, $e.'_', $e.'%'), $s);
		}

		// Purge all subsite tables other than the one indicated by $retained_subsite_id
		private static function purge_other_subsite_tables($retained_subsite_id, $dbh, $base_prefix)
		{
			$common_table_names = array('commentmeta', 'comments', 'links', 'options', 'postmeta', 'posts', 'terms', 'term_relationships', 'term_taxonomy');

			$subsite_ids = self::get_subsite_ids($dbh, $base_prefix);

			$escaped_base_prefix = self::esc_sql($base_prefix);

			DUPX_Log::Info("#### retained subsite id={$retained_subsite_id}");
			DUPX_Log::Info("#### subsite ids=" . print_r($subsite_ids, true));

			// Purge all tables belonging to other subsites
			foreach ($subsite_ids as $subsite_id)
			{
				if (($subsite_id != $retained_subsite_id) && ($subsite_id > 1))
				{
					DUPX_Log::Info("#### deleting subsite $subsite_id");
					$subsite_prefix = "{$base_prefix}{$subsite_id}_";

					$escaped_subsite_prefix = self::esc_sql($subsite_prefix);

					DUPX_Log::Info("#### subsite prefix {$subsite_prefix} escaped prefix={$escaped_subsite_prefix}");

					$subsite_table_names = DUPX_DB_U::query_column_to_array($dbh, "SHOW TABLES LIKE '{$escaped_subsite_prefix}%'");

					DUPX_Log::Info_Object("#### subsite table names for $subsite_id", $subsite_table_names);

					//foreach($common_table_names as $common_table_name)
					foreach ($subsite_table_names as $subsite_table_name)
					{
						//$subsite_table_name = "{$subsite_prefix}{$common_table_name}";

						DUPX_Log::Info("#### subsite table name $subsite_prefix");
						try
						{
							DUPX_DB_U::drop_table($dbh, $subsite_table_name);
						}
						catch (Exception $ex)
						{
							//RSR TODO Non catostrophic but should be brought to their attention - put in final report
							DUPX_LOG::Info("Error dropping table $subsite_table_name");
						}
					}
				}
				else
				{
					DUPX_Log::Info("#### skipping subsite $subsite_id");
				}
			}

			if ($retained_subsite_id != 1)
			{
				// If we are dealing with anything other than the main subsite then we need to purge its core tables
				foreach ($common_table_names as $common_table_name)
				{
					$subsite_table_name = "$base_prefix$common_table_name";

					DUPX_DB_U::drop_table($dbh, $subsite_table_name);
				}
			}
		}

		// Purge all subsite tables other than the one indicated by $retained_subsite_id
		private static function purge_multisite_tables($dbh, $base_prefix)
		{
			$multisite_table_names = array('blogs', 'blog_versions', 'registration_log', 'signups', 'site', 'sitemeta');

			// Remove multisite specific tables
			foreach ($multisite_table_names as $multisite_table_name)
			{
				$full_table_name = "$base_prefix$multisite_table_name";

				try
				{
					DUPX_DB_U::drop_table($dbh, $full_table_name);
				}
				catch (Exception $ex)
				{
					//RSR TODO Non catostrophic but should be brought to their attention - put in final report
					DUPX_LOG::Info("Error dropping table $full_table_name");
				}
			}
		}

		// Convert subsite tables to be standalone by proper renaming (both core and custom subsite table)
		public static function rename_subsite_tables_to_standalone($subsite_id, $dbh, $base_prefix)
		{
			// For non-main subsite we need to move around some tables and files
			$subsite_prefix = "{$base_prefix}{$subsite_id}_";

			$escaped_subsite_prefix = self::esc_sql($subsite_prefix);

			$all_table_names = DUPX_DB_U::query_column_to_array($dbh, "SHOW TABLES");
			$subsite_table_names = DUPX_DB_U::query_column_to_array($dbh, "SHOW TABLES LIKE '{$escaped_subsite_prefix}%'");

			DUPX_Log::Info("####rename subsite tables to standalone. table names = " . print_r($subsite_table_names, true));

			foreach ($subsite_table_names as $table_name)
			{
				DUPX_Log::Info("####considering table $table_name");
				$new_table_name = str_replace($subsite_prefix, $base_prefix, $table_name);

				DUPX_Log::Info("####does $new_table_name exist?");
				if (DUPX_DB_U::table_exists($dbh, $new_table_name, $all_table_names))
				{
					DUPX_Log::Info("####yes it does");
					// If a table with that name already exists just back it up					
					$backup_table_name = "{$new_table_name}_orig";

					DUPX_Log::Info("A table named $new_table_name already exists so renaming to $backup_table_name.");

					DUPX_DB_U::rename_table($dbh, $new_table_name, $backup_table_name, true);
				}
				else
				{
					DUPX_Log::Info("####no it doesn't");
				}

				DUPX_DB_U::rename_table($dbh, $table_name, $new_table_name);
				DUPX_Log::Info("####renamed $table_name $new_table_name");
			}
		}

		private static function remove_usermeta_duplicates($dbh)
		{
			// RSR TODO: Remove duplicate user meta data
			throw new Exception("Not implemented yet.");
		}

	}

}