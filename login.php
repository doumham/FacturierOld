<?php
include ('classes/interface.class.php');
$myInterface = new interface_(false);
if (!NEED_LOGIN) {
	header('location:./');
}
$myInterface->set_title("Authentification");
$myInterface->get_header();
?>
<form style="background:#EEE;margin:100px;padding:30px;width:250px" method="post" action="verifierLogin.php">
<?php 
if(isset($_GET['erreur'])){
	echo "<span style='color:#bb2222'>Identifiant ou mot de passe incorrect.</span>";
}
?>
<p><label style="width:110px">Identifiant</label><input class="autowidth" type="text" name="login" autofocus="autofocus" /></p>
<p><label style="width:110px">Mot de passe</label><input class="autowidth" type="password" name="pass" /></p>
<p><label style="width:110px">&nbsp;</label><input class="autowidth" type="submit" name="submit" value="login" /></p>
</form>
<?php $myInterface->get_footer(); ?>