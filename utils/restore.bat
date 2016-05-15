@ECHO OFF
SET MYSQL_EXE="C:\wamp\bin\mysql\mysql5.6.17\bin\mysql.exe"
SET DB_USER=root
SET DB_PWD=root

CALL %MYSQL_EXE% --user=%DB_USER% --password=%DB_PWD% eshop_laravel < eshop_laravel.mysql
IF %ERRORLEVEL% NEQ 0 ECHO Error executing SQL file
