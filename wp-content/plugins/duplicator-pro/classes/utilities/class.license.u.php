<?php
/*
  Duplicator Pro Plugin
  Copyright (C) 2016, Snap Creek LLC
  website: snapcreek.com

  Duplicator Pro Plugin is distributed under the GNU General Public License, Version 3,
  June 2007. Copyright (C) 2007 Free Software Foundation, Inc., 51 Franklin
  St, Fifth Floor, Boston, MA 02110, USA

  THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
  ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
  WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
  DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
  ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
  (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
  LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
  ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
  (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
  SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

require_once(dirname(__FILE__) . '/../class.constants.php');

if (!class_exists('DUP_PRO_License_Activation_Response'))
{

    /**
     * @copyright 2016 Snap Creek LLC
     */
    abstract class DUP_PRO_License_Activation_Response
    {        
        const OK = 0;
        const POST_ERROR = -1;
        const INVALID_RESPONSE = -2;
    }
}

if(!class_exists('DUP_PRO_License_Type'))
{
	abstract class DUP_PRO_License_Type
	{
		const Unlicensed = 0;
		const Personal = 1;
		const Freelancer = 2;
		const BusinessGold = 3;
	}
}

if (!class_exists('DUP_PRO_License_Utility'))
{

	/**
	 * @copyright 2016 Snap Creek LLC
	 */
	class DUP_PRO_License_Utility
	{
		// Pseudo constants
		public static $LicenseCacheTime;

		public static function init()
		{
			$hours = 336;	// 14 days
			self::$LicenseCacheTime = $hours * 3600;
		}

		public static function change_license_activation($activate)
		{
			$license = get_option(DUP_PRO_Constants::LICENSE_KEY_OPTION_NAME, '');

			if ($activate)
			{
				$api_params = array(
					'edd_action' => 'activate_license',
					'license' => $license,
					'item_name' => urlencode(EDD_DUPPRO_ITEM_NAME), // the name of our product in EDD,
					'url' => home_url()
				);
			}
			else
			{
				$api_params = array(
					'edd_action' => 'deactivate_license',
					'license' => $license,
					'item_name' => urlencode(EDD_DUPPRO_ITEM_NAME), // the name of our product in EDD,
					'url' => home_url()
				);
			}

			// Call the custom API.
			global $wp_version;

			$agent_string = "WordPress/" . $wp_version;

			DUP_PRO_U::log("Wordpress agent string $agent_string");

			$response = wp_remote_post(EDD_DUPPRO_STORE_URL, array('timeout' => 15, 'sslverify' => false, 'user-agent' => $agent_string, 'body' => $api_params));

			// make sure the response came back okay
			if (is_wp_error($response))
			{
				if ($activate)
				{
					$action = 'activating';
				}
				else
				{
					$action = 'deactivating';
				}

				DUP_PRO_U::log_object("Error $action $license", $response);

				return DUP_PRO_License_Activation_Response::POST_ERROR;
			}

			$license_data = json_decode(wp_remote_retrieve_body($response));

			if ($activate)
			{
				// decode the license data                
				if ($license_data->license == 'valid')
				{
					DUP_PRO_U::log("Activated license $license");

					return DUP_PRO_License_Activation_Response::OK;					
				}
				else
				{
					DUP_PRO_U::log_object("Problem activating license $license", $license_data);
					return DUP_PRO_License_Activation_Response::INVALID_RESPONSE;
				}
			}
			else
			{
				// check that license:deactivated and item:Duplicator Pro json
				if ($license_data->license == 'deactivated')
				{
					DUP_PRO_U::log("Deactivated license $license");
					return DUP_PRO_License_Activation_Response::OK;
				}
				else
				{
					// problems activating
					//update_option('edd_sample_license_status', $license_data->license);
					DUP_PRO_U::log_object("Problems deactivating license $license", $license_data);
					return DUP_PRO_License_Activation_Response::INVALID_RESPONSE;
				}
			}
		}

		public static function get_license_status($force_refresh)
		{
			/* @var $global DUP_PRO_Global_Entity */
			$global = DUP_PRO_Global_Entity::get_instance();

			$initial_status = $global->license_status;

			if ($force_refresh === false)
			{
				if (time() > $global->license_expiration_time)
				{
					DUP_PRO_U::log("Uncaching license because current time = " . time() . " and expiration time = {$global->license_expiration_time}");
					$global->license_status = DUP_PRO_License_Status::Uncached;
				}
			}
			else
			{
				DUP_PRO_U::log("forcing live license update");
				$global->license_status = DUP_PRO_License_Status::Uncached;
			}
			
			if($global->license_limit == -1)
			{
				$global->license_status = DUP_PRO_License_Status::Uncached;
			}

			if ($global->license_status == DUP_PRO_License_Status::Uncached)
			{
				DUP_PRO_U::log("retrieving live license status");
				$store_url = 'https://snapcreek.com';
				$item_name = 'Duplicator Pro';
				$license_key = get_option(DUP_PRO_Constants::LICENSE_KEY_OPTION_NAME, '');

				if ($license_key != '')
				{
					$api_params = array(
						'edd_action' => 'check_license',
						'license' => $license_key,
						'item_name' => urlencode($item_name),
						'url' => home_url()
					);
					
					global $wp_version;
					$agent_string = "WordPress/" . $wp_version;

					$response = wp_remote_post($store_url, array('timeout' => 15, 'sslverify' => false, 'user-agent' => $agent_string, 'body' => $api_params));

					if (is_wp_error($response))
					{
						$global->license_status = $initial_status;
						DUP_PRO_U::log("Error getting license check response for $license_key so leaving status alone");
					}
					else
					{
						$license_data = json_decode(wp_remote_retrieve_body($response));

						DUP_PRO_U::log_object("license data returned", $license_data);
						
						$global->license_status = self::get_license_status_from_string($license_data->license);

						$global->license_no_activations_left = false;
						$global->license_limit = $license_data->license_limit;
	
						if(($global->license_status == DUP_PRO_License_Status::Site_Inactive) && ($license_data->activations_left === 0))
						{
							$global->license_no_activations_left = true;
						}
						
						if ($global->license_status == DUP_PRO_License_Status::Unknown)
						{
							DUP_PRO_U::log("Problem retrieving license status for $license_key");
						}
					}
				}
				else
				{
					$global->license_limit = -1;
					$global->license_status = DUP_PRO_License_Status::Invalid;
					$global->license_no_activations_left = false;
				}

				$global->license_expiration_time = time() + self::$LicenseCacheTime;

				$global->save();

				DUP_PRO_U::log("Set cached value from with expiration " . self::$LicenseCacheTime . " seconds from now ({$global->license_expiration_time})");
			}

			return $global->license_status;
		}

		private static function get_license_status_from_string($license_status_string)
		{
			switch ($license_status_string)
			{
				case 'valid':
					return DUP_PRO_License_Status::Valid;
					break;

				case 'invalid':
					return DUP_PRO_License_Status::Invalid;

				case 'expired':
					return DUP_PRO_License_Status::Expired;

				case 'disabled':
					return DUP_PRO_License_Status::Disabled;

				case 'site_inactive':
					return DUP_PRO_License_Status::Site_Inactive;

				case 'expired':
					return DUP_PRO_License_Status::Expired;

				default:
					return DUP_PRO_License_Status::Unknown;
			}
		}

		public static function get_license_status_string($license_status_string)
		{
			switch ($license_status_string)
			{
				case DUP_PRO_License_Status::Valid:
					return DUP_PRO_U::__('Valid');

				case DUP_PRO_License_Status::Invalid:
					return DUP_PRO_U::__('Invalid');

				case DUP_PRO_License_Status::Expired:
					return DUP_PRO_U::__('Expired');

				case DUP_PRO_License_Status::Disabled:
					return DUP_PRO_U::__('Disabled');

				case DUP_PRO_License_Status::Site_Inactive:
					return DUP_PRO_U::__('Site Inactive');

				case DUP_PRO_License_Status::Expired:
					return DUP_PRO_U::__('Expired');

				default:
					return DUP_PRO_U::__('Unknown');
			}
		}
		
		public static function get_license_type()
		{
			/* @var $global DUP_PRO_Global_Entity */
			$global = DUP_PRO_Global_Entity::get_instance();
			
			$license_type = DUP_PRO_License_Type::Personal;
			
			if($global->license_limit < 0)
			{
				$license_type = DUP_PRO_License_Type::Unlicensed;
			}
			else if($global->license_limit < 15)
			{
				$license_type = DUP_PRO_License_Type::Personal;
			}
			else if($global->license_limit < 500)
			{
				$license_type = DUP_PRO_License_Type::Freelancer;
			}
			else if($global->license_limit >= 500)
			{
				$license_type = DUP_PRO_License_Type::BusinessGold;
			}
			
			return $license_type;
		}

	}

	DUP_PRO_License_Utility::init();
}
?>