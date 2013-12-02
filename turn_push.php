<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jjbeanz
 * Date: 12/1/13
 * Time: 4:07 PM
 * To change this template use File | Settings | File Templates.
 */

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
    mysql_query("UPDATE Game SET lastPos = '$lastPosVal' , $pos = '$GLOBALS['$value']' WHERE idGame = $GLOBALS['$game_id']") or die(mysql_error());
}
function increment_turn(){
    //increment sql turn counter
    include "mysqlConnect.php";
    $sql = mysql_query("SELECT * FROM Game WHERE idGame = '$GLOBALS['$game_id']'");
    $isGameExists = mysql_num_rows($sql);

    if ($isGameExists){
    	$row = mysql_fetch_array($sql);
    	$currentTurn = $row['turn_Count'];
    	$currentTurn = $currentTurn + 1;
    	mysql_query("UPDATE Game SET turn_Count = '$currentTurn' WHERE idGame = $GLOBALS['$game_id']");
    }


}