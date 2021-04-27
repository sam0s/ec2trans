

<?php

include 'login.php';
?>

<div>
<?php

error_reporting(E_ALL ^ E_WARNING);

$result = $db->query("SELECT LoggedIn,Username,Created,LastLogin,Logins,ID FROM Users;");

while($row = $result->fetchArray()){
  $status = $row[0]==1?"ONLINE":"OFFLINE";
  $colr = $status == "ONLINE"?'green':'red';
  echo '<a href="profile.php?profile='.$row[5].'">'.$row[1]."</a> (User since ".$row[2].') <i style="color:'.$colr.'">'.$status.'</i> <br>';
}

?>
</div>
