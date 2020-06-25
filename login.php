<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ExamPHP</title>
</head>
<? 
    session_start();
    
?>
<body>
    <div class="forma1">
    <h2>Опрос</h2>
    </div>
    <?
        $dbconn = mysqli_connect('std-mysql','std_962','12345678','std_962');
        function questionsOut($link) {
            $sql2 = 'SELECT * FROM questions';
            $result2 = mysqli_query($link,$sql2);
            $data2 = mysqli_fetch_all($result2);
            echo '<form method="post"><ul>';
            for($i=0; $i<count($data2);$i++) {
                echo '<li>';
                echo '<input name="answer'.$i.'">';
                for($a=0; $a<(count($data2[$i]));$a++) {
                    echo ''.$data2[$i][$a].'';
                }
                echo '</li>';
            }
            echo '
            <label>
            Жми дважды,чтобы отправить
            <input type="submit" name="submit" value="Отправить">
            </label>
                </ul></form>';
            echo '</table>';
            $sql_check = 'SELECT * FROM answers';
            $data_check=(mysqli_fetch_all(mysqli_query($link,$sql_check)));
                if($_POST['submit'] AND $_POST['answer0']!='') {
                    $sql = 'INSERT INTO answers VALUES ( '.(count($data_check)+1).','.$_POST['answer0'].','.$_POST['answer1'].',"'.$_POST['answer2'].'","'.$_POST['answer3'].'",'.$_POST['answer4'].','.$_POST['answer5'].','.$_POST['answer6'].')';
                    mysqli_query($link,$sql);
            }
            echo '<table>';
            echo '<tr>';
            echo '<th>ID</th>';
            for($i=0;$i<count($data2);$i++) {
                echo '<th>'.$data2[$i][1].'</th>';
            }
            echo '</tr>';
            for($i=0; $i<count($data_check);$i++) {
                echo '<tr>';
                for ($a=0;$a<count($data_check[$i]);$a++) {
                    echo '<td>'.$data_check[$i][$a].'</td>';
                }
                echo '</tr>';
            }
            echo '</table>';
    }
        questionsOut($dbconn);
    ?>
</body>
</html>