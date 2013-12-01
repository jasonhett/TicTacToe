<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jjbeanz
 * Date: 12/1/13
 * Time: 3:25 PM
 * To change this template use File | Settings | File Templates.
 */

define( 'JOINS_CHECK_INTERVAL', 1000000 );
define( 'GAMES_CHECK_INTERVAL', 100000 );
define( 'MESSAGE_DELIMITER', '#' );
define( 'KICKSTART_LENGTH', 500 );

define( 'PULSE_MESSAGE', '.' );

register_shutdown_function('handleShutdown');

// Kickstart
outputToBrowser( str_repeat( '.', KICKSTART_LENGTH ) );


//setup player info
$player_name;
$player_id;
$turn_count = 0;

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
    $count =0;
    //get player count;


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
    //looking to db for player pos
    $player_pos = get_player_pos();
    //set play pos
    $msg = "playerId" . "," . $player_pos;
    outputMessage($msg);
}
function get_player_pos()
{
    //figure out which position
    return 1;
}

function vacant_player()
{
    //make a play
}
function get_turn_count()
{

}
function get_play_pos()
{

}
function get_play_value()
{

}

?>