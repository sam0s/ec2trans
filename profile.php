

<?php

include 'login.php'; ?>
<center>
<?php

$myPage = ($_SESSION['id'] == $_GET['profile']);

?>

<div style = 'width:90%;'>
<?php

$p=$_GET['profile'];

$result = $db->query("SELECT * FROM Users WHERE ID = $p;")->fetchArray();
$name = ($result[0]);
$since = ($result[4]);
$pfpURL = ($result[7]);
$bio = ($result[8]);


$name2=$name;
if($myPage){
$name2  = $name ." (You)";
}

echo "<h1>".$name2."</h1>";
echo "<img src='".$pfpURL."'  style='width:300px;height:300px;'></img> <br>";
echo "<p> User since: ".$since."</p>";
echo "<p> Bio: ".$bio."</p>";

$frqmsg="Send friend request";
if(isset($_GET['sent'])){
  if($_GET['sent']==1){
  $frqmsg="REQUEST SENT!";
}
else{
$frqmsg="Must sign in to use that feature";
}
}

if($myPage){
echo "<a href='editProfile.php?profile=".$_GET['profile']."'>Edit Profile</a>";
}

else{
  if(!isset($_GET['sent'])){
  echo "
  <form action='fetch.php' method='post'>
  <input type='hidden' name='frqt' value='$p'>
  <input type='submit' id = 'frq' name='frq' value='$frqmsg'>
  </form>
  ";
}
else{
  echo $frqmsg;
}
}

?>

<style type="text/css">
table {
border: 1px solid black;
border-collapse: collapse;
}
th {
border: 1px solid black;
padding: 6px;
font-weight: bold;
background: #ccc;
}
td {
border: 1px solid black;
padding: 6px;
vertical-align: top;
}
.num_posts_col { text-align: center; }
</style>

<?php

$result = $db->query("SELECT * FROM forum_posts WHERE post_owner= '$name';");


$display_block = <<<END_OF_TEXT
<table>
<tr>
<th>THREAD</th>
<th>POST</th>
</tr>
END_OF_TEXT;

while($row = $result->fetchArray()){
  $tid=$row[1];
  $topName = $db->query("SELECT topic_title from forum_topics WHERE topic_id=$tid")->fetchArray()[0];
  $display_block.=<<<END_OF_TEXT
  <tr>
  <td>
  <p> <a href="showtopic.php?topic_id=$tid">$topName</a></p></td>
  <td style="width: 85%;"><p>$row[2]</p>
  </td>
  </tr>
  END_OF_TEXT;


}

echo "<hr><h1>Post history</h1>";

echo $display_block;



?>
</div>
</center>
