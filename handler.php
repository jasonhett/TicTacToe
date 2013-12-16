<?php

$row_size = intval($_POST['rowSize']);
$col_size = intval($_POST['colSize']);
$total_cell_count = 0;
define( 'JOINS_CHECK_INTERVAL', 1000000 );
define( 'GAMES_CHECK_INTERVAL', 100000 );
define( 'MESSAGE_DELIMITER', '#' );
define( 'KICKSTART_LENGTH', 500 );

define( 'PULSE_MESSAGE', '.' );

register_shutdown_function('handleShutdown');

// Kickstart
outputToBrowser( str_repeat( '.', KICKSTART_LENGTH ) );


//setup player info
$player_name= '';
$player_id= -1;
$turn_count= 0;
$game_id =  -1;
$ActivePlayer = array(1,1,1);

//assign player position
first_load();


//Waiting for players loop
//this will check for players
while (1)
{
    $new_player_count = check_player_count();

    if ($new_player_count >= 3)
    {
        $msg = "start" . "," . getSizeAverage();
        //message browser that its ready to start
        //Vote Averge

        outputMessage( $msg );
        break;
    }

    // Pause before next iteration
    usleep( JOINS_CHECK_INTERVAL );
	//outputMessage("In wait loop");
    #break; //debug usage
}

//Once exited waiting for players while loop goes into game updating loop
while(1){
    //end if turns greater than 25
    global $total_cell_count,$ActivePlayer, $game_id;
    if($turn_count > $total_cell_count){
        break;
    }

    //check for people exiting game;
    if(handleShutdown()){
        //$msg = "shutdown";
        //outputMessage($msg);
        PlayerGoneUpdatedDB();
        exit();
    }
    // check if anyone is gone, then output shutdown msg with who dropped.

    include "mysqlConnect.php";

    $sql = mysql_query("SELECT Active FROM Players WHERE idGame = '$game_id'");

    $currPlayer = 0;
    while($row = mysql_fetch_array($sql)){
        if ($ActivePlayer[$currPlayer] != $row['Active']){
            $ActivePlayer[$currPlayer] = $row['Active'];
            $playerDropped = $currPlayer+1;
            $msg = "PlayerDropped" . "," . $playerDropped;
            outputMessage($msg);
        }
    }

    $sql = mysql_query("SELECT * FROM Game WHERE idGame = '$game_id'");
    $row = mysql_fetch_array($sql);
    if($row['Active'] == 0){
        $msg = "shutdown" . "," . "dummymessage";
        outputMessage($msg);
        exit();
    }

    //get new turn count
    $new_turn_count = get_turn_count();

    //check if turn count has changed, if so push data
    if($new_turn_count != $turn_count){
        //update turn count
        $turn_count = $new_turn_count;

        //get pos, value, of latest
        $play_pos = get_play_pos();
        $play_value = get_play_value();

        $msg = "";

        if(gameover()){
            $msg = "endOfGameTurn" ."," .$play_pos . "," . $play_value . "," . $turn_count;
            outputMessage($msg);
            exit();
        }
        else {
            $msg = "turn" ."," .$play_pos . "," . $play_value . "," . $turn_count;
            outputMessage($msg);
        }

    }

    
    usleep( GAMES_CHECK_INTERVAL );
    #break; //debug usage
}

function PlayerGoneUpdatedDB(){
    include "mysqlConnect.php";
    global $player_id;

    $NotActive = 0;
    $sql = mysql_query("UPDATE Players SET Active = '$NotActive' WHERE idPlayers = '$player_id'");

}
function gameover() {
    global $row_size, $col_size;
    $tiles = $row_size * $col_size;

    //this will make sure that all players have fair number of turns.
    if (get_turn_count() >= ($tiles - ($tiles % 3))){
        return true;
    }
    else {
        false;
    }
}

function getSizeAverage(){

    include "mysqlConnect.php";
    //get player count;
    #$game_id = intval($GLOBALS['game_id']);
    global $game_id, $total_cell_count;
    $sql = mysql_query("SELECT AVG(p.col_Choice) AS col_avg, AVG(p.row_Choice) AS row_avg FROM Players p WHERE p.game_ID = '$game_id'");
    $rows = mysql_fetch_array($sql);
    $total_cell_count = intval($rows['col_avg']) * intval($rows['row_avg']);
    return strval(intval($rows['col_avg']) . "," . intval($rows['row_avg']));
}

function waited_for_play(){
    $msg = "autoPlay";
    outputMessage($msg);
}

#
# END OF SCRIPT - functions follow
#
function check_player_count()
{
    include "mysqlConnect.php";
    $count =0;
    //get player count;
    global $game_id;
    #$game_id = intval($GLOBALS['game_id']);
    $sql = mysql_query("SELECT * FROM Players WHERE game_ID = '$game_id'");
    $count = mysql_num_rows($sql);

    return $count;
}

function outputToBrowser($out)
{
    echo $out;
    ob_flush();
    flush();
}

function outputMessage($msg)
{
    outputToBrowser( $msg . MESSAGE_DELIMITER );
}

function handleShutdown()
{
    $connectionStatus = connection_status();

    if ( $connectionStatus == 1)
    {
        // User aborted - take appropriate action
        return true;

    }
    elseif ( $connectionStatus == 2 )
    {
        return true;
    }
    else
    {
        return false;
    }
}

function first_load(){
    
    global $game_id;
    $game_id = get_game_id();

    //looking to db for player pos
    $player_pos = get_player_pos();
    #$GLOBALS['game_id'] = get_game_id();
    //set play pos
    $msg = "playerId" . "," . $player_pos . "," . $game_id;
    outputMessage($msg);
}

function register_player(){


}

function get_player_pos()
{
    include "mysqlConnect.php";
    global $game_id,$row_size,$col_size,$player_id;
    #$game_id = intval($GLOBALS['game_id']);
    #$sql = mysql_query("SELECT * FROM Players WHERE game_ID = '$game_id'");
    #$currentPlayerCount = mysql_num_rows($sql);
    $Active = 1;
    mysql_query("INSERT INTO Players (game_ID, row_Choice, col_Choice, Active) VALUES ($game_id,$row_size,$col_size,$Active)") or die(mysql_error());
    $player_id = mysql_insert_id();
    return check_player_count();
    
}


function get_turn_count()
{
    include "mysqlConnect.php";
    global $game_id;
    #$game_id = intval($GLOBALS['game_id']);
    $sql = mysql_query("SELECT * FROM Game WHERE idGame = '$game_id'");
    $isGameExists = mysql_num_rows($sql);
    if($isGameExists){
        $row = mysql_fetch_array($sql);
        return $row['turn_Count'];
    }

    return -1; 
}
function get_play_pos()
{
    include "mysqlConnect.php";
    global $game_id;
    #$game_id = intval($GLOBALS['game_id']);
    $sql = mysql_query("SELECT * FROM Game WHERE idGame = '$game_id'");
    $isGameExists = mysql_num_rows($sql);
    if($isGameExists){
        $row = mysql_fetch_array($sql);
        return $row['lastPos'];
    }
    return -1;
}
function get_play_value()
{
    include "mysqlConnect.php";
    global $game_id;
    #$game_id = intval($GLOBALS['game_id']);
    $sql = mysql_query("SELECT * FROM Game WHERE idGame = '$game_id'");
    $isGameExists = mysql_num_rows($sql);
    if($isGameExists){
        $row = mysql_fetch_array($sql);
        return $row['last_Player'];
    }

    return -1;
}

function get_game_id()
{
    include "mysqlConnect.php";
    $sql = mysql_query("SELECT * FROM Game");
    $GameCount = mysql_num_rows($sql); 

    if ($GameCount == 0 ){
        makeNewGame();
        return 1;
    }

    $sqlQueryLastGame = mysql_query("SELECT * FROM Players WHERE game_ID = '$GameCount'");
    $playerCountOfTheGame = mysql_num_rows($sqlQueryLastGame);
    
    if ($playerCountOfTheGame >= 3 ){
        makeNewGame();
        return $GameCount + 1;
    }

    return $GameCount;
}



function makeNewGame()
{
    include "mysqlConnect.php";
    mysql_query("INSERT INTO Game (turn_Count) VALUES (0)") or die(mysql_error());
}

?>