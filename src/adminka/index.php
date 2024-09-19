<?php

require_once ("config.php");


//___________________________________________________________
//
// AUTH
//___________________________________________________________

session_start();


if (!isset($_SESSION ["valid_user"]))
{

    if ( isset($_POST["auth_users_login"]) &&  isset($_POST["auth_users_pass"]) )
    {
        if (trim ($_POST["auth_users_login"]) =='' || trim ($_POST["auth_users_pass"]) =='')
        {
            echo"<p style='text-align:center;color:#f00;'>Не указана пара логин пароль</p>";
        }
        else
        {
            if( trim($_POST["auth_users_login"]) == $LOGIN && trim ($_POST['auth_users_pass']) == $PASSWORD )
            {

                if ( $_POST["remember"] =="on"){
                    session_set_cookie_params(12419200);
                }else {
                    session_set_cookie_params(86400);
                }

                $_SESSION["valid_user"] = $_POST["auth_users_login"];
            }
            else
            {
                echo '<p style="text-align:center;color:#f00;">Не верно указана пара логин пароль</p>';
            }
        }
    }
}

if (isset($_SESSION ["valid_user"]) )   // Если валидный пользователь - Вход в админку
{


    if (isset($_GET["logout"])){
        unset($_SESSION["valid_user"]);
        setcookie("PHPSESSID", "", time() - 3600, "/");
        session_unset();
        session_destroy();
        header("Location: /adminka/");
    }

    require_once ("main.php");

}
else    // Если не валидный пользователь - Показать панель ввода логина:пароля
{
    require_once("auth.php");
}