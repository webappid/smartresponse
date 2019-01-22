##SmartResponse
SmartResponse is a small lib to help developer to create some smart response html via blade or json object message. 

How to install:
* First you need to run this script `composer require webappid/smartresponse`
* Publish vendor for message lang asset default `php artisan vendor:publish --tag=smartresponse`
 
Sample Use in Laravel Controller:

#####Success request sample for json

```

use WebAppId\SmartResponse\Response;
use WebAppId\SmartResponse\SmartResponse;

class SampleClass{
    public function getData(Request $request, SmartResponse $smartRespone, Response $response){
        $response->setData($request);
        return $smartResponse->success($response);
    }
}
```

and the return json should be:
```
{
    "code": 200,
    "message": "Get Data Success",
    "data" : [Should be Data From Request]
}
```

#####Success request sample for html use blade
```

use WebAppId\SmartResponse\Response;
use WebAppId\SmartResponse\SmartResponse;

class SampleClass{
    public function getData(Request $request, SmartResponse $smartRespone, Response $response){
        $response->setTemplate('test'); // ex: blade file name test.blade.php
        $response->setData($request);
        return $smartResponse->success($response);
    }
}
```

and the return json should be html generated from blade.

If you have any question about this lib. Please don't hesitate to drop me an email at dyan.galih@gmail.com or you can send me a message directly via telegram to this account @DyanGalih