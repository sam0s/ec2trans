<?php

include 'login.php';
//check for required fields from the form
if ((!$_POST['topic_title']) ||
(!$_POST['post_text'])) {
header("Location: messenger.php");
exit;
}

$send = $_POST['frm'];
$recv = $_POST['to'];

//create safe values for input into the database
$clean_topic_owner = SQLite3::escapeString($_SESSION["user"]);
$clean_topic_title = SQLite3::escapeString($_POST['topic_title']);
$clean_post_text = SQLite3::escapeString($_POST['post_text']);

$clean_topic_title = strip_tags($clean_topic_title);
$clean_post_text = strip_tags($clean_post_text,$allowedTags);

//create and issue the first query
$add_topic_sql = "INSERT INTO Messages(Sender, Receiver, Subject, Message) VALUES ($send,$recv,'$clean_topic_title','$clean_post_text');";
$db->query($add_topic_sql);

$_SESSION["message"]="MESSAGE SENT!";
header("Location: messenger.php");
?>
