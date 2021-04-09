How init project ?  

1. Clone the project  
```git clone git@github.com:szysza26/nowme.git```
   

2. Make install project's dependencies  
```cd my-project/ ```  
```composer install```  
```php bin/console lexik:jwt:generate-keypair```   
   
  
3. Run local web server  
```symfony server:start```  

   
Example login by curl:
```curl -X POST -H "Content-Type: application/json" http://localhost/api/login_check -d '{"username":"johndoe","password":"test"}'```