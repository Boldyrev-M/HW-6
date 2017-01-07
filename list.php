<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 07.01.2017
 * Time: 15:40
 */

if ($handle = opendir(__DIR__ . '/files/')) {

    echo "Список загруженных тестов:\n<br><hr> ";
    $testlist = '<form action="test.php" method="get">';

    while (false !== ($entry = readdir($handle))) {
        if ( $entry !== '.' && $entry !== '..') {
            $testlist .= '<p>
                          <input name="testRun" type="radio" value="'.$entry.'">'.
                substr($entry, 0, strrpos( $entry, ".")) . '</p>';

            //echo "$entry\n<br>";
        }
    }
    closedir($handle);
    $testlist .= "<p><input type=\"submit\" value=\"Выбрать\"></p></form>";
    echo $testlist;
}
