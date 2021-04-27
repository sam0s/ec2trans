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
<h1> FRIEND REQUESTS </h1>

<?php

$uid = $_SESSION["id"];
$outgoing = $db->query("SELECT * FROM FriendLinks WHERE STATUS = 0 AND ID1 = $uid;");
$incoming = $db->query("SELECT * FROM FriendLinks WHERE STATUS = 0 and ID2 = $uid;");
$myfriends = $db->query("SELECT * FROM FriendLinks WHERE STATUS = 100 and (ID2 = $uid OR ID1 = $uid);");

echo "<table style='display:inline-block;vertical-align:top;'>";
echo "<tr>
  <th>Outgoing</th>
  </tr>";
while( $p = $outgoing->fetchArray() ){
  $name = $db->query("SELECT * FROM Users WHERE ID = $p[1];")->fetchArray()[0];
  $name = '<a href="profile.php?profile='.$p[1].'">'.$name.'</a>';
  echo "<tr>";
  echo "<td>Pending request to $name </td>";
  echo "</tr>";
}
echo "</table> &emsp;&emsp; ";

echo "<table style='display:inline-block; vertical-align:top;'>";
echo "<tr>
  <th>Incoming</th>
</tr>";
while( $p = $incoming->fetchArray() ){
  $name = $db->query("SELECT * FROM Users WHERE ID = $p[0];")->fetchArray()[0];
  $name = '<a href="profile.php?profile='.$p[0].'">'.$name.'</a>';
  echo "<tr>";
  echo "<td>Incoming request from $name <button onclick='accept($p[0])'>Accept</button></td>";
  echo "</tr>";
}
echo "</table>";
echo '<p style="clear: both;"></p>';
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
