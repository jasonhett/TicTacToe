<?php


$pos =  strval($_POST['position']);
$value = intval($_POST['value']);
$game_id = intval($_POST['gameId']);

update_db($pos, $value);
increment_turn();


//sql functions to update db
function update_db ($pos, $value){
    //update the value at the pos
    //keep track that this is last update so we can grab it later
    include "mysqlConnect.php";
    $lastPosVal = intval($GLOBALS['$pos']);
    $value = intval($GLOBALS['$value']);
    $game_id = intval($GLOBALS['game_id']);
    mysql_query("UPDATE Game SET lastPos = '$lastPosVal' , $pos = '$value' WHERE idGame = '$game_id'") or die(mysql_error());
}
function increment_turn(){
    //increment sql turn counter
    include "mysqlConnect.php";
    $game_id = intval($GLOBALS['game_id']);
    $sql = mysql_query("SELECT * FROM Game WHERE idGame = '$game_id'");
    $isGameExists = mysql_num_rows($sql);

    if ($isGameExists){
    	$row = mysql_fetch_array($sql);
    	$currentTurn = $row['turn_Count'];
    	$currentTurn = $currentTurn + 1;
    	$game_id = intval($GLOBALS['game_id']);
    	mysql_query("UPDATE Game SET turn_Count = '$currentTurn' WHERE idGame = '$game_id'");
    }


}