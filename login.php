<?php
include ('classes/interface.class.php');
$myInterface = new interface_(false);
if (!NEED_LOGIN) {
	header('location:./');
}
$myInterface->set_title("Authentification");
$myInterface->get_header();
?>
<form class="loginForm" method="post" action="verifierLogin.php">
<p><label>Identifiant</label><input class="autowidth" type="text" name="login" autofocus="autofocus" /></p>
<p><label>Mot de passe</label><input class="autowidth" type="password" name="pass" /></p>
<?php 
if(isset($_GET['erreur'])){
	echo '<span class="error">Identifiant ou mot de passe incorrect.</span>';
}
?>
<p><label>&nbsp;</label><input class="button green large" type="submit" name="submit" value="login" /></p>
</form>
<?php $myInterface->get_footer(); ?>
