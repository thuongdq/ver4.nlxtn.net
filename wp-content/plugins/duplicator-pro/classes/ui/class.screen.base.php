<?php

/**
 * Base Screen Class:
 * The base class for all screen.php files.  This class is used to control items that are common
 * among all screens, namely the Help tab and Screen Options drop down items.  When creating a 
 * screen object please extent this class.
 */
class DUP_PRO_Screen
{
	
	public $screen;
	
	public function __construct() {
        
    }
	
	/**
	 * Gets Help Support:
	 * Get the help support tab view content shown in the help system
     *
	 * @param string $guide		The target url to navigate to on the online user guide
	 * @param string $faq		The target url to navigate to on the online user tech faq
	 * 
     * @access public
     * @return null
     */
	public function get_support_tab($guide, $faq) 
	{
		$content  = DUP_PRO_U::__("<b>Need Help?</b>  Please check out these resources first:"
		. "<ul>"
		. "<li><a href='https://snapcreek.com/duplicator/docs/guide{$guide}' target='_sc-faq'>Full Online User Guide</a></li>"
		. "<li><a href='https://snapcreek.com/duplicator/docs/faqs-tech{$faq}' target='_sc-faq'>Frequently Asked Questions</a></li>"
		. "</ul>"
		. "If the guide or FAQs don't have a solution please follow these instructions:"
		. "<ol>"
		. "<li>Go to Duplicator Pro » <a href='admin.php?page=duplicator-pro-settings'>Settings</a> » Debug » Enable Tracing and Save</li>"
		. "<li>Perform the action you had problems with such as 'Creating a Package'</li>"
		. "<li>Download the Trace Log in the lower right corner of this screen and attach it to your support ticket.</li></ul>"
		. "<a href='https://snapcreek.com/ticket/ticket.php' target='_sc-faq'>Existing Ticket</a> | "
		. "<a href='https://snapcreek.com/ticket/index.php?a=add' target='_sc-faq'>New Ticket</a>");
				
		$this->screen->add_help_tab( array(
				'id'        => 'dpro_help_tab_callback',
				'title'     => DUP_PRO_U::__('Support'),
				'content'  => "<p>{$content}</p>"
			)
		);
	}	
	
	
	/**
	 * Gets Help Support Sidebar:
	 * Get the help support side bar found in the right most part of the help system
     *
     * @access public
     * @return null
     */
	public function get_help_sidbar() 
	{
		$txt_title	= DUP_PRO_U::__("Resources");
		$txt_home	= DUP_PRO_U::__("Knowledge Base");
		$txt_guide	= DUP_PRO_U::__("Full User Guide");
		$txt_faq	= DUP_PRO_U::__("Technical FAQs");
		$this->screen->set_help_sidebar(
			"<div class='dpro-screen-hlp-info'><b>{$txt_title}:</b> <br/>"
			. "<i class='fa fa-home'></i> <a href='https://snapcreek.com/duplicator/docs/' target='_sc-home'>{$txt_home}</a> <br/>"
			. "<i class='fa fa-book'></i> <a href='https://snapcreek.com/duplicator/docs/guide/' target='_sc-guide'>{$txt_guide}</a> <br/>"
			. "<i class='fa fa-file-code-o'></i> <a href='https://snapcreek.com/duplicator/docs/faqs-tech/' target='_sc-faq'>{$txt_faq}</a></div>"
			
        );
	}
	
	

	
}


