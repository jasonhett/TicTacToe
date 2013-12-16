<?php


$pos =  intval($_POST['position']);
$player_num = intval($_POST['value']);
$game_id = intval($_POST['gameId']);

// $pos = 1;
// $value = 1;
// $game_id = 1;

update_db();
increment_turn();



//sql functions to update db
function update_db(){
    //update the value at the pos
    //keep track that this is last update so we can grab it later
    include "mysqlConnect.php";

    global $player_num, $game_id, $pos;
    #$lastPosVal = intval($pos);
    #$value = intval($GLOBALS['$value']);
    #$game_id = intval($GLOBALS['game_id']);
    
	mysql_query("UPDATE Game SET lastPos = '$pos' ,  last_Player = '$player_num' WHERE idGame = '$game_id'") or die(mysql_error());
	
	#To-do update and persist game state. Phase-2	        
	
    
}
function increment_turn(){
    //increment sql turn counter
    include "mysqlConnect.php";

    global $game_id,$player_num,$pos;
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
?>