<?php

include 'login.php';

//gather the topics
$get_topics_sql = "SELECT * FROM forum_topics
ORDER BY topic_create_time DESC";

$get_topics_res = ($db->query($get_topics_sql));

$num_rows = $db->query("SELECT COUNT(*) FROM forum_topics;")->fetchArray()[0];



if ($num_rows < 1) {
//there are no topics, so say so
$display_block = "<p><em>No topics yet.</em></p>";
} else {
//create the display string

$display_block='
<table>
<tr>
<th>THREAD TITLE</th>
<th># of POSTS</th>
</tr>';

while($topic_info = $get_topics_res->fetchArray() ) {
$topic_id = $topic_info[0];
$topic_title = stripslashes($topic_info[1]);
$topic_create_time = $topic_info[2];
$topic_owner = stripslashes($topic_info[3]);

//get number of posts
$num_posts = $db->query("SELECT COUNT(*) FROM forum_posts WHERE topic_id ='".$topic_id."';")->fetchArray()[0];

//add to display
$display_block.='
<tr>
<td><a href="showtopic.php?topic_id='.$topic_id.'">
<strong>'.$topic_title.'</strong></a><br/>
Created on '.$topic_create_time.' by '.$topic_owner.'</td> <td class="num_posts_col">'.$num_posts.'</td></tr>';
}

//close up the table
$display_block .= "</table>";
$display_block.='<br><i>total: '.$num_rows.' threads.</i>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>samiscoolco forum</title>
</head>
<body>
  <center>
  <div>

<h1>Threads</h1>
<p><a href="addtopic.php"><button>Create Thread</button></a></p>
<?php echo $display_block; ?>

</div>
</center>
</body>
</html>
