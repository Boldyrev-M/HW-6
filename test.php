<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 05.01.2017
 * Time: 18:50
 */

$testName = $_GET["testRun"];
if (!file_exists(__DIR__ . '/files/'.$testName)) {
    header("HTTP/1.0 404 Not Found");
    exit();
}
$fileContent = file_get_contents(__DIR__ . '/files/'.$testName);

$questions_json_array = json_decode($fileContent, true);
$TitleTest =  array_shift($questions_json_array);


    $StartTestForm = '<form action="result.php" method= "post">
           <fieldset><legend>' . $TitleTest["Title"] . '</legend>
           <p>Ваше имя:<input name="userName" type="text" value=""> </p>
           <p><input name = "test" type="hidden" value="' . $testName . '"></p>';

    foreach ($questions_json_array as $item) {
        $StartTestForm .= '<p>' . $item ['Question'] . '</p>';
        $StartTestForm .= '<p><input name="responce[' . $item['num'] . ']" type="text" value=""> </p>';
    }

    $StartTestForm .= '<p><input type="submit" value="Отправить ответы"></p></fieldset></form>';
    echo $StartTestForm;
