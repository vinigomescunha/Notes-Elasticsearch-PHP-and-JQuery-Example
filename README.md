# Notes-Elasticsearch-PHP-and-JQuery-Example

A little example using jQuery, PHP, Elasticsearch

/**************************************************************/

References:

jQuery
http://jquery.com/

Elasticsearch
https://www.elastic.co/guide/index.html

Foundation CSS 
http://foundation.zurb.com/

SweetAlert
https://github.com/t4t5/sweetalert/

/**************************************************************/

1. Install Elasticsearch
2. Install the dependencies  via composer

php composer.phar install

3. Enable CORS to request data via ajax directly to test *is required

https://www.elastic.co/guide/en/elasticsearch/reference/1.4/modules-http.html


delete all index - to delete all test data if necessary
curl -XDELETE localhost:9200/INDEX
