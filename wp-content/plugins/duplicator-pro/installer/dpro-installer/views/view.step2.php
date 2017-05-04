<?php
	//-- START OF VIEW STEP 2
	
	$_POST['dbaction']	= isset($_POST['dbaction'])		? $_POST['dbaction']	 : 'create';
	$_POST['dbhost']	= isset($_POST['dbhost'])		? trim($_POST['dbhost']) : null;
	$_POST['dbname']	= isset($_POST['dbname'])		? trim($_POST['dbname']) : null;
	$_POST['dbuser']	= isset($_POST['dbuser'])		? trim($_POST['dbuser']) : null;
	$_POST['dbpass']	= isset($_POST['dbpass'])		? trim($_POST['dbpass']) : null;
	$_POST['dbport']	= isset($_POST['dbhost'])		? parse_url($_POST['dbhost'], PHP_URL_PORT) : 3306;
	$_POST['dbport']    = (! empty($_POST['dbport']))	? $_POST['dbport'] : 3306;
	$_POST['retain_config']	= isset($_POST['retain_config']) && $_POST['retain_config'] == 1 ? 1 : 0;
	
	$_POST['subsite-id'] = isset($_POST['subsite-id']) ? $_POST['subsite-id'] : -1;
			
	$dbh = @mysqli_connect($_POST['dbhost'], $_POST['dbuser'], $_POST['dbpass'], $_POST['dbname']);

	$all_tables     = DUPX_U::get_database_tables($dbh);
	$active_plugins = DUPX_U::get_active_plugins($dbh);
		
	$old_path = $GLOBALS['FW_WPROOT'];
	
	
	// RSR TODO: need to do the path too?
	
	$subsite_id = $_POST['subsite-id'];
	
	$new_path = DUPX_U::set_safe_path($GLOBALS['CURRENT_ROOT_PATH']);
	$new_path = ((strrpos($old_path, '/') + 1) == strlen($old_path)) ? DUPX_U::add_slash($new_path) : $new_path; 

?>

<script type="text/javascript">
	/** **********************************************
	* METHOD:  
	* Timeout (10000000 = 166 minutes) */
	DUPX.runUpdate = function() {
		
		//Validation
		var wp_username = $.trim($("#wp_username").val()).length || 0;
		var wp_password = $.trim($("#wp_password").val()).length || 0;
		
		if ( $.trim($("#url_new").val()) == "" )  {alert("The 'New URL' field is required!"); return false;}
		if ( $.trim($("#siteurl").val()) == "" )  {alert("The 'Site URL' field is required!"); return false;}
		if (wp_username >= 1 && wp_username < 4) {alert("The New Admin Account 'Username' must be four or more characters"); return false;}
		if (wp_username >= 4 && wp_password < 6) {alert("The New Admin Account 'Password' must be six or more characters"); return false;}
	
		var nonHttp = false;
		var failureText = '';

		/* IMPORTANT - not trimming the value for good - just in the check */
		$('input[name="search[]"]').each(function() {
		    var val = $(this).val();

		    if(val.trim() != "") {
				if(val.length < 3) {
					failureText = "Custom search fields must be at least three characters.";
				}

				if(val.toLowerCase().indexOf('http') != 0) {
					nonHttp = true;
				}
			}
		});

		$('input[name="replace[]"]').each(function() {
		    var val = $(this).val();
			if(val.trim() != "") {
				// Replace fields can be anything
				if(val.toLowerCase().indexOf('http') != 0) {
					nonHttp = true;
				}
			}
		});

		if(failureText != '') {
			alert(failureText);
			return false;
		}	

		if(nonHttp) {
			if(confirm('One or more custom search and replace strings are not URLs.  Are you sure you want to continue?') == false) {
				return false;
			}
		}

		$.ajax({
			type: "POST",
			timeout: 10000000,
			dataType: "json",			
			url: window.location.href,
			data: $('#s2-input-form').serialize(),
			beforeSend: function() {
				DUPX.showProgressBar();
				$('#s2-input-form').hide();
				$('#s2-result-form').show();
			},			
			success: function(data){ 
				if (typeof(data) != 'undefined' && data.step2.pass == 1) {
					$("#ajax-url_new").val($("#url_new").val());
					$("#ajax-json").val(escape(JSON.stringify(data)));
					setTimeout(function(){$('#s2-result-form').submit();}, 1000);
					$('#progress-area').fadeOut(1800);
				} else {
					DUPX.hideProgressBar();
				}
			},
			error: function(xhr) { 
				var status = "<b>server code:</b> " + xhr.status + "<br/><b>status:</b> " + xhr.statusText + "<br/><b>response:</b> " +  xhr.responseText;
				$('#ajaxerr-data').html(status);
				DUPX.hideProgressBar();
			}
		});
	};

	/** **********************************************
	* METHOD: Returns the windows active url */
	DUPX.getNewURL = function(id) {
		var filename= window.location.pathname.split('/').pop() || 'main.installer.php' ;
		
		var newVal =  window.location.href.split("?")[0];		
		newVal = newVal.replace("/" + filename, '');
		//newVal = newVal.replace('dpro-installer/', '');	
		var last_slash = newVal.lastIndexOf("/");
		console.log("newVal=" + newVal);
		console.log("last_slash=" + last_slash);
		
		newVal = newVal.substring(0, last_slash);
		console.log("newVal=" + newVal);	
		
		$("#" + id).val(newVal);
	};
	
	/** **********************************************
	* METHOD: Allows user to edit the package url  */
	DUPX.editOldURL = function() {
		var msg = 'This is the URL that was generated when the package was created.\n';
		msg += 'Changing this value may cause issues with the install process.\n\n';
		msg += 'Only modify  this value if you know exactly what the value should be.\n';
		msg += 'See "General Settings" in the WordPress Administrator for more details.\n\n';
		msg += 'Are you sure you want to continue?';
	
		if (confirm(msg)) {
			$("#url_old").removeAttr('readonly');
			$("#url_old").removeClass('readonly');
			$('#edit_url_old').hide('slow');
		}
	};
	
	/** **********************************************
	* METHOD: Allows user to edit the package path  */
	DUPX.editOldPath = function() {
		var msg = 'This is the SERVER URL that was generated when the package was created.\n';
		msg += 'Changing this value may cause issues with the install process.\n\n';
		msg += 'Only modify  this value if you know exactly what the value should be.\n';
		msg += 'Are you sure you want to continue?';
	
		if (confirm(msg)) {
			$("#path_old").removeAttr('readonly');
			$("#path_old").removeClass('readonly');
			$('#edit_path_old').hide('slow');
		}
	};
	
	var searchReplaceIndex = 1;

	/** **********************************************
	* METHOD: Adds a search and replace line         */
	DUPX.addSearchReplace = function() {
		
		$("#search-replace-table").append("<tr valign='top' id='search-" + searchReplaceIndex + "'>" +
				      	"<td style='width:80px;padding-top:20px'>Search</td>" + 
				      	"<td style='padding-top:20px'>" +
				      		"<input type='text' name='search[]' style='margin-right:5px' />" + 
				      		"<a href='javascript:DUPX.removeSearchReplace(" + searchReplaceIndex + ")' style='font-size:12px'>[remove]</a>" + 
				      	"</td>" +
				      "</tr>" +
		              	      "<tr valign='top' id='replace-" + searchReplaceIndex + "'>" + 
				      	"<td>Replace</td>" +
				      	"<td>" +
				      		"<input type='text' name='replace[]' />" + 
				      	"</td>" + 
				      "</tr> ");

		searchReplaceIndex++;
	};

	/** **********************************************
	* METHOD: Removes a search and replace line      */
	DUPX.removeSearchReplace = function(index) {

		$("#search-" + index).remove();		
		$("#replace-" + index).remove();		

	};
	
	/** **********************************************
	* METHOD: Go back on AJAX result view */
	DUPX.hideErrorResult2 = function() {
		$('#s2-result-form').hide();			
		$('#s2-input-form').show(200);
	};
	
	//DOCUMENT LOAD
	$(document).ready(function() {
		<?php  echo strlen($GLOBALS['FW_URL_NEW']) ? "" : "DUPX.getNewURL('url_new');" ?>
		DUPX.getNewURL('siteurl');
		
		$("#wp_password").passStrength({
				shortPass: 		"top_shortPass",
				badPass:		"top_badPass",
				goodPass:		"top_goodPass",
				strongPass:		"top_strongPass",
				baseStyle:		"top_testresult",
				userid:			"#wp_username",
				messageloc:		1	});
	});
</script>


<!-- =========================================
VIEW: STEP 2- INPUT -->
<form id='s2-input-form' method="post" class="content-form">
	<input type="hidden" name="view_action"	 value="update" />
	<input type="hidden" name="view"		 value="update" />
	<input type="hidden" name="logging"		 value="<?php echo $_POST['logging'] ?>" />
	<input type="hidden" name="json"		 value="<?php echo $_POST['json']; ?>" />
	<input type="hidden" name="dbhost"		 value="<?php echo $_POST['dbhost'] ?>" />
	<input type="hidden" name="dbuser" 		 value="<?php echo $_POST['dbuser'] ?>" />
	<input type="hidden" name="dbpass" 		 value="<?php echo htmlentities($_POST['dbpass']) ?>" />
	<input type="hidden" name="dbname" 		 value="<?php echo $_POST['dbname'] ?>" />
	<input type="hidden" name="dbcharset" 	 value="<?php echo $_POST['dbcharset'] ?>" />
	<input type="hidden" name="dbcollate" 	 value="<?php echo $_POST['dbcollate'] ?>" />
	<input type="hidden" name="retain_config" 	 value="<?php echo $_POST['retain_config'] ?>" />
	<input type="hidden" name="subsite-id"   value="<?php echo $_POST['subsite-id'] ?>" />
	
	<div class="logfile-link"><a href="../installer-log.txt" target="_blank">installer-log.txt</a></div>
	<div class="hdr-main">Step 2: Update Files &amp; Database</div>
	
	<?php
		if ($_POST['dbaction'] == 'manual') {
			echo '<div class="dup-notice s2-manaual-msg">Manual SQL execution is enabled</div>';
		}
	?>

	<div class="hdr-sub">Old Settings</div>
	<table class="s2-opts">
		<tr valign="top">
			<td style="width:80px">URL</td>
			<td>
				<input type="text" name="url_old" id="url_old" value="<?php echo $GLOBALS['FW_URL_OLD'] ?>" readonly="readonly"  class="readonly" />
				<a href="javascript:DUPX.editOldURL()" id="edit_url_old" style="font-size:12px">edit</a>		
			</td>
		</tr>
		<tr valign="top">
			<td>Path</td>
			<td>
				<input type="text" name="path_old" id="path_old" value="<?php echo $old_path ?>" readonly="readonly"  class="readonly" />
				<a href="javascript:DUPX.editOldPath()" id="edit_path_old" style="font-size:12px">edit</a>		
			</td>
		</tr>
	</table>

	<div class="hdr-sub" style="margin-top:8px">New Settings</div>
	<table class="s2-opts">		
		<tr>
			<td>URL</td>
			<td>
				<input type="text" name="url_new" id="url_new" value="<?php echo $GLOBALS['FW_URL_NEW'] ?>" />
				<a href="javascript:DUPX.getNewURL('url_new')" style="font-size:12px">get</a>
			</td>
		</tr>
		<tr>
			<td>Path</td>
			<td><input type="text" name="path_new" id="path_new" value="<?php echo $new_path ?>" /></td>
		</tr>	
		<tr>
			<td>Title</td>
			<td><input type="text" name="blogname" id="blogname" value="<?php echo $GLOBALS['FW_BLOGNAME'] ?>" /></td>
		</tr>
	</table><br/>
	
	<!-- =========================
	SEARCH AND REPLACE -->
	<a href="javascript:void(0)" onclick="$('#s2-custom-replace').toggle(0);"><b style="font-size:14px">Custom Replace...</b></a>
	<div id='s2-custom-replace' style="display:none;">
		<table class="s2-opts" id="search-replace-table">
			<tr valign="top" id="search-0">
				<td>Search</td>
				<td><input type="text" name="search[]" style="margin-right:5px"></td>
			</tr>
			<tr valign="top" id="replace-0"><td>Replace</td><td><input type="text" name="replace[]"></td></tr>			
		</table>
		<button type="button" onclick="DUPX.addSearchReplace();return false;" style="font-size:12px;display: block; margin: 10px 0 0 0; ">Add More</button>		
	</div>
	<br/><br/>		
		
	<!-- ==========================
    ADVANCED OPTIONS -->
	<a href="javascript:void(0)" onclick="$('#s2-adv-opts').toggle(0)"><b style="font-size:14px">Advanced Options...</b></a>
	<div id='s2-adv-opts' style="display:none;">	
	<br/>
	
		<div class="hdr-sub">Add New Admin Account</div>
		<table class="s2-opts" style="margin-top:7px">
			<tr><td colspan="2"><i style="color:gray;font-size: 11px">This feature is optional.  If the username already exists the account will NOT be created or updated.</i></td></tr>
			<tr>
				<td>Username </td>
				<td><input type="text" name="wp_username" id="wp_username" value="" title="4 characters minimum" placeholder="(4 or more characters)" /></td>
			</tr>	
			<tr>
				<td>Password</td>
				<td><input type="text" name="wp_password" id="wp_password" value="" title="6 characters minimum"  placeholder="(6 or more characters)" /></td>
			</tr>
		</table>
		<br/><br/>
		
		<div class="hdr-sub">Scan Options</div>
		<table style="width: 100%;">
			<tr>
				<td style="width:105px">Update Site URL</td>
				<td style="white-space: nowrap">
					<input type="text" name="siteurl" id="siteurl" value="" />
					<a href="javascript:DUPX.getNewURL('siteurl')" style="font-size:12px">get</a><br/>
				</td>
			</tr>
		</table><br/>

		<table>
			<tr>
				<td style="padding-right:10px">
					Scan Tables
					<div class="s2-allnonelinks">
						<a href="javascript:void(0)" onclick="$('#tables option').prop('selected',true);">[All]</a> 
						<a href="javascript:void(0)" onclick="$('#tables option').prop('selected',false);">[None]</a>
					</div><br style="clear:both" />
					<select id="tables" name="tables[]" multiple="multiple" style="width:315px; height:100px">
						<?php
						foreach( $all_tables as $table ) {
							echo '<option selected="selected" value="' . DUPX_U::esc_html_attr( $table ) . '">' . $table . '</option>';
						} 
						?>
					</select>

				</td>
				<td valign="top">
					Activate Plugins
					<div class="s2-allnonelinks">
						<a href="javascript:void(0)" onclick="$('#plugins option').prop('selected',true);">[All]</a> 
						<a href="javascript:void(0)" onclick="$('#plugins option').prop('selected',false);">[None]</a>
					</div><br style="clear:both" />
					<select id="plugins" name="plugins[]" multiple="multiple" style="width:315px; height:100px">
						<?php
						$selected_string = ($subsite_id > 0) ? '' : 'selected="selected"';
						
						foreach ($active_plugins as $plugin) {
							echo "<option {$selected_string} value='" . DUPX_U::esc_html_attr( $plugin ) . "'>" . dirname($plugin) . '</option>';
						} 
						?>
					</select>
				</td>
			</tr>							
		</table><br/>
		
		<input type="checkbox" name="postguid" id="postguid" value="1" /> <label for="postguid">Keep Post GUID unchanged</label><br/>
		<input type="checkbox" name="fullsearch" id="fullsearch" checked value="1" /> <label for="fullsearch">Enable Full Search <small>(very slow)</small> </label><br/>
		
	</div>
	<br/><br/><br/><br/>	
	
	
	<div class="footer-buttons">
		<input id="s2-next" type="button" value=" Run Update " onclick="DUPX.runUpdate()"  />
	</div>	
</form>

<!-- =========================================
VIEW: STEP 2 - AJAX RESULT  -->
<form id='s2-result-form' method="post" class="content-form" style="display:none">
	<input type="hidden" name="view"  value="test" />
	<!-- Set via jQuery -->
	<input type="hidden" name="url_new" id="ajax-url_new"  />
	<input type="hidden" name="json"    id="ajax-json" />	
	<input type="hidden" name="subsite-id" id="subsite-id" value="<?php echo $subsite_id; ?>" />	
	
	<div class="logfile-link"><a href="../installer-log.txt" target="_blank">installer-log.txt</a></div>
	<div class="hdr-main">Step 2: Update Files &amp; Database</div>

	<!--  PROGRESS BAR -->
	<div id="progress-area">
		<div style="width:500px; margin:auto">
			<h3>Processing Data Replacement Please Wait...</h3>
			<div id="progress-bar"></div>
			<i>This may take several minutes</i>
		</div>
	</div>
	
	<!--  AJAX SYSTEM ERROR -->
	<div id="ajaxerr-area" style="display:none">
		<p>Please try again an issue has occurred.</p>
		<div style="padding: 0px 10px 10px 10px;">
			<div id="ajaxerr-data">An unknown issue has occurred with the data replacement setup process.  Please see the installer-log.txt file for more details.</div>
			<div style="text-align:center; margin:10px auto 0px auto">
				<input type="button" onclick='DUPX.hideErrorResult2()' value="&laquo; Try Again" /><br/><br/>
				<i style='font-size:11px'>See online help for more details at <a href='https://snapcreek.com' target='_blank'>snapcreek.com</a></i>
			</div>
		</div>
	</div>
</form>

<!-- END OF VIEW STEP 2 -->
