<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 07.01.2017
 * Time: 20:08
 */

/* Пример получаемых данных:
 * array(3) {
 * ["userName"]=> string(8) "Вася"
 * ["test"]=> string(6) "8.json"
 * ["responce"]=> array(2) { [1]=> string(3) "qww" [2]=> string(4) "wewe" }
 * }
*/
require "functions.php";

$correct = 0;
$fileContent = file_get_contents(__DIR__ . '/files/'.$_POST["test"]);
$questions_json_array = json_decode($fileContent, true);
$TitleTest =  array_shift($questions_json_array);
echo "Пользователь: " . $_POST["userName"] . "<br>";
echo "Тест: " . $TitleTest["Title"] . "<br>";

$vsego = sizeof($questions_json_array);
foreach ($questions_json_array as $item) {
    //echo '$item[\'Answer\'] '.$item['Answer'] .'<br>';
    //echo 'ответ '.$_POST["responce"][$item['num']].'<br>';

    if ($item['Answer'] == $_POST["responce"][$item['num']]) {
        $correct++;
    }
}
$mark = (1 + round($correct/$vsego*4));
echo "Вопросов: ". $vsego ."<br>";
echo "Правильных ответов: ". $correct."<br>";
echo "Оценка: ".$mark."<br>";

$text = "Студент: " . $_POST["userName"].
                ";Тест: " . $TitleTest["Title"].
                ";Оценка: ". $mark;
file_put_contents("cert.txt",$text);

echo '<img src="drawimage.php">';

