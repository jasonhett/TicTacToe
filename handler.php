<?php


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

//assign player position
first_load();


//Waiting for players loop
//this will check for players
while (1)
{
    $new_player_count = check_player_count();

    if ($new_player_count >= 3)
    {
        $msg = "start";
        //message browser that its ready to start
        outputMessage( $msg );
        break;
    }

    // Pause before next iteration
    usleep( JOINS_CHECK_INTERVAL );
    #break; //debug usage
}

//Once exited waiting for players while loop goes into game updating loop
while(1){
    //end if turns greater than 25
    if($turn_count > 24){
        break;
    }

    //check for people exiting game;
    if(handleShutdown()){
        $msg = "shutdown";
        outputMessage($msg);
        break;
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

        $msg = "turn" . $play_pos . "," . $play_value . "," . $turn_count;

        //push pos, value, new turn
        outputMessage($msg);

    }

    
    usleep( GAMES_CHECK_INTERVAL );
    #break; //debug usage
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
    #ob_flush();
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
    //looking to db for player pos
    $player_pos = get_player_pos();
    global $game_id;
    $game_id = get_game_id();
    #$GLOBALS['game_id'] = get_game_id();
    //set play pos
    $msg = "playerId" . "," . $player_pos;
    outputMessage($msg);
}
function get_player_pos()
{
    include "mysqlConnect.php";
    global $game_id;
    #$game_id = intval($GLOBALS['game_id']);
    $sql = mysql_query("SELECT * FROM Players WHERE game_ID = '$game_id'");
    $currentPlayerCount = mysql_num_rows($sql);

    return $currentPlayerCount + 1;
    
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
        $last_pos = strval($row['lastPos']);
        return $row[$last_pos];
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