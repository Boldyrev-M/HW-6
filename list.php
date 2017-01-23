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
//var_dump($entry);
//echo "<br>";
            $fileContent = file_get_contents(__DIR__ . '/files/'.$entry, FILE_TEXT);

            $filelistentry = json_decode($fileContent, true);
//            echo "ВАРДАМП<br>";
//            var_dump($filelistentry);
            //echo "<br>";
            if (array_key_exists('Title',$filelistentry[0])) {
                $titleTest =  array_shift($filelistentry);
                $testName = $titleTest['Title'];
                //echo "<br>из масс:".$testName;
            }
            else {
                $testName = $entry;
                //echo "<br>просто:".$testName;
            }



            $testlist .= '<p>
                          <input name="testRun" type="radio" value="'.$entry.'">'.
                substr($entry, 0, strrpos( $entry, "."))." - ".$testName.'</p>';

            //echo "$entry\n<br>";
        }
    }
    closedir($handle);
    $testlist .= "<p><input type=\"submit\" value=\"Выбрать\"></p></form>";
    echo $testlist;
}
