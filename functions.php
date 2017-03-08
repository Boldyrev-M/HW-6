<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 16.01.2017
 * Time: 16:26
 */
error_reporting(E_ALL & E_NOTICE & E_DEPRECATED & E_STRICT);
ini_set('display_errors', 1);
const ADMIN_LOGIN = 'admin';
$a = session_id();
if (empty($a)) session_start();

function userExist($userName)
{
    //echo "user:". $userName
    return file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR . $userName . '.json');
}

function isAdmin($login, $password)
{
    if ($login == ADMIN_LOGIN && $password == ADMIN_PASSWORD) {
        $_SESSION['Admin'] = true;
        return true;
    } else {
        $_SESSION['Admin'] = false;
        return false;
    }
}

function checkPassword($usr, $psw)
{
    $passdata = md5($usr.$psw.'log$0&');
    $fileContent = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR . $usr . '.json');
    $pass_json_array = json_decode($fileContent, true);
    return !strcmp($passdata, $pass_json_array["pass_encrypted"]); // true если строки равны
}

function numFiles($dir)
{
    return sizeof(scandir($dir)) - 2;
} // количество файлов в папке без '.' и '..'

function uploadTestFile($fileToUpload)
{
    if ($fileToUpload['tmp_name'] === "") {
        echo "<script>alert('Файл не выбран! \\nВыберите файл!')</script>";
        return false;
    }
    if ($fileToUpload["type"] !== "application/json") {
        echo "<script>alert('Это не файл json!')</script>";
        return false;
    }
    $fileContent = file_get_contents($fileToUpload['tmp_name'], FILE_TEXT);
    $toload_json_array = json_decode($fileContent, true);
    if (!$toload_json_array) {
        echo('Неверный формат файла. Правильная кодировка: UTF-8 без BOM');
        echo "<br>Error " . json_last_error();
        echo "<br>" . json_last_error_msg() . "<br>";
        // недопустимое содержимое файла
        return false;
    }
    $destinationDir = __DIR__ . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR;
    $destinationFileName = $destinationDir . numFiles($destinationDir) . '.json';
    $loadedfilename = $fileToUpload['name'];
    if (!move_uploaded_file($fileToUpload['tmp_name'], $destinationFileName)) {
        // ошибка
        //var_dump($_FILES);
        return false;
    } else {
        echo 'Файл ' . $loadedfilename . ' загружен: ' . $destinationFileName . '<br>';
//        $str = 'число файлов в папке:' . numFiles($destinationDir) . '<br>';
//        echo ( $str);
        return numFiles($destinationDir);
    }
}