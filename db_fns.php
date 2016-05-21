<?php

function db_connect()
{
   $result = new mysqli('localhost', 'mdc', 'mdc123', 'medicine'); 
   if (!$result)
     throw new Exception('Could not connect to database server');
   else
     return $result;
}

?>
