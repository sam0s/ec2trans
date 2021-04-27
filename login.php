<style>
.head{
  background-color: lavender;
}
</style>
<div class="head">
  <b style="font-size: 32px;">User Control Panel</b>
  <hr>
  <br>
<?php
$allowedTags = "<br>,<b>,<i>,<hr>,<h3>,<h4>,<h5>";
include 'db_include.php';
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
session_start();
date_default_timezone_set('America/New_York');
$date = date('m-d-y h:i:s');

echo $date."<br>";

if(isset($_SESSION["message"])){
  echo $_SESSION["message"] . "<br>";
  $_SESSION["message"]=null;
}
if(isset($_SESSION["user"])){
echo "

Logged in as: ".$_SESSION["user"]." (USER_".$_SESSION["id"].") <br> <a href='index.php'> Home </a><br>
<a href='profile.php?profile=".$_SESSION["id"]."'> My Profile </a>
<br>
<a href='friends.php'> Friends </a>
<br>
<a href='messenger.php'> Inbox </a>
";

echo('
<form name="theform" action="fetch.php" method="post">
  <br>
  <input type="submit" id = "logout" name="submit" value="Logout">
  <br>
</form>
<hr>
');

}else{

  echo "<a href='index.php'> Home </a><br><br>";

  echo('
  <form name="theform" action="fetch.php" method="post">
    Username:
    <input id="user" name="user" type="text" size="40" required>
    <br>
    <br>
    Password:
    <input id="pass" name="pass" type="password" size="40">
    <br>
    <br>
    <input type="hidden" name="redr" value="'.$actual_link.'">
    <input type="submit" id="login" name="submit" value="Login">
    <input type="submit" id = "register" name="submit" value="Register">
    <br>
  </form>

  <hr>

');
}

$result = $db->query("SELECT COUNT(*) FROM Users WHERE LoggedIn=1;");
$uonline = $result->fetchArray()[0];

$result = $db->query("SELECT COUNT(*) FROM Users;");;
$utotal = $result->fetchArray()[0];

?>
</div>
<link rel="stylesheet" href="styles.css">
<span class="footer">
  <a href="users.php">Users Online: <?php echo $uonline ?>/<?php echo $utotal ?> </a>
</span>
<br>
