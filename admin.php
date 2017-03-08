<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 13.01.2017
 * Time: 15:53
 */
require_once 'functions.php';

if (!isset($_SESSION['guest'])) {
    header('location: index.php ');
    session_destroy();
}
if ($_SESSION['guest']== "guest") {
    // показать только список без кнопки добавления
    header('location: list.php ');
} else {
    // открыть форму загрузки
    $string = '<form action=" " method="post" enctype="multipart/form-data">
        <label for="FileName">Выберите файл для загрузки:</label>
        <input id="FileName" type="file" name="FileName">
        <input type="submit" value="Загрузить файл">
        <input type="hidden" name="login" value="' . $_POST['login'] . '">
        <input type="hidden" name="pass" value="' . $_POST['pass'] . '">
        </form>';
    echo $string;
    echo '<b>Формат файла для тестов:</b><br /> 
    [{<br />
    "Title": "Название теста"<br />
    },<br />
    {<br />
    "num": "1", // порядковый номер вопроса<br />
    "Question": "2+2=", // Текст вопроса<br />
    "Answer": "4" // Правильный ответ<br />
  },<br /> { <br />... // следующий вопрос<br /> },<br />...<br />,{<br />...     // последний вопрос<br />}]
  <br /><br>';


    // проверяем имя файла
    if (!empty($_FILES)) {
        //echo "<pre>".print_r($_FILES,true)."</pre>";

        $num = uploadTestFile($_FILES['FileName']);
        if ($num == 0) {
            //echo "NUM:" . $num;
            die('Ошибка. Файл НЕ загружен!');
        } else {
            echo '<form action="list.php" method="post">
                  <input type="submit" value="Показать список">
                  </form>';
        }
    }

}
echo "<a href='list.php'>Перейти к списку тестов</a>";