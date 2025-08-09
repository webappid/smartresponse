# SmartResponse

**SmartResponse** is a lightweight Laravel helper library that simplifies returning consistent responses, whether in JSON format for APIs or HTML rendered via Blade views. It’s perfect for APIs and controller logic that need smart decision-making for response formats.

---

## 📦 Installation

Install via Composer:

```bash
composer require webappid/smartresponse
```

---

## 🚀 Usage Examples

### ✅ Return a JSON Success Response

Use this when building API endpoints that return JSON:

```php
use Illuminate\Http\Request;
use WebAppId\SmartResponse\SmartResponse;

class SampleController
{
    public function store(Request $request, SampleService $service, SmartResponse $smartResponse)
    {
        try {
            $data = $service->create($request->all());
            return $smartResponse->created($data, 'Sample created');
        } catch (\Throwable $e) {
            return $smartResponse->handle($e);
        }
    }
}
```

**Response Output:**

```json
{
  "status": "success",
  "response": {
    "message": "Sample created",
    "data": {
      // Your request data
    },
    "records_filtered": 0,
    "records_total": 0,
    "meta": null
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
