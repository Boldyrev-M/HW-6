<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 07.01.2017
 * Time: 11:08
 */
const ADMIN_LOGIN = 'admin';
const ADMIN_PASSWORD = 'pass';

function isAdmin($login, $password) {
    if ($login == ADMIN_LOGIN && $password == ADMIN_PASSWORD) {
        return true;
    }
    else {
        return false;
    }

}

function numFiles ( $dir ) {
    return sizeof(scandir($dir))-2;
}

function uploadTestFile ( $fileToUpload ) {
    // нужна проверка что файл json

    $fileContent = file_get_contents( $fileToUpload['tmp_name'], FILE_TEXT );

    $toload_json_array = json_decode($fileContent, true);
    if (!$toload_json_array ) {
        echo ('Неверный формат файла json');
        echo json_last_error();
        echo json_last_error_msg();
        // недопустимое содержимое файла
        return false;
    }
    $destinationDir = __DIR__ . '/files/';
    $destinationFileName = $destinationDir . numFiles($destinationDir).'.json';
    $loadedfilename = $fileToUpload['name'];
    if (!move_uploaded_file($fileToUpload['tmp_name'], $destinationFileName)) {
        // ошибка
        var_dump($_FILES);
        return false;
    }
    else {
        echo 'Файл ' . $loadedfilename . ' загружен: ' . $destinationFileName . '<br>';
        $str = 'число файлов в папке:' . numFiles($destinationDir) . '<br>';
        echo ( $str);
        //var_dump( $destinationFileName);
        return numFiles($destinationDir);
    }
}