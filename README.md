# slim-download

This is an extension to the [SLIM framework](https://github.com/codeguy/Slim) vers.3 to download a file from a route.
It can be used to check the user permissions before of permits the downloading of a file, to count the number of download or for something else useful.

##Installation
Using composer you can add use this as your composer.json

```php
    {
        "require": {
            "simotod/slim-download": "dev-develop"
        }
    }
	
```
	
##Usage
```php
    require 'vendor/autoload.php';

    $app = new \Slim\App(); 
	
	$app->register(new \SimoTod\SlimDownload\Download());

	$app->get('/download', function ($request, $response, $args) {
		//Do some stuff here	
		
		$filepath = "/path/to/file";
		
		$response = $this->download($filepath);	
		
		return $response;
	});
	
	$app->run();
	
```

###example method
all your requests will be returning a file output.
the usage will be `$app->render( (string)$FILE_PATH, (array)$DATA);`
Downladed file use the real name and 'application/octet-stream' as content type.
Content type can be overriden by $DATA["CONTENT_TYPE"].
File name can be overriden by $DATA["FILENAME"].


```php
	$app->get('/download', function ($request, $response, $args) {
		//Do some stuff here
		
		$filepath = "/path/to/pdf";
		$data = array();
		$data["CONTENT_TYPE"] = "application/pdf";
		$data["FILENAME"] = "sample.pdf";

		$response = $this->download($filepath, $data);	
		
		return $response;
	});
	
```
