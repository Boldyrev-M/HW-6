<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 05.01.2017
 * Time: 18:50
 */
//var_dump($_GET);
include_once 'functions.php';
if (!isset($_GET["testRun"])) {
    header('location: list.php ');
    //session_destroy();
}
$testName = $_GET["testRun"];
if (!file_exists(__DIR__.DIRECTORY_SEPARATOR.'tests'.DIRECTORY_SEPARATOR.$testName)) {
    header("HTTP/1.0 404 Not Found",true,404);
    echo 'Cтраница не найдена!';
    exit(1);
}

$fileContent = file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'tests'.DIRECTORY_SEPARATOR.$testName);

$questions_json_array = json_decode($fileContent, true);
//echo "<pre>".print_r($questions_json_array,true)."</pre>";

if (array_key_exists('Title',$questions_json_array[0])) {
    $TitleTest =  array_shift($questions_json_array);
}
else{
    $TitleTest = "";
}

    $StartTestForm = '<form action="result.php" method= "post">
           <fieldset><legend>' . $TitleTest["Title"] . '</legend>
           <p>Ваше имя:<input name="userName" type="text" value="" required> </p>
           <p><input name = "test" type="hidden" value="' . $testName . '"></p>';

    foreach ($questions_json_array as $item) {
        $StartTestForm .= '<p>' . $item ['Question'] . '</p>';
        $StartTestForm .= '<p><input name="responce[' . $item['num'] . ']" type="text" value=""> </p>';
    }

    $StartTestForm .= '<p><input type="submit" value="Отправить ответы"></p></fieldset></form>';
    echo "<h2>Выполнение теста</h2>";
    echo $StartTestForm;
