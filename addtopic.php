<!DOCTYPE html>
 <html lang="en">
 <head>
 <title>New Thread - samiscoolco forum</title>
 </head>
 <body>

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

else{


  echo <<<EOD
  <div>
<h1>Add a Topic</h1>
<form method="post" action="do_addtopic.php">
<p><label for="topic_title">Topic Title:</label><br>
<input type="text" id="topic_title" name="topic_title" size="40"
maxlength="150" required="required"></p>
<p><label for="post_text">Post Text:</label><br>
<textarea id="post_text" name="post_text" rows="8"
cols="40"></textarea></p>
<button type="submit" name="submit" value="submit">Add Topic</button>
</form>
<a href="index.php">Cancel.</a>
</div>
EOD;


}



 ?>

 </body>
 </html>
