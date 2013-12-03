<?php

require_once 'turn_push.php';
 
class TurnPushTest extends PHPUnit_Framework_TestCase
{
    // ...
 
    public function testPushingTurn()
    {
    	// $_POST['position'] = 1;
    	// $_POST['value'] = 1;
    	// $_POST['gameId'] = 1;
    	for ( $i = 1 ; $i <= 25 ; $i++){
        	update_db($i,3);
    	}
        $this->assertTrue(true);
    }

    public function testIncrement()
    {

    	increment_turn();
    	$this->assertTrue(true);
    }
}
?>