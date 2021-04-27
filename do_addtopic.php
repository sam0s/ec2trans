<?php

include 'login.php';
//check for required fields from the form
if ((!$_POST['topic_title']) ||
(!$_POST['post_text'])) {
header("Location: addtopic.php");
exit;
}

//create safe values for input into the database
$clean_topic_owner = SQLite3::escapeString($_SESSION["user"]);
$clean_topic_title = SQLite3::escapeString($_POST['topic_title']);
$clean_post_text = SQLite3::escapeString($_POST['post_text']);

$clean_topic_title = strip_tags($clean_topic_title);
$clean_post_text = strip_tags($clean_post_text,$allowedTags);

//create and issue the first query
$add_topic_sql = "INSERT INTO forum_topics (topic_title, topic_create_time, topic_owner)
VALUES ('".$clean_topic_title ."', datetime('now'),
'".$clean_topic_owner."')";

$add_topic_res = ($db->query($add_topic_sql));
$topic_id = ($db->query("SELECT last_insert_rowid()"))->fetchArray()[0];


//create and issue the second query
$add_post_sql = "INSERT INTO forum_posts
(topic_id, post_text, post_create_time, post_owner)
VALUES ('".$topic_id."', '".$clean_post_text."',
datetime('now'), '".$clean_topic_owner."')";
$add_post_res = ($db->query($add_post_sql));

header("Location: showtopic.php?topic_id=".$topic_id);
?>
