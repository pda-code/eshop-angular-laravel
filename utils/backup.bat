@ECHO OFF
SET MYSQL_EXE="C:\Program Files\MySQL\MySQL Server 5.1\bin\mysqldump.exe"
SET DB_USER=root
SET DB_PWD=root

CALL %MYSQL_EXE% --user=%DB_USER% --password=%DB_PWD% codetrim_eshop > codetrim_eshop.sql
IF %ERRORLEVEL% NEQ 0 ECHO Error executing SQL file
