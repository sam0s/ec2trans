<?php
session_start();



date_default_timezone_set('America/New_York');
$date = date('m-d-y h:i:s');

class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('forumDB.db');
    }
}

$db = new MyDB();

$quser = $_POST['user'];
$qpass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
$uid = $_SESSION["id"];


if(isset($_POST['method']) && $_POST['method'] == "acceptF"){
  $aId=$_POST['acceptedF'];
  echo "AID ".$aId." ";
  echo "uid ".$uid." ";
  $db->query("UPDATE FriendLinks SET STATUS = 100 WHERE ID1 = $aId AND ID2=$uid;");
  exit();
}



if(isset($_POST['frq']) && $_POST['frq'] == "Send friend request"){
  $redr=$_POST['frqt'];
  if($_SESSION["signedin"] == false){
    header("Location: profile.php?profile=$redr&sent=-1");
    exit();
  }
  $db->query("INSERT into FriendLinks (ID1,ID2,STATUS) VALUES ($uid,$redr,0);");
  header("Location: profile.php?profile=$redr&sent=1");
  exit();
}

if(isset($_POST['submit']) && $_POST['submit'] == "Logout"){
  $db->query("UPDATE Users SET LoggedIn = 0 WHERE ID = '$uid';");
  session_destroy();
  session_start();
  $_SESSION["signedin"]=false;
  $_SESSION["message"] = "LOG OUT SUCCESS!";
  header("Location: index.php");
}

if(isset($_POST["addToCollection"]) && $_SESSION["signedin"] == true){
  $gid=$_POST["addToCollection"];
  $gname=$_POST["addToCollection_name"];
  $uid = $_SESSION["id"];
  $result = $db->query("INSERT INTO CollectionEntries (GameName, ID, BelongsTo, Added) VALUES ('$gname', '$gid', $uid, '$date');");
  echo($_POST["addToCollection"]);
  exit();
}

if(isset($_POST["removeFromCollection"]) && $_SESSION["signedin"] == true){
  $gid=$_POST["removeFromCollection"];
  $uid = $_SESSION["id"];
  $result = $db->query("DELETE FROM CollectionEntries WHERE BelongsTo=$uid AND ID=$gid;");
  exit();
}

if($_POST['submit'] == "Login"){

$result = $db->query("SELECT * FROM Users WHERE Username = '$quser';");
while ($row = $result->fetchArray()) {
    if(password_verify($_POST['pass'], $row[1])) {
      $_SESSION["message"] ="LOG IN SUCCESS FOR $quser!!";

      $db->query("UPDATE Users SET Logins = Logins+1,LastLogin = '$date',LoggedIn = 1 WHERE Username = '$quser';");

      $_SESSION["user"] = $row[0];
      $_SESSION["signedin"] = true;
      $_SESSION["id"] = $row[3];
      echo $quser;
      echo $_SESSION["id"];

    }
}
}

if($_POST['submit'] == "Register"){
  $quser = strip_tags($quser);
  if (!$result = $db->query("INSERT INTO Users (Username, Password, Logins, Created, LastLogin) VALUES ('$quser', '$qpass', 0,'$date','$date');")) {
    $_SESSION["message"] = "Couldn't register! Try a different username?";
}
else{
  $_SESSION["message"] = "<br> <b style='color:lime; background:black;'> REGISTER SUCCESSFUL FOR $quser!! </b> <br>";
}
}

?>
<?php header("Location: index.php"); ?>
