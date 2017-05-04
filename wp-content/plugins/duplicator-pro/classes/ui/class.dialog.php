<?php

/**
 * Inline Dialog:
 * Used to generate a thinkbox inline dialog.
 */
class DUP_PRO_Dialog
{
	//All Dialogs
	public $title;
	public $message;
	public $width;
	public $height;
	
	//Confirm Only
	public $progress_text;
	public $progress_on = true;
	public $jscallback;
	
	private $id;
	private $uniqid;
	
	public function __construct()  
	{
		add_thickbox(); 
		$this->progress_text = DUP_PRO_U::__('Processing please wait...');
		$this->uniqid = uniqid();
		$this->id = 'dpro-dlg-' . $this->uniqid;
	}
	
	
	/**
	 * Gets unique ID:
	 * Get the unique id that is assigned to each instance of a dialog
     *
     * @access public
     * @return int
     */
	public function get_id() 
	{
		return $this->id;
	}
	

	/**
	 * Init Alert:
	 * Initilizes the alert base html code used to display when needed
     *
     * @access public
     * @return string	The html content used for the alert dialog
     */
	public function init_alert() 
	{
		$ok	= DUP_PRO_U::__('OK');
		
		$html = <<<HTML
		<div id="{$this->id}" style="display:none">
			<div class="dpro-dlg-alert-txt">
				{$this->message}
				<br/><br/>
			</div>
			<div class="dpro-dlg-alert-btns">
				<input type="button" class="button button-large" value="{$ok}" onclick="tb_remove()" />
			</div>
		</div>		
HTML;
					
		echo $html;
	}
	
	
	/**
	 * Show Alert:
	 * Shows the alert base js code used to display when needed
     *
     * @access public
     * @return string	The javascript content used for the alert dialog
     */
	public function show_alert() 
	{
		$this->width  = is_numeric($this->width)  ? $this->width  : 475;
		$this->height = is_numeric($this->height) ? $this->height : 125;
		
		echo "tb_show('{$this->title}', '#TB_inline?width={$this->width}&height={$this->height}&inlineId={$this->id}');";
	}
	
	
	/**
	 * Init Confirm:
	 * Shows the confirm base js code used to display when needed
     *
     * @access public
     * @return string	The javascript content used for the confirm dialog
     */
	public function init_confirm() 
	{
		$ok			= DUP_PRO_U::__('OK');
		$cancel		= DUP_PRO_U::__('Cancel');
		
		$progress_data   = '';
		$progress_func2  = '';
		
		//Enable the progress spinner
		if ($this->progress_on)
		{
			$progress_func1   = "__dpro_dialog_" . $this->uniqid;						
			$progress_func2   = ";{$progress_func1}(this)";						
			$progress_data = <<<HTML
				<div class='dpro-dlg-confirm-progress'><i class='fa fa-circle-o-notch fa-spin fa-lg fa-fw'></i> {$this->progress_text}</div>
				<script> 
					function {$progress_func1}(obj) 
					{
						console.log(jQuery('#{$this->id}'));
						jQuery(obj).parent().parent().find('.dpro-dlg-confirm-progress').show();
						jQuery(obj).closest('.dpro-dlg-confirm-btns').find('input').attr('disabled', 'true');
					}
				</script>
HTML;
		}
		
		$html = <<<HTML
			<div id="{$this->id}" style="display:none">
				<div class="dpro-dlg-confirm-txt">
					{$this->message}
					<br/><br/>
					{$progress_data}
				</div>
				<div class="dpro-dlg-confirm-btns">
					<input type="button" class="button button-large" value="{$ok}" onclick="{$this->jscallback}{$progress_func2}" />
					<input type="button" class="button button-large" value="{$cancel}" onclick="tb_remove()" />
				</div>
			</div>		
HTML;
					
		echo $html;
	}

	
	/**
	 * Show Confirm:
	 * Shows the confirm base js code used to display when needed
     *
     * @access public
     * @return string	The javascript content used for the confirm dialog
     */
	public function show_confirm() 
	{
		$this->width  = is_numeric($this->width)  ? $this->width  : 500;
		$this->height = is_numeric($this->height) ? $this->height : 150;
		echo "tb_show('{$this->title}', '#TB_inline?width={$this->width}&height={$this->height}&inlineId={$this->id}');";
	}

}

