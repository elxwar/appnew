<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_APPDatabase = "localhost";
$database_APPDatabase = "web123-a-joo-279";
$username_APPDatabase = "web123-a-joo-279";
$password_APPDatabase = "sh12ady5";
$APPDatabase = mysql_pconnect($hostname_APPDatabase, $username_APPDatabase, $password_APPDatabase) or trigger_error(mysql_error(),E_USER_ERROR); 
?>