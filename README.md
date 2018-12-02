# Phalcon Test

## Requirements

* PHP version :7.2.12
* Phalcon Version : 3.4.0

## Setup Instructions
### Windows
  
  * Download suitable phalcon.dll from [here](https://github.com/phalcon/cphalcon/releases/tag/v3.4.2) 
  * place the phalcon.dll in php extention(ext) directory ex:- ``php/ext``
  * add following line inside the php.ini file 
  ``extension=php_phalcon.dll ``
  
### Phalocn Dev tool 

* 
* install phalcon dev-tools from [here](https://github.com/phalcon/phalcon-devtools)
* go to environment variable 
* select system varible
* edit path varibale
* add phalcon-dev directory path
* open phalcon.bat with text editor which inside the phalcon-dev tool directory
* set PTOOLSPATH with absolute phalcontool-dev directory path
* open cmd and type phalcon 

## app Configurations
  * create empty mysql database
  * run the sql file inside the directory name sql in that databse
  * set db connections configurations in ``app/config/config.php``
  
  
  * set staticUri as a application root directory name
  eg :- "/my_test_dir/"
 
 
 