<?php
if (session_id()=='') session_start();
$db=mysqli_connect("std-mysql","std_962","12345678","std_962");
$res=mysqli_query($db,"set names utf8");

 if (isset($_POST["add_poll"])) $res=mysqli_query($db,"INSERT INTO polls (title)
     values ('".$_POST["new_poll"]."')");
 if (isset($_POST["add_answer"])) $res=mysqli_query($db,"INSERT INTO poll_answer
     (poll_id,title) values ('".$_SESSION["this_id"]."','".$_POST["new_answer"]."')");
 if (isset($_POST["del_answer"])) $res=mysqli_query($db,"DELETE FROM poll_answer
     WHERE id='".$_POST["del_answer_id"]."' LIMIT 1");
 if (isset($_POST["del_poll"])) {
    $res=mysqli_query($db,"DELETE FROM polls WHERE id='".$_SESSION["this_id"]."'");
    $res=mysqli_query($db,"DELETE FROM poll_answer WHERE
        poll_id='".$_SESSION["this_id"]."'");
 }
 if (isset($_POST["end_poll"]) or isset($_POST["del_poll"])) $_SESSION["this_id"]='';
 if (isset($_POST["edit_answer"])) $res=mysqli_query($db,"UPDATE poll_answer
    SET title='".$_POST["text_answer"]."' WHERE id='".$_POST["id_answer"]."'");
 if (isset($_POST["edit_question"])) $res=mysqli_query($db,"UPDATE polls SET
    title='".$_POST["text_question"]."' WHERE id='".$_SESSION["this_id"]."'");

 if (isset($_POST["edit_poll"])) {
  $res=mysqli_fetch_array(mysqli_query($db,"SELECT id FROM polls WHERE
    id='".$_POST["poll_id"]."'"));
  if ($res["id"]!=0) $_SESSION["this_id"]=$_POST["poll_id"];
 }

 if (isset($_POST["add_poll"]) or isset($_POST["add_answer"]) or
 isset($_POST["edit_poll"]) or isset($_POST["edit_question"]) or
 isset($_POST["edit_answer"]) or isset($_POST["del_answer"]) or
 isset($_POST["del_poll"])) {header("Location: admin_polls.php");exit;}
?>

 <style type="text/css">
 .forms {border:1px solid #555555;background-color:#DDDDDD;padding:10px;width:440px;}
 </style>
 <div class="forms"><form method="POST" action="admin_polls.php">
 <b>Добавить новый опрос!</b><br>
 Вопрос: <input type="text" name="new_poll" maxlength="255" size="40" required>
 <input type="submit" name="add_poll" value="Добавить"></form>

 <form method="POST" action="admin_polls.php"><b>Редактировать опрос №</b>
 <input type="text" name="poll_id" maxlength="5" size="5" required>
 <input type="submit" name="edit_poll" value="Редактировать"></form></div>

<?php
if ($_SESSION["this_id"]!='') {
 $res=mysqli_fetch_array(mysqli_query($db,"SELECT id,title FROM polls WHERE
     id='".$_SESSION["this_id"]."'"));
 echo '<div class="forms"><b>'.$res["title"].'</b> (id='.$res["id"].')<br>';
 $res=mysqli_query($db,"SELECT id,title FROM poll_answer WHERE
     poll_id='".$_SESSION["this_id"]."' ORDER BY id");
 while ($answer=mysqli_fetch_array($res))
     echo '- '.$answer["title"].' (id='.$answer["id"].')<br>';
?>

 </div>
 <div class="forms"><form method="POST" action="admin_polls.php">
 <b>Добавить варианты ответов к опросу:</b><br>
 Ответ: <input type="text" name="new_answer" maxlength="255" size="40" required>
 <input type="submit" name="add_answer" value="Добавить"></form>
 <form method="POST" action="admin_polls.php"><b>Изменить ответ</b>
 c id= <input type="text" name="id_answer" maxlength="4" size="4" required><br>
 Ответ: <input type="text" name="text_answer" maxlength="255" size="40" required>
 <input type="submit" name="edit_answer" value="Изменить"></form>
 <form method="POST" action="admin_polls.php"><b>Изменить вопрос на</b><br>
 <input type="text" name="text_question" maxlength="255" size="47" required>
 <input type="submit" name="edit_question" value="Изменить"></form>
 <form method="POST" action="admin_polls.php"><b>Удалить ответ</b>
 c id= <input type="text" name="del_answer_id" maxlength="4" size="4" required>
 <input type="submit" name="del_answer" value="Удалить"></form>
 <form method="POST" action="admin_polls.php">
 <input type="submit" name="del_poll" value="Удалить текущий опрос">
 <input type="submit" name="end_poll" value="Закончить редактирование">
 </form></div>
<?php
}
?>