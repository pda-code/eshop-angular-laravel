Demo: http://195.251.253.15:8080/eshop_laravel/public
(If the apache server is down please inform me)

## Explanation
This project is an attempt to create an open source e-commerce platform inspired from OpenCart, Prestashop e.t.c. The project uses the latest technologies (AngularJs, Bootstrap, Ticket Authentication, Models, Repositories, Services e.t.c) and also many well proven software patterns inspired from ASP.NET Mvc and WebApi. The final purpose of this project was to try to create a custom by hand front-end and to use a code generator for the backend to produce FAST Controllers/Actions/Views for the admin area based on database schema. Unfortynatelly due to lack of free time the project is temporary abandoned. 

## Local Installation (steps for installation on a windows machine)

1. Clone this repo to your desktop lets say in a folder e.g. ***c:\php_projects\eShopLaravel***
2. Create a database in mysql with name ***codetrim_eshop***
3. Run the ***c:\php_projects\eShopLaravel\utils\restore.bat*** to create sample data to the database. Edit the ***restore.bat*** to change the mysql credentials.
4. Make apache to use as document root the folder ***c:\php_projects\***
5. Change the code in ***C:\MyProjects\php\eShopLaravel\public\front\services\dataContext.js*** from 

 ```var apiRoot = 'http://195.251.253.15:8080/eShopLaravel/public/api/'``` to 
 ```var apiRoot = 'http://<host>:<port>/eShopLaravel/public/api/'```. 
 
 This line tells angular where to find Rest Services.
 
 
6. Explore the code and enjoy


## Technologies used

- AngularJs (https://angularjs.org/)
- Bootstrap (http://getbootstrap.com/)
- UI Bootstrap (https://angular-ui.github.io/bootstrap/)
- MySQL
- Bower for client side packages (http://bower.io/)
- OpenCart database (http://www.opencart.com/) 

## Software patterns used
- JWT Authentication (https://github.com/tymondesigns/jwt-auth) for REST authentication per request
- Custom angular authentication interceptor
- AngulatJS loading bar (http://chieffancypants.github.io/angular-loading-bar/)
- Custom directives for alerts.
- DataContext service for exposing REST apis to Angular in a uniform way.
- Custom directive (*collectionService.js*) for grid (and in general lists of data) with paging,sorting, filtering, includes
- Backend generic service pattern with common actions GetAll, Insert, Update, Delete e.t.c 

Happy coding!
