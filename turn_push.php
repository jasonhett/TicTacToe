<?php


$pos =  strval($_POST['position']);
$value = intval($_POST['value']);
$game_id = intval($_POST['gameId']);

// $pos = 1;
// $value = 1;
// $game_id = 1;

update_db($pos, $value);
increment_turn();


//sql functions to update db
function update_db ($pos, $value){
    //update the value at the pos
    //keep track that this is last update so we can grab it later
    include "mysqlConnect.php";

    global $value, $game_id;
    $lastPosVal = intval($pos);
    #$value = intval($GLOBALS['$value']);
    #$game_id = intval($GLOBALS['game_id']);
    switch ($pos) {
	    case 1:
	        mysql_query("UPDATE Game SET lastPos = '$lastPosVal' ,  pos1 = '$value' WHERE idGame = '$game_id'") or die(mysql_error());
	        break;
	    case 2:
	        mysql_query("UPDATE Game SET lastPos = '$lastPosVal' ,  pos2 = '$value' WHERE idGame = '$game_id'") or die(mysql_error());
	        break;
	    case 3:
	        mysql_query("UPDATE Game SET lastPos = '$lastPosVal' ,  pos3 = '$value' WHERE idGame = '$game_id'") or die(mysql_error());
	        break;
	    case 4:
	        mysql_query("UPDATE Game SET lastPos = '$lastPosVal' ,  pos4 = '$value' WHERE idGame = '$game_id'") or die(mysql_error());
	        break;
	    case 5:
	        mysql_query("UPDATE Game SET lastPos = '$lastPosVal' ,  pos5 = '$value' WHERE idGame = '$game_id'") or die(mysql_error());
	        break;
	    case 6:
	        mysql_query("UPDATE Game SET lastPos = '$lastPosVal' ,  pos6 = '$value' WHERE idGame = '$game_id'") or die(mysql_error());
	        break;
	    case 7:
	        mysql_query("UPDATE Game SET lastPos = '$lastPosVal' ,  pos7 = '$value' WHERE idGame = '$game_id'") or die(mysql_error());
	        break;
	    case 8:
	        mysql_query("UPDATE Game SET lastPos = '$lastPosVal' ,  pos8 = '$value' WHERE idGame = '$game_id'") or die(mysql_error());
	        break;
	    case 9:
	        mysql_query("UPDATE Game SET lastPos = '$lastPosVal' ,  pos9 = '$value' WHERE idGame = '$game_id'") or die(mysql_error());
	        break;
	    case 10:
	        mysql_query("UPDATE Game SET lastPos = '$lastPosVal' ,  pos10 = '$value' WHERE idGame = '$game_id'") or die(mysql_error());
	        break;
	    case 11:
	        mysql_query("UPDATE Game SET lastPos = '$lastPosVal' ,  pos11 = '$value' WHERE idGame = '$game_id'") or die(mysql_error());
	        break;
	    case 12:
	        mysql_query("UPDATE Game SET lastPos = '$lastPosVal' ,  pos12 = '$value' WHERE idGame = '$game_id'") or die(mysql_error());
	        break;
	    case 13:
	        mysql_query("UPDATE Game SET lastPos = '$lastPosVal' ,  pos13 = '$value' WHERE idGame = '$game_id'") or die(mysql_error());
	        break;
	    case 14:
	        mysql_query("UPDATE Game SET lastPos = '$lastPosVal' ,  pos14 = '$value' WHERE idGame = '$game_id'") or die(mysql_error());
	        break;
	    case 15:
	        mysql_query("UPDATE Game SET lastPos = '$lastPosVal' ,  pos15 = '$value' WHERE idGame = '$game_id'") or die(mysql_error());
	        break;
	    case 16:
	        mysql_query("UPDATE Game SET lastPos = '$lastPosVal' ,  pos16 = '$value' WHERE idGame = '$game_id'") or die(mysql_error());
	        break;
	    case 17:
	        mysql_query("UPDATE Game SET lastPos = '$lastPosVal' ,  pos17 = '$value' WHERE idGame = '$game_id'") or die(mysql_error());
	        break;
	    case 18:
	        mysql_query("UPDATE Game SET lastPos = '$lastPosVal' ,  pos18 = '$value' WHERE idGame = '$game_id'") or die(mysql_error());
	        break;
	    case 19:
	        mysql_query("UPDATE Game SET lastPos = '$lastPosVal' ,  pos19 = '$value' WHERE idGame = '$game_id'") or die(mysql_error());
	        break;
	    case 20:
	        mysql_query("UPDATE Game SET lastPos = '$lastPosVal' ,  pos20 = '$value' WHERE idGame = '$game_id'") or die(mysql_error());
	        break;
	    case 21:
	        mysql_query("UPDATE Game SET lastPos = '$lastPosVal' ,  pos21 = '$value' WHERE idGame = '$game_id'") or die(mysql_error());
	        break;
	    case 22:
	        mysql_query("UPDATE Game SET lastPos = '$lastPosVal' ,  pos22 = '$value' WHERE idGame = '$game_id'") or die(mysql_error());
	        break;
	    case 23:
	        mysql_query("UPDATE Game SET lastPos = '$lastPosVal' ,  pos23 = '$value' WHERE idGame = '$game_id'") or die(mysql_error());
	        break;
	    case 24:
	        mysql_query("UPDATE Game SET lastPos = '$lastPosVal' ,  pos24 = '$value' WHERE idGame = '$game_id'") or die(mysql_error());
	        break;
	    case 25:
	        mysql_query("UPDATE Game SET lastPos = '$lastPosVal' ,  pos25 = '$value' WHERE idGame = '$game_id'") or die(mysql_error());
	        break;
	}
    
}
function increment_turn(){
    //increment sql turn counter
    include "mysqlConnect.php";

    global $game_id;
    #$game_id = intval($GLOBALS['game_id']);
    $sql = mysql_query("SELECT * FROM Game WHERE idGame = '$game_id'");
    $isGameExists = mysql_num_rows($sql);

    if ($isGameExists){
    	$row = mysql_fetch_array($sql);
    	$currentTurn = $row['turn_Count'];
    	$currentTurn = $currentTurn + 1 ;
    	$game_id = intval($GLOBALS['game_id']);
    	mysql_query("UPDATE Game SET turn_Count = '$currentTurn' WHERE idGame = '$game_id'");
    }


}