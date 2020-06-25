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
    <p style='opacity:35%;'>жми на кнопки по 2 раза...</p>
    <div class="forma1">
    <h2>Форма для редактирования/добавления вопроса</h2>
        <form method='post'>
            <ul>
                <li>Номер вопроса <input type='number' name='quest_num' min='1' value='1'></li>
                <li>Вопрос <input type='text' name='quest_text'></li>
            </ul>
            <input type="submit" value="Изменить" name='submit'>
        </form>
    </div><div class="forma2">
        <h2>Введите номер вопроса, который вы хотите удалить:</h2>
        <form method='post'>
            <ul>
                <li>Номер вопроса <input type='number' name='quest_num_delete' min='7' value='7'></li>
            </ul>
            <input type="submit" value="Удалить" name='submit2'>
        </form>
    </div>
    <?
        $dbconn = mysqli_connect('std-mysql','std_962','12345678','std_962');
    function questionsOut($link) {
        $sql2 = 'SELECT * FROM questions';
        $result2 = mysqli_query($link,$sql2);
        $data2 = mysqli_fetch_all($result2);
        echo '<table>
              <th>ID</th>
              <th>Вопрос</th>
        ';
        for($i=0; $i<count($data2);$i++) {
            echo '<tr>';
            for($a=1; $a<count($data2[$i]);$a++) {
                echo '<td>'.$data2[$i][0].'</td>';
                echo '<td>'.$data2[$i][$a].'</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
    }
   function answersOut($link) {
    $sql = 'SELECT * FROM `answers`'; 
    $result = mysqli_query($link,$sql);
    $data1 = mysqli_fetch_all($result);
    for($i=0; $i<count($data1);$i++) {
        echo '<h3>Данные в опросе №'.($i+1).'</h3>';
        echo '<ul>';
        for($a=1; $a<count($data1[$i]);$a++) {
            echo '<li>Вопрос №'.$a.' - '.$data1[$i][$a].'</li>';
        }
        echo '</ul>';
    }
   }
   function newQuestion($link) {
        $sql_question = 'INSERT INTO questions VALUES ('.$_POST['quest_num'].', "'.$_post['quest_text'].'")';
        $result_question = mysqli_query($link,$sql_question);

        $sql_answer = 'ALTER TABLE answers ADD COLUMN new'.$_POST['quest_num'].' varchar(55)';
        mysqli_query($link,$sql_answer);

       echo 'text';

   }
    function questionChange($link){
        $sql = 'UPDATE questions SET `question` ="'.$_POST['quest_text'].'" WHERE id='.$_POST['quest_num']; 
        $result = mysqli_query($link,$sql);
        $sql_check = 'SELECT * FROM questions';
        $result_check = mysqli_query($link,$sql_check);
        $data = mysqli_fetch_all($result_check);
        if ($_POST['quest_num'] > count($data)) {
            newQuestion($link);
        }
   }
    function deleteQuest($link) {
        $sql = 'DELETE FROM `questions` WHERE `id` = '.$_POST['quest_num_delete'];
        $result=mysqli_query($link,$sql);
        echo $sql;
    }
    $a=1;
    questionsOut($dbconn);
    answersOut($dbconn);
    if($_POST['submit'] and $_POST['quest_text']!='') {
        questionChange($dbconn);
    }   else {}
    echo $_GET($a);
    if($_POST['submit2']) {
        deleteQuest($dbconn);
    }
    ?>
    
</body>
</html>