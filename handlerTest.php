<?php

require_once 'handler.php';
 
class handlerTest extends PHPUnit_Framework_TestCase
{
    // ...
 
    public function testPlayerPos()
    {
        $playerPos = get_player_pos();

        $this->assertEquals(1,$playerPos);
        
    }

    public function testGetGameID(){
 		$game_id = get_game_id();
 		$this->assertEquals(1,$game_id);
    }

    public function testMakeNewGmae()
    {
    	makeNewGame();
    }

    public function testGetPlayValue()
    {
    	$playValue = get_play_value();
    	$this->assertGreaterThanOrEqual(0,$playValue);
    }

    public function testPlayPos()
    {
    	$playpos = get_play_pos();
    	$this->assertGreaterThanOrEqual(0,$playpos);
    }

    public function testGetTurnCount()
    {
    	$turnCount = get_turn_count();
    	$this->assertGreaterThanOrEqual(0,$turnCount);
    }

    public function testFirstLoad()
    {
    	first_load();
    	$this->assertTrue(true);
    }

    public function testOutputBrowser()
    {
    	outputToBrowser('test');
    	$this->assertTrue(true);
    }

    public function testCheckPlayerCount(){
    	$count = check_player_count();
    	$this->assertGreaterThanOrEqual(0,$count);
    }

    public function testWait(){

    	waited_for_play();
    	$this->assertTrue(true);
    }

    public function testHandleShutdown()
    {
    	$bool = handleShutDown();
    	$this->assertTrue(!$bool);
    }

    public function testOutMsg()
    {
    	outputMessage('test');
    	$this->assertTrue(true);

    }
}
?>