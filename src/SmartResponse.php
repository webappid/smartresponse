<?php
/**
 * Created by PhpStorm.
 * User: dyangalih
 * Date: 2019-01-21
 * Time: 23:52
 */

namespace WebAppId\SmartResponse;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

/**
 * Class SmartResponse
 * @package WebAppId\SmartResponse
 */
class SmartResponse
{
    public int $code = 200;
    public string $message = '';
    public mixed $data = null;
    public int $records_filtered = 0;
    public int $records_total = 0;
    public MetaDto|null $meta = null;

    public function result(): JsonResponse
    {
        return response()->json([
            'status' => $this->code >= 200 && $this->code < 300 ? 'success' : 'error',
            'response' => [
                'message' => $this->message,
                'data' => $this->data,
                'records_filtered' => $this->records_filtered,
                'records_total' => $this->records_total,
                'meta' => $this->meta?->toArray(),
            ]
        ], $this->code);
    }

    public function success(mixed $data = null, string $message = 'Success'): JsonResponse
    {
        $this->code = 200;
        $this->message = $message;
        $this->records_filtered = $data->total ?? 0;
        $this->meta = new MetaDto();
        $this->meta->per_page = $data?->per_page ?? 0;
        $this->meta->page = $data?->current_page ?? 0;
        $this->meta->last_page = $data?->last_page ?? 0;
        $this->data = $data?->data ?? [];
        return $this->result();
    }

    public function created(mixed $data = null, string $message = 'Created'): JsonResponse
    {
        $this->code = 201;
        $this->message = $message;
        $this->data = $data;
        return $this->result();
    }

    public function notFound(string $message = 'Not found'): JsonResponse
    {
        $this->code = 404;
        $this->message = $message;
        $this->data = null;
        return $this->result();
    }

    public function unprocessableEntity(string $message = 'Validation error', mixed $errors = null): JsonResponse
    {
        $this->code = 422;
        $this->message = $message;
        $this->data = $errors;
        return $this->result();
    }

    public function serverError(string $message = 'Internal server error'): JsonResponse
    {
        $this->code = 500;
        $this->message = $message;
        $this->data = null;
        return $this->result();
    }

    public function handle(Throwable $e): JsonResponse
    {
        if ($e instanceof ValidationException) {
            return $this->unprocessableEntity('Validation failed', $e->errors());
        }

        if ($e instanceof ModelNotFoundException) {
            return $this->notFound('Resource not found');
        }

        if ($e instanceof HttpExceptionInterface) {
            $this->code = $e->getStatusCode();
            $this->message = $e->getMessage();
            return $this->result();
        }

        return $this->serverError(config('app.debug') ? $e->getMessage() : 'Something went wrong');
    }
}
