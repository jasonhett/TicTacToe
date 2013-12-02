<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jjbeanz
 * Date: 12/1/13
 * Time: 4:07 PM
 * To change this template use File | Settings | File Templates.
 */

$pos =  $_POST['position'];
$value = $_POST['value'];

update_db($pos, $value);
increment_turn();


//sql functions to update db
function($pos, $value){
    //update the value at the pos
    //keep track that this is last update so we can grab it later
}
function increment_turn(){
    //increment sql turn counter
}