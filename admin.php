<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 05.01.2017
 * Time: 18:49
 */
/*
http://netology-university.bitbucket.org/php/homework/2.2-forms/
Домашнее задание к лекции 2.2 «Обработка форм»

Генератор тестов на PHP и JSON:

    Создать файл admin.php с формой через которую на сервер можно загрузить JSON файл c тестом.
    Создать файл list.php со списком загруженных тестов.
    Создать файл test.php, который:
        Принимает в качестве GET-параметра номер теста, и отображает форму теста.
        Если форма отправлена, проверяет и показывает результат.

  */

require "functions.php";
if (empty($_POST))
{
    $_POST['login'] = '';
    $_POST['pass'] = '';
}

if (isAdmin($_POST['login'],$_POST['pass']) || isset($_POST['trueAdmin'])) {
    // открыть форму загрузки
    $string = '<form action=" " method="post" enctype="multipart/form-data">
        <label for="FileName">Выберите файл для загрузки:</label>
        <input id="FileName" type="file" name="FileName">
        <input type="submit" value="Загрузить файл">
        <input type="hidden" name="trueAdmin" value=1>
        <input type="hidden" name="login" value="'.$_POST['login'].'">
        <input type="hidden" name="pass" value="'.$_POST['pass'].'">
    </form>';

    echo $string;

    if (!empty($_FILES)) {
        $num = uploadTestFile($_FILES['FileName']);
        if ($num == 0 ) {
            echo "NUM:". $num;
            die('Файл НЕ загружен!');
        }
        else {
            echo '<form action="list.php" method="post">
                  <input type="submit" value="Показать список">
                  </form>';
        }
    }

}
else
{
    $string = <<<INP_Form
<form action=" " method="post">
    <label for="login">Логин:</label>
    <input id= "login" name="login" type="text" placeholder="Введите логин">
    <label for="pass">Пароль:</label>
    <input id= "pass" name="pass" type="password" placeholder="Введите пароль"><br>
    <input type="submit" value="Отправить">
    
</form>
INP_Form;

    echo $string;
}

