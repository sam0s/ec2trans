<?php

include 'login.php';
//check for required fields from the form
if ((!$_POST['pfplink']) ||
(!$_POST['biotext'])) {
header("Location: index.php");
exit;
}

$clean_pfplink = SQLite3::escapeString($_POST['pfplink']);
$clean_biotext = SQLite3::escapeString($_POST['biotext']);
$clean_id = SQLite3::escapeString($_SESSION['id']);

$clean_biotext = strip_tags($clean_biotext,$allowedTags);


$qry= "
UPDATE Users
SET bio='$clean_biotext',pfpURL='$clean_pfplink'
WHERE ID=$clean_id;
";
$result = $db->query($qry);
header("Location: profile.php?profile=".$_SESSION['id']);
?>
