..............HOW TO USE CORS-HELPER.............
STEP 1:In the root folder of your file run this command composer require prof/cors-helper
STEP 2:put this at the top of all your code | require **DIR**.'/vendor/autoload.php';
STEP 3: place this immediately after the above line | use CorsHelper\CorsHelper;
STEP 4: Call function like this CorsHelper::GrantRequest();
This is how the default set up look like,you did not need to do this below set up,am just showing you how the default set up look like.
......THIS IS THE DEFAULT SETUP......
CorsHelper::GrantRequest([
'origin'=>['All origin'],
'method'=>['POST','GET','DELETE','PUT','PATCH','OPTIONS'],
'header'=>['X-Requested-With','token','Authorization','X-Auth-Token','Origin','Content-Type','Cache-Control','Pragma','Accept','Accept-Encoding'],
'contentType'=>'text/plain';
'credentials'=>true;
'maxAge'=>72800,
])
.......FULL DEFAULT EXAMPLE......
require **DIR**.'/vendor/autoload.php';
use CorsHelper\CorsHelper;
CorsHelper::GrantRequest();
So simple cors is enable and you can start your work without any cors problem.
NOTE:if you want to customize cors-helper,you can reset the above setup to your taste.
