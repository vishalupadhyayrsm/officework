<?php
logout();

function logout()
{
    session_start();
    session_unset();
    header("Location: ./index.php");
    die();
}
