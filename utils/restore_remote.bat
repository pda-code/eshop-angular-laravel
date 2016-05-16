@ECHO OFF
SET MYSQL_EXE="C:\wamp\bin\mysql\mysql5.6.17\bin\mysql.exe"
SET DB_HOST=eu-cdbr-azure-north-e.cloudapp.net
SET DB_USER=b27d0aa3ef6df0
SET DB_PWD=68d484c2

CALL %MYSQL_EXE% --host=%DB_host% --user=%DB_USER% --password=%DB_PWD% eshop_laravel < eshop_laravel.mysql
IF %ERRORLEVEL% NEQ 0 ECHO Error executing SQL file
