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

/*
 * 1 - форма логина с проверкой имени и пароля (хэш?)
 * 2 - если логин правильный - форма добавления файла
 *
 *
 *
 *     if($USER->isAdmin())
    {
        echo ‘<pre>’;
        print_r($array);
        echo ‘</pre>';
    }
*/
require "functions.php";

if (!empty($_POST) && (isset($_POST['trueAdmin']) || isAdmin($_POST['login'],$_POST['pass']) )) {
    // открыть форму загрузки
    $string = <<<INP_Form
    <form action=" " method="post" enctype="multipart/form-data">
        <label for="FileName">Выберите файл для загрузки:</label>
        <input id="FileName" type="file" name="FileName">
        <input type="submit" value="Загрузить файл">
        <input type="hidden" name="trueAdmin" value=1>
    </form>
INP_Form;

    echo $string;
    echo '<b>Правильный формат файла:</b><br /> 
[{<br />
  "Title": "Название теста"<br />
},<br />
  {<br />
    "num": "1", // порядковый номер вопроса<br />
    "Question": "2+2=", // Текст вопроса<br />
    "Answer": "4" // Правильный ответ<br />
  },<br /> { <br />... // следующий вопрос<br /> },<br />...<br />,{<br />...     // последний вопрос<br />}]
  <br /><br>';

    if (!empty($_FILES)) {
        $num = uploadTestFile($_FILES['FileName']);
        if ($num !== false) {
            //echo "NUM:". $num;
            //echo '"' . $_FILES['FileName']['name']. '" загружен успешно под номером ' . $num . '.<br>';
            echo '<form action="list.php" method="post">
                  <input type="submit" value="Показать список">
                  </form>';
        }
    }

}
else {
// предложить запустить тест
    //echo 'NOT admin';
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
//if (!empty($_POST)) {
//    $destination = __DIR__ . '/files/' . $_FILES['name'];
//    if(!move_uploaded_file($HTTP_POST_FILES), $destination) {
//        die ("Файл не загружен!");
//    }
//}

