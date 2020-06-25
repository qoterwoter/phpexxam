<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
</head>
<body>
<h2>Введите данные для доступа к панели администратора</h2>
<p style='opacity:20%; color: black;'>ПОЛЬЗОВАТЕЛЬ - user, 111. АДМИНИСТРАТОР - admin, 12345</p>
<?php
    session_start();

    $users = 'admin';
    
    $link = mysqli_connect('std-mysql','std_962','12345678','std_962');

    $sql = 'SELECT * FROM `users` WHERE user_name = "'.$_POST['user'].'" and user_password = "'.$_POST['pass'].'"';
    $result = mysqli_query($link, $sql);

    $data = mysqli_fetch_all($result);
        

    if($_POST['submit']){
    if($data and $data[0][0]=='admin')
    {
        $user='admin';
        header("Location: admin.php?link=".uniqid(rand(0,999999))."");
    }
    elseif ($data and $data[0][0]=='user') {
        $user='user';
        header("Location: login.php");
    }
    else echo '<p>Логин или пароль неверны!</p>';
    } 
?>  

<form method="post">
Имя пользователя: <input type="text" name="user" /> <br /> 
Пароль: <input type="password" name="pass" /> <br />
<input type="submit" name="submit" value="Login" />
</form> 

</body>
</html>