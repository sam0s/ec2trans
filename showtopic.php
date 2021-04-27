<?php
 include 'login.php';

 //check for required info from the query string
 if (!isset($_GET['topic_id'])) {
 header("Location: index");
 exit;
 }

 //create safe values for use
 $safe_topic_id = SQLite3::escapeString($_GET['topic_id']);

 //verify the topic exists
 $verify_topic_sql = "SELECT topic_title,topic_owner FROM forum_topics
 WHERE topic_id = '".$safe_topic_id."'";

 $verify_topic_res = ($db->query($verify_topic_sql));

 $num_rows = $db->query("SELECT COUNT(*) FROM forum_topics WHERE topic_id ="."'".$safe_topic_id."';")->fetchArray()[0];

 if ($num_rows < 1) {
 //this topic does not exist
 $display_block = "<p><em>You have selected an invalid topic.<br>
 Please <a href=\"index\">try again</a>.</em></p>";
 } else {
 //get the topic title
 $topic_info =  $verify_topic_res->fetchArray();
  $topic_title = stripslashes($topic_info[0]);
  $topic_owner = stripslashes($topic_info[1]);


 //gather the posts
 $get_posts_sql = "SELECT post_id, post_text,post_create_time,post_owner
 FROM forum_posts
 WHERE topic_id = '".$safe_topic_id."'
 ORDER BY post_create_time ASC";

 $get_posts_res = ($db->query($get_posts_sql));

 //create the display string
 $display_block = <<<END_OF_TEXT
 <p>Showing posts for the <strong>$topic_title</strong> thread by <strong>$topic_owner</strong>:</p>
 <table>
 <tr>
 <th>AUTHOR</th>
 <th>POST</th>
 </tr>
 END_OF_TEXT;

 while ($posts_info = $get_posts_res->fetchArray() ) {
 $topic_id = $safe_topic_id;
 $post_id = $posts_info[0];
 $post_text = nl2br(stripslashes($posts_info[1]));
 $post_create_time = $posts_info[2];
 $post_owner = stripslashes($posts_info[3]);

 $exist = $db->query("SELECT COUNT(*) FROM Users WHERE Username = '$post_owner';")->fetchArray()[0];
 $cuINFO= $db->query("SELECT pfpUrl,ID FROM Users WHERE Username = '$post_owner';");
 $cuID=0;
 $pfpURL="nopfp.png";
 if($exist >0){
   $cuINFOArray =$cuINFO->fetchArray();
   $pfpURL = $cuINFOArray[0];
   $cuID = $cuINFOArray[1];
 }
 //add to display
 $display_block .= <<<END_OF_TEXT
 <tr>
 <td><a href='profile.php?profile=$cuID'>$post_owner</a>
 <br>
 <img src='$pfpURL'  style='width:120px;height:120px;margin-right: 150px;'></img>
 <br>
 <p>reply created on:<br>$post_create_time</p></td>
 <td style="width: 85%;"><p>$post_text</p>
 <p><a href="replytopost.php?topic=$topic_id&post_id=$post_id">
 <strong>REPLY TO POST</strong></a></p></td>
 </tr>
 END_OF_TEXT;
 }

 //close up the table
 $display_block .= "</table>";
 }
 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 <title><?php echo $topic_title; ?> - samiscoolco forum</title>
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
 </head>
 <body>
   <div>
 <h1><i> <?php echo $topic_title;?> </i></h1>
 <?php echo $display_block; ?>
 <a href="index.php">Go to topic list.</a>
</div>
 </body>
 </html>
