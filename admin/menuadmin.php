<?php

session_start();


if($_SESSION["usuario"]=="")
{
    if (!headers_sent())
    {
        header("Location: ../index.php");
    }
    else
    {
         echo "<meta http-equiv=\"refresh\" content=\"0;url=../index.php\">\r\n";
    }
}
else
{
    if ($_SESSION['idusuario'] == 4)
    {
        if (!headers_sent())
         {
            header("Location: admreporte.php");
        }
        else
        {
            echo "<meta http-equiv=\"refresh\" content=\"0;url=admreporte.php\">\r\n";
         }
    }
    else
    {
        if (!headers_sent())
        {
            header("Location: admdeptos.php");
        }
        else
        {
            echo "<meta http-equiv=\"refresh\" content=\"0;url=admdeptos.php\">\r\n";
         }
    }
}
?>