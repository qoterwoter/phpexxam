<?php
if (isset($_POST["poll_id"]) and is_numeric($_POST["poll_id"])) {
    $poll_id=$_POST["poll_id"];
}
else $poll_id='';
if (isset($_POST["answer_id"]) and is_numeric($_POST["answer_id"])) {
    $answer_id=$_POST["answer_id"];
}
else $answer_id='';

if ($poll_id>0) {
 $db=mysqli_connect("std-mysql","std_962","12345678","std_962");
 $res=mysqli_query($db,"set names utf8");

if ($answer_id!='') {
 $ip=$_SERVER['REMOTE_ADDR'];
 $res=mysqli_query($db,"SELECT count(id) FROM poll_ip
     WHERE poll_id='".$poll_id."' and ip=INET_ATON('".$ip."') LIMIT 1");
 $number=mysqli_fetch_array($res);
 if ($number[0]==0) {
    $res=mysqli_query($db,"INSERT INTO poll_ip (poll_id,ip,date)
        values ('".$poll_id."',INET_ATON('".$ip."'),'".time()."')");
    $res=mysqli_query($db,"UPDATE poll_answer SET votes=(votes+1)
        WHERE id='".$answer_id."' LIMIT 1");
    $answer='Ваш голос учтен!';
 }
 else $answer='Вы уже голосовали!';
}

 $summa=mysqli_fetch_array(mysqli_query($db,"SELECT max(votes) AS max_v, sum(votes)
     AS sum_v FROM poll_answer WHERE poll_id='".$poll_id."' LIMIT 1"));
 if ($summa["max_v"]==0) $summa["max_v"]=1;
 $res=mysqli_query($db,"SELECT title,votes FROM poll_answer
     WHERE poll_id='".$poll_id."' ORDER BY votes DESC");

 while ($rating=mysqli_fetch_array($res)) {
    echo '<div style="width:560px;float:left;">'.$rating["title"];
    echo '<div class="votes" style="width:'.($rating["votes"]/$summa["max_v"]*560);
    echo 'px;">'.$rating["votes"].'</div></div><div style="float:right;"><br>';
    if ($summa["sum_v"]==0) echo '0 %</div>';
    else echo round(100*$rating["votes"]/$summa["sum_v"],2).' %</div>';
 }
 echo '<div style="width:100%;float:left;">Голосов: <b>'.$summa["sum_v"].'</b>';
 echo '<div style="color:#CC0000;" align="center">'.$answer.'</div></div>';
}
?>