<!DOCTYPE html>
 <html lang="en">
 <head>
 <title>New Message - samiscoolco forum</title>
 </head>
 <body>

<?php
include 'login.php';

$send = $_GET['frm'];
$recv = $_GET['to'];

if(!isset($_SESSION["user"])){

  echo "
  <div>
    You gotta sign in / register before you can send messages.
  </div>
  ";
  exit();
}

else{

echo <<<EOD
<div>
<h1>Send private message</h1>
<form method="post" action="do_sendMessage.php">
<p><label for="topic_title">Message Subject:</label><br>
<input type="text" id="topic_title" name="topic_title" size="40"
maxlength="150" required="required"></p>
<p><label for="post_text">Message text:</label><br>
<textarea id="post_text" name="post_text" rows="8"
cols="40"></textarea></p>
<button type="submit" name="submit" value="submit">Send message</button>

<input type='hidden' name="frm" value='$send'/>
<input type='hidden' name="to" value='$recv'/>
</form>
<a href="index.php">Cancel.</a>
</div>
EOD;
}
 ?>

 </body>
 </html>
