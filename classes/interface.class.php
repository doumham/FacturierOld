<?php
include('include/config.php');
class interface_{
	
	function interface_($needLogin = NEED_LOGIN){
		ini_set('session.name', "Factures");
		session_start();
		if (function_exists('date_default_timezone_set')) {
			date_default_timezone_set(TIME_ZONE);
		}
		setlocale(LC_TIME, COUNTRY_CODE);
		if(isset($needLogin) && $needLogin == true && NEED_LOGIN && !isset($_SESSION['login'])){
			header('location:login.php');
		}
	}
	
	function get_header($page = ''){
		if (!isset($this->title) && empty($this->title)) {
			$this->title = 'Untitled page';
		}
		$return = '<!DOCTYPE html>'."\r";
		$return .= '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">'."\r";
		$return .= '<head>'."\r";
		$return .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'."\r";
		$return .= '<title>'.$this->title.'</title>'."\r";
		// CSS
		$return .= '<link type="text/css" href="css/master.css" rel="stylesheet" media="screen"	/>'."\r";
		$return .= '<link type="text/css" href="plugins/jquery-ui/css/smoothness/jquery-ui-'.JQUERY_UI_VERSION.'.custom.css" rel="stylesheet" media="screen" />'."\r";
		$return .= '<link type="text/css" href="plugins/jGrowl/jquery.jgrowl.css" rel="stylesheet" media="screen" />'."\r";
		$return .= '<link type="text/css" href="css/print.css" rel="stylesheet" media="print" />'."\r";
		// Javascript
		$return .= '<script type="text/javascript" src="plugins/jquery-ui/js/jquery-'.JQUERY_VERSION.'.min.js"></script>'."\r";
		$return .= '<script type="text/javascript" src="plugins/jquery-ui/js/jquery-ui-'.JQUERY_UI_VERSION.'.custom.min.js"></script>'."\r";
		$return .= '<script type="text/javascript" src="plugins/jquery-form.js"></script>'."\r";
		$return .= '<script type="text/javascript" src="plugins/jGrowl/jquery.jgrowl_minimized.js"></script>'."\r";
		$return .= '<script type="text/javascript" src="js/functions.js"></script>'."\r";
		// Meta Description - Keywords - Author
		$return .= '<meta name="author" content="Samuel De Backer @ Typi Design 2007 info(at)typidesign(dot)be" />'."\r";
		$return .= '<meta name="description" lang="fr" content="Facturier, logiciel de facturation en PHP/MySQL." />'."\r";
		$return .= '</head>'."\r";
		$return .= '<body class="'.$page.'">'."\r";
		// div header
		$return .= '<div id="header">'."\r";
		$return .= '	<h1>'."\r";
		$return .= '		<a href="index.php">Facturier <span class="version">v '.FACTURIER_VERSION.'</span></a>'."\r";
		$return .= '	</h1>'."\r";
		if(!NEED_LOGIN || isset($_SESSION['login'])){
			$return .= '	<ul id="menu">'."\r";
			$return .= '		<li><a href="formUtilisateur.php?id=1" class="popup" title="Utilisateur">Utilisateur</a></li>'."\r";
			if(NEED_LOGIN){
				$return .= '		<li><a href="seDeconnecter.php" title="Déconnexion">Déconnexion</a></li>'."\r";
			}
			$return .= '	</ul>'."\r";
		}
		$return .= '</div>';
		echo $return;
	}
	
	function get_footer(){
		$return = '	</body>'."\r";
		$return .= '</html>'."\r";
		echo $return;
	}

	function truncate($string, $longueur, $etc="…")
	{
		$string=strip_tags(html_entity_decode($string));
		if(strlen($string)<=$longueur) {
			return $string;
		}
		$str=substr($string,0,$longueur-strlen($etc)+1);
		return substr($str,0,strrpos($str,' ')).$etc;
	}
	
	function set_title($title=""){
		$this->title = $title;
	}
	
}
?>