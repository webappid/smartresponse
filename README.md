# SmartResponse

**SmartResponse** is a lightweight Laravel helper library that simplifies returning consistent responses, whether in JSON format for APIs or HTML rendered via Blade views. It’s perfect for APIs and controller logic that need smart decision-making for response formats.

---

## 📦 Installation

Install via Composer:

```bash
composer require webappid/smartresponse
````

---

## 🚀 Usage Examples

### ✅ Return a JSON Success Response

Use this when building API endpoints that return JSON:

```php
use Illuminate\Http\Request;
use WebAppId\SmartResponse\Response;
use WebAppId\SmartResponse\SmartResponse;

class SampleController
{
    public function store(Request $request, SampleService $service)
    {
        $response = new ResponseDto();

        try {
            $data = $service->create($request->all());
            return $response->created('Sample created', $data);
        } catch (\Throwable $e) {
            return $response->handle($e);
        }
    }
}
```

**Response Output:**
```json
{
    "code": 201,
    "message": "Create Data Success",
    "data": {
        //Your request data
    }
}
```
## 💬 Support

If you have any questions or feedback about this package, feel free to reach out:

- 📧 Email: [dyan.galih@gmail.com](mailto:dyan.galih@gmail.com)
- 💬 Telegram: [@DyanGalih](https://t.me/DyanGalih)

---

## 🧘 Happy Coding

SmartResponse helps you keep your controller code clean, consistent, and flexible.  
Happy coding with SmartResponse!
