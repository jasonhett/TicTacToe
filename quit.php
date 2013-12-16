<?php

    include "mysqlConnect.php";

    $player_Id =  intval($_POST['shutdown']);
	$game_Id = intval($_POST['game']);
	
    $NotActive = 0;
    $sql = mysql_query("UPDATE Game SET Active = '$NotActive' WHERE idGame = '$game_Id'");




?>