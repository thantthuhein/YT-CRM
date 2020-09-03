# S-YwarTaw
Business Management System for YwarTaw

#### Installing Elastic Search Manually Without Docker On Windows
```
https://www.elastic.co/guide/en/elasticsearch/reference/current/windows.html

Check Elastic Search From cmd
curl -XGET 'http://localhost:9200'

Check Elastic Search From browser
http://localhost:9200/

REF :https://medium.com/@animeshblog/elasticsearch-the-beginners-cookbook-1cf30f98218
     https://madewithlove.be/how-to-integrate-elasticsearch-in-your-laravel-app-2019-edition/
     https://medium.com/@babenko.i.a/how-to-make-laravel-and-elasticsearch-become-friends-55ed7690331c
  
```

#### Installing Elastic Search Manually Without Docker On Linux

```
wget https://artifacts.elastic.co/downloads/elasticsearch/elasticsearch-7.5.0-linux-x86_64.tar.gz
wget https://artifacts.elastic.co/downloads/elasticsearch/elasticsearch-7.5.0-linux-x86_64.tar.gz.sha512
shasum -a 512 -c elasticsearch-7.5.0-linux-x86_64.tar.gz.sha512 
tar -xzf elasticsearch-7.5.0-linux-x86_64.tar.gz
cd elasticsearch-7.5.0/ 
```

Running Elastic Search
```
./bin/elasticsearch
```

REF : https://www.elastic.co/guide/en/elasticsearch/reference/current/targz.html


#### Index customer
```
composer require elasticsearch/elasticsearch
composer require laravel/scout
php artisan scout:import "App\Customer"
php artisan elastic:create-index "App\CustomerIndexConfigurator"
php artisan elastic:update-mapping "App\Customer"
curl localhost:9200/_search?

php artisan scout:import "App\Company"
php artisan elastic:create-index "App\CompanyIndexConfigurator"
php artisan elastic:update-mapping "App\Company"

php artisan scout:import "App\Project"
php artisan elastic:create-index "App\ProjectIndexConfigurator"
php artisan elastic:update-mapping "App\Project"

php artisan scout:import "App\Enquiry"
php artisan elastic:create-index "App\EnquiryIndexConfigurator"
php artisan elastic:update-mapping "App\Enquiry"

php artisan scout:import "App\Quotation"
php artisan elastic:create-index "App\QuotationIndexConfigurator"
php artisan elastic:update-mapping "App\Quotation"


```



