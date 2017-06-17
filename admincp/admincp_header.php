<?php
require_once('../Connections/cnn_hoaly.php');
mysql_select_db($database_cnn_hoaly, $cnn_hoaly);
?>

<?php
session_start();
$user = $_SESSION['user'];
$idUser = (int) $user['ID_account'];

$strQuery = "SELECT * FROM account WHERE ID_account = {$idUser}";
$query = mysql_query($strQuery);

$userDetail = mysql_fetch_assoc($query);

if ($userDetail['accesslevel'] != 1) {
    header('Location: ../index.php');
}
?>
<div class="logo">
    <a href="admincp.php" target="_self"><img src="../images/logo.png" alt="Hoa Ly's Eyelash" width="50px"></a>
    <span class="logonotes"> - Content Management System</span>
</div>
<div class="headerlogout"><span class="hello">Hello,  <?php echo $_SESSION['kt_login_user'] ?></span>&nbsp;&nbsp;&nbsp;<a href="logout.php?logout=1" target="_self"><i class="fa fa-sign-out" aria-hidden="true"></i></a></div>
<div class="banner"><img src="p7csspbm2/img/pbm-mast.jpg" alt=""></div>