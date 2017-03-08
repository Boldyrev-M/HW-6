<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 13.01.2017
 * Time: 15:53
 */
include_once 'functions.php';

if ($handle = opendir(__DIR__.DIRECTORY_SEPARATOR.'tests'.DIRECTORY_SEPARATOR)) {

    echo "Список загруженных тестов:\n<br><hr> ";
    $testlist = '<form action="test.php" method="get">';

    while (false !== ($entry = readdir($handle))) {
        if ( $entry !== '.' && $entry !== '..') {
            $fileContent = file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'tests'.DIRECTORY_SEPARATOR.$entry, FILE_TEXT);
            $filelistentry = json_decode($fileContent, true);
            if (array_key_exists('Title',$filelistentry[0])) {
                $titleTest =  array_shift($filelistentry);
                $testName = $titleTest['Title'];
                //echo "<br>из масс:".$testName;
            }
            else {
                $testName = "Тест ".$entry;
                //echo "<br>просто:".$testName;
            }



            $testlist .= '<p>
                          <input name="testRun" type="radio" value="'.$entry.'">'.
                (substr($entry, 0, strrpos( $entry, "."))+1)." - ".$testName.'</p>';

            //echo "$entry\n<br>";
        }
    }
    closedir($handle);
    $testlist .= "<p><input type=\"submit\" value=\"Выбрать\"></p></form>";
    echo $testlist;
}
