<?php
include 'login.php';
?>

<script>
function accept(id){
  xhttp = new XMLHttpRequest();
  var data=new FormData();
  data.append('method', 'acceptF');
  data.append('acceptedF', id);
  xhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    console.log(this.responseText);
  }
};
xhttp.open("POST", "fetch.php", true);
xhttp.send(data);
console.log(id);
location.reload(forceGet=true);
}
</script>
<div style = 'width:90%;'>
<center>
<h1> MESSAGES </h1>

<?php
$uid = $_SESSION["id"];
$mymessages = $db->query("SELECT * FROM Messages WHERE Receiver=$uid;");
echo "<table><tr><th colspan='2'>Messages</th><tr>";
while($msg = $mymessages->fetchArray()){
  $uName = $db->query("SELECT * FROM Users WHERE ID=$msg[0];")->fetchArray()[0];
  echo "<tr><td>From: <a href='profile.php?profile=$msg[0]'>$uName</a><br><b>Subject: $msg[2]</b><br>$msg[3]</td><td><a href='smsg.php?frm=$uid&to=$msg[0]'><button>Reply</button></a></td></tr>";
}
echo "</table>";
$myfriends = $db->query("SELECT * FROM FriendLinks WHERE STATUS = 100 and (ID2 = $uid OR ID1 = $uid);");

?>

<hr>
<h1> FRIEND LIST </h1>
<table>
<?php
echo "<tr><th colspan='2'>My Friends</th></tr>";
while($row = $myfriends->fetchArray()){
  $uName = $db->query("SELECT * FROM Users WHERE ID=$row[0];")->fetchArray();
  $fid=$row[0];
  if($row[0]==$uid){
    $uName = $db->query("SELECT * FROM Users WHERE ID=$row[1];")->fetchArray();
    $fid=$row[1];
  }
  echo "<tr><td><a href='profile.php?profile=$fid'>$uName[0]</a> </td><td><a href='smsg.php?frm=$uid&to=$fid'><button>Send message</button></a></td></tr>";
}
 ?>
</table>
</div>
</center>
