<!DOCTYPE html>
 <html lang="en">
 <head>
 <title>New Thread - samiscoolco forum</title>
 </head>
 <body>

<?php
include 'login.php';

$myPage = ($_SESSION['id'] == $_GET['profile']);

$p=$_GET['profile'];

$result = $db->query("SELECT * FROM Users WHERE ID = $p;")->fetchArray();
$name = ($result[0]);
$since = ($result[4]);
$pfpURL = ($result[7]);
$bio = ($result[8]);

if(!$myPage || !isset($_SESSION["user"])){
  header("Location: index.php");
  exit();
}

else{


  echo <<<EOD
  <div>
<h1>Edit profile</h1>
<form method="post" action="do_editprofile.php">
<p><label for="pfplink">Profile picture url:</label><br>
<input type="text" id="pfplink" name="pfplink" size="40" required="required" value="$pfpURL"></p>
<p><label for="biotext">User Bio:</label><br>
<textarea id="biotext" name="biotext" rows="8"
cols="40">$bio</textarea></p>
<button type="submit" name="submit" value="submit">Save</button>
</form>
<a href="profile.php?profile=$p">Cancel.</a>
</div>
EOD;


}



 ?>

 </body>
 </html>
