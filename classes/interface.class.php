<?php
class interface_{
  
	function interface_(){
	}
	
	function get_header(){
		include('include/config.php');
		ini_set('session.name', "Factures");
		session_start();
		setlocale(LC_TIME, COUNTRY_CODE);
		$return = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\r";
		$return .= "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"fr\" lang=\"fr\">\r";
		$return .= "<head>\r<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\r";
		$return .= "<title>".$this->title."</title>\r";
		// CSS
		$return .= "<link type=\"text/css\" href=\"css/master.css\" rel=\"stylesheet\" media=\"screen\"  />\r";
		$return .= "<link type=\"text/css\" href=\"css/ui-lightness/jquery-ui-".JQUERY_UI_VERSION.".custom.css\" rel=\"stylesheet\" media=\"screen\" />\r";
		$return .= "<link type=\"text/css\" href=\"css/print.css\" rel=\"stylesheet\" media=\"print\" />\r";
		// Icone
		$return .= "<link type=\"image/png\" href=\"images/favicon.png\" rel=\"shortcut icon\" />\r";
		// Javascript
		$return .= "<script type=\"text/javascript\" src=\"js/jquery-".JQUERY_VERSION.".min.js\"></script>\r";
		$return .= "<script type=\"text/javascript\" src=\"js/jquery-ui-".JQUERY_UI_VERSION.".custom.min.js\"></script>\r";
		$return .= "<script type=\"text/javascript\" src=\"js/jquery-form.js\"></script>\r";
	  $return .= "<script type=\"text/javascript\" src=\"js/functions.js\"></script>\r";
		// Meta Description - Keywords - Author
		$return .= "<meta name=\"author\" content=\"Samuel De Backer @ Typi Design 2007 info(at)typidesign(dot)be\" />\r";
		$return .= "<meta name=\"description\" lang=\"fr\" content=\"Facturier, logiciel de facturation en PHP/MySQL.\" />\r";
		$return .= "</head>\r";
		$return .= "<body>\r";
		echo $return;
	}
	
	function get_footer(){
    $return="  </body>\r";
    $return.="</html>\r";
		echo $return;
  }
  
  function set_title($title=""){
    $this->title = $title;
  }
  
}
?>