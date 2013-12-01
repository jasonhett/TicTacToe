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

//Waiting for players loop
//this will check for players
while (1)
{
    $new_player_count = checkplayercount();

    if ($new_player_count >= 3)
    {
        //message browser that its ready to start
        outputMessage( PULSE_MESSAGE );
        //break
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

        //push pos, value, new turn
        outputMessage($play_pos);
        outputMessage($play_value);
        outputMessage($turn_count);

    }
    usleep( GAMES_CHECK_INTERVAL );

}


#
# END OF SCRIPT - functions follow
#
function checkplayercount()
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
        vacant_player();

        //closes script if true;
        return false;

    }
    elseif ( $connectionStatus == 2 )
    {
        return true;
    }
    else
    {
        return true;
    }
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