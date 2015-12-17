Demo: http://195.251.253.15:8080/eShopLaravel/public 
(If the apache server is down please inform me)

## Explanation
This project is an attempt to create a an open source e-commerce platform inspired from OpenCart, Prestashop e.t.c. The project uses the latests technologies (AngularJs, Bootstrap, Ticket Authentication, Models, Repositories, Services e.t.c) and it uses many well proven software patterns. The final purpose of this project is to try to use a code generator to produce controllers/actions/views for the admin area. Unfortynatelly due to lack of free time the project is temporary abandoned.

## Local Installation

1. clone this repo to your desktop lets say in a folder e.g. ***c:\php_projects\eShopLaravel***
2. Create a database in mysql with name ***codetrim_eshop***
3. Run the ***c:\php_projects\eShopLaravel\utils\restore.bat*** to create sample data to the database. Edit the restore.bat to change the mysql credentials.
4. Make apache to use as document root the folder ***c:\php_projects\***
5. Change the the code in ***C:\MyProjects\php\eShopLaravel\public\front\services\dataContext.js*** from var apiRoot = 'http://195.251.253.15:8080/eShopLaravel/public/api/' to var apiRoot = 'http://<host>:<port>/eShopLaravel/public/api/'. This line tells angular where to find Rest Services.
6. Enjoy
7. 

## Technologies used

Happy coding!
