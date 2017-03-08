<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 13.01.2017
 * Time: 15:54
 */

include_once 'functions.php';
$html = '';
setcookie('logged_user', "", -1); // обнуляем куку если была

$_SESSION['logged_user']= "";
$_SESSION['guest']= "guest";
echo "<h2>Домашнее задание к лекции 2.3 «PHP и HTTP»</h2>";

if (!empty($_POST) && ($_POST['login'] != "")) {
    // имя уже получено, проверяем пароль
    $not_valid_chars = preg_match('/[^a-zA-Z0-9]/', $_POST['login']);
    if ($not_valid_chars == 1) {
        $html = <<<INVALID_NAME
        <form action="" method = "post" >
        <p><p><b>Введите имя (только латиница без пробелов):</b><br><input name="login" type="text" autofocus></p>
        <p><input type="submit" value="Войти"></p>
        </form>
INVALID_NAME;
        echo $html;
    } // в имени чтото кроме латиницы и цифр
    else // имя подходящее
    {
        $login = $_POST['login'];
        if (userExist($login)) { // пользователь найден

            if (!empty($_POST['pass'])) {
                if (checkPassword($login, $_POST['pass'])) {
                    setcookie('logged_user', $login); // установлена кука
                    $_SESSION['logged_user']= $login;
                    $_SESSION['guest']= 'not_guest';
                    header('location: admin.php '); // переход на страницу загрузки файлов
                } else { // введен неверный пароль, заново

                    $html = <<<WRONG_PASS
                <form action="" method = "post" >
                <p><p><b>Ваше имя: $login </b><br>
                <input type="hidden" name="login" value="$login">
                <label for="pass">Пароль неверный!</label>
                <input id= "pass" name="pass" type="password" autofocus placeholder="Введите пароль"><br>
                <input type="submit" value="Отправить">
                </form>
WRONG_PASS;

                }
                echo $html;
            } else {
                //echo "ЗАПРОС ПАРОЛЯ";
                $html = <<<LOGIN_EXISTS
            <form action="" method = "post" >
            <p><p><b>Ваше имя: $login </b><br>
            <input type="hidden" name="login" value="$login">
            <label for="pass">Пароль:</label>
            <input id= "pass" name="pass" type="password" autofocus placeholder="Введите пароль"><br>
            <input type="submit" value="Отправить">
            </form>
LOGIN_EXISTS;
                echo $html;

            }
        } // пользователь такой найден
        else { // пользователь НЕ найден - зарегистрироваться или продолжить как гость
            // echo "ПОЛЬЗОВАТЕЛЬ -НЕ- НАЙДЕН<br>";
            if (!empty ($_POST['usertype'])) { // уже выбрали
                if ($_POST['usertype'] == "stay_guest") {
                    $_SESSION['logged_user']= 'GUEST';
                    $_SESSION['guest']= 'guest';
                    header('location: admin.php ');
                } // остался гостем
                else
                    if ($_POST['usertype'] == "need_login") { // новый юзер

                        if (strlen($_POST['pass']) > 7 && strlen($_POST['pass']) < 12) {
                            // сохранить пару логин-пароль
                            $passdata = '{ "User": "'.$login.'", "pass_encrypted": "'.md5('name'.$_POST['pass'].'log$0&').'"}';
                            $fileContent = file_put_contents(__DIR__ .DIRECTORY_SEPARATOR.'users'.DIRECTORY_SEPARATOR.$login.'.json', $passdata);
                            $_SESSION['logged_user']= $login;
                            $_SESSION['guest']= 'not_guest';
                            header('location: admin.php ');

                        } // сохранить пароль нового юзера в файл

                        else {
                            $html = <<<NEW_USER
                        <form action="" method = "post" >
                        <p><p><b>Ваше имя: $login </b><br>
                        <input type="hidden" name="login" value="$login">
                        <input type="hidden" name="usertype" value="need_login">
                        
                        <label for="pass">Пароль придумайте (8-12 символов):</label>
                        <input id= "pass" name="pass" type="password" placeholder="Введите пароль"><br>
                        <input type="submit" value="Запомнить">
                        </form>
NEW_USER;
                            echo $html;

                        } // придумай пароль
                    } // логинится новый юзер
            } else {
                $login = $_POST['login'];
                $html = <<<NAME_ENTERED
        <form action="" method = "post" >
        <p><p><b>Ваше имя: $login </b><br>
        <input type="hidden" name="login" value="$login">
        <p><button value="need_login" name="usertype" type="submit">Зарегистрироваться</button></p>
        <p><button value="stay_guest" name="usertype" type="submit">Продолжить как гость</button></p>
    </form>
NAME_ENTERED;
                echo $html;

            } // решает, он гость или нет
        }
    }
} else {

    // <p><p><b>Ваше имя:</b><br><input name="user_name" type="text"></p>
    $html = <<<NO_NAME
        <form action="" method = "post">
        <p><p><b>Ваше имя (только латиница):</b><br><input name="login" type="text" autofocus></p>
        <p><input type="submit" value="Войти"></p>
        
    </form>
NO_NAME;
    echo $html;
} // имя еще не введено! Как вас зовут