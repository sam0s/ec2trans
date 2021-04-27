<?php
 include 'login.php';

 if(!isset($_SESSION["user"])){

   echo "
   <div>
     You gotta sign in / register before you can post a new topic or reply.
   </div>
   ";
   exit();
 }

 //check to see if we're showing the form or adding the post
 if (!$_POST) {
 // showing the form; check for required item in query string
 if (!isset($_GET['post_id'])) {
 header("Location: index.php");
 exit;
 }

 //create safe values for use
$safe_topic_id = SQLITE3::escapeString($_GET['topic']);
$safe_post_id = SQLITE3::escapeString($_GET['post_id']);

$op = $db->query("SELECT * FROM forum_posts WHERE post_id = $safe_post_id;");
while($a = $op->fetchArray())
{
  $opText = $a[2];
  $opName = $a[4];
}

 //still have to verify topic and post
 $verify_sql = "SELECT
    topic_title
FROM
    forum_posts
INNER JOIN forum_topics
    ON forum_topics.topic_id = ".$safe_topic_id .";";

$count_sql = "SELECT COUNT(*)
       topic_title
   FROM
       forum_posts
   INNER JOIN forum_topics
       ON forum_topics.topic_id = ".$safe_topic_id .";";

 $verify_res = $db->query($verify_sql);
 $num_rows = $db->query($count_sql)->fetchArray()[0];

 if ($num_rows < 1) {
 //this post or topic does not exist
 header("Location: index.php");
 exit;
 } else {
 //get the topic id and title
 while($topic_info = $verify_res->fetchArray()) {
 $topic_id = $safe_topic_id;
 $cancelURL = "showtopic.php?topic_id=".$topic_id;
 $topic_title = stripslashes($topic_info[0]);
 }
 ?>
 <!DOCTYPE html>
 <html>
 <head>
 <title>Reply to: <?php echo $topic_title; ?> - samiscoolco forum</title>
 </head>
 <body>
   <div>
 <h2>Replying to post in thread: <i><?php echo $topic_title; ?></i></h2>

 <div>
   <i><b>original post by <?php echo $opName;?>:</b>
     <p>
       <?php
       echo $opText;
       ?>
     </p>

   </i>
 </div>

 <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
 <p><label for="post_text">Post Text:</label><br>
 <textarea id="post_text" name="post_text" rows="8" cols="40"
 required="required">
 <?php echo '>>> '.$_SESSION["user"].' REPLYING TO '.$opName.': "'.$opText.'"'; ?>

</textarea></p>
 <input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
 <button type="submit" name="submit" value="submit">Add Post</button>
 </form>
 <a href="<?php echo $cancelURL?>"> Cancel </a>
</div>
 </body>
 </html>
 <?php
 }

 } else if ($_POST) {
 //check for required items from form
 if ((!$_POST['topic_id']) || (!$_POST['post_text'])) {
 header("Location: index.php");
 exit;
 }

 //create safe values for use
 $safe_topic_id = SQLITE3::escapeString($_POST['topic_id']);
 $safe_post_text = SQLITE3::escapeString($_POST['post_text']);
 $safe_post_owner = SQLITE3::escapeString($_SESSION["user"]);

 $safe_post_text  = strip_tags($safe_post_text ,$allowedTags);

 //add the post
 $add_post_sql = "INSERT INTO forum_posts (topic_id,post_text,
 post_create_time,post_owner) VALUES
 ('".$safe_topic_id."', '".$safe_post_text."',
 datetime('now'),'".$safe_post_owner."')";

 $add_post_res = $db->query($add_post_sql);
 //redirect user to topic
 header("Location: showtopic.php?topic_id=".$_POST['topic_id']);
 exit;
 }
 ?>
