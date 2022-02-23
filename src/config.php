<?php 
if(!defined('host'))
{
    define('host', 'dijkstra.ug.bcc.bilkent.edu.tr');
}
   
if(!defined('dbname'))
{
    define('dbname', ' ');
}
    
if(!defined('username'))
{
    define('username', ' ');
}

if(!defined('pwd'))
{
    define('pwd', ' ');
}

$mysqli = new mysqli(host, username, pwd, dbname);

if($mysqli->connect_errno)
{
    echo "Connection failed";
}

?>