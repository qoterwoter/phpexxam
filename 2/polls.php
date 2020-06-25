<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title><script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
</head>
<body>
<?
echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>';
$db=mysqli_connect("std-mysql","std_962","12345678","std_962");
$res=mysqli_query($db,"set names utf8");

$res=mysqli_fetch_array(mysqli_query($db,"SELECT max(id) FROM polls LIMIT 1"));
$poll_id=$res[0];

if (isset($_GET["poll_id"]) and is_numeric($_GET["poll_id"]) and $_GET["poll_id"]>0){
 $res=mysqli_fetch_array(mysqli_query($db,"SELECT id FROM polls
 WHERE id='".$_GET["poll_id"]."' LIMIT 1"));
 if ($res[0]!='') $poll_id=$res[0];
}
$poll=mysqli_fetch_array(mysqli_query($db,"SELECT id,title FROM polls
WHERE id='".$poll_id."'"));
?>

<style type="text/css">
 .polls{padding:10px; text-align:center; border:1px solid #EEEEEE; width:700px;}
 .poll{text-align:left; display:table; width:100%; font-size:14px;}
 .poll label{line-height:2;}
 .votes{text-align:center; background-color:#CCCCFF; border:1px solid #0033FF;
 margin:0 0 10px 0;}
</style>

<?php
echo '<div class="polls"><b>'.$poll["title"].'?</b>';
echo '<div class="poll" id="poll_'.$poll_id.'">';
$res=mysqli_query($db,"SELECT id,title FROM poll_answer
    WHERE poll_id='".$poll_id."' ORDER BY id");
while ($answer=mysqli_fetch_array($res)) echo '<label><input type="radio"
    name="item" value="'.$answer["id"].'">'.$answer["title"].'</label><br>';
echo '<div style="text-align:center;"><input type="submit" id="view_res"
    value="Посмотреть результат">';
echo '<input type="submit" id="vote" value="Голосовать">';
echo '</div></div></div><br>';
?>

<script type="text/javascript">
$(document).ready(function(){
 $(".poll input:first").prop("checked",true);

 $("#vote").click(function(){
     jQuery.post("polls_result.php",{poll_id:$(this).parents(".poll").attr("id").
     split('_')[1], answer_id:$('input:checked').val()},rating_poll);});

 $("#view_res").click(function(){
     jQuery.post("polls_result.php",{poll_id:$(this).parents(".poll").attr("id").
     split('_')[1]},rating_poll);});

 function rating_poll(data){
     $(".poll").fadeOut(500, function(){$(this).html(data).fadeIn(500);});
 }
});
</script>   
</body>
</html>
