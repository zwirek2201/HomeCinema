<?php

if(isset($_GET['pdf']))
{
    header('Location:' . $_GET['pdf'] . '.pdf');
}

?>