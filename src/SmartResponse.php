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
    public int $recordsFiltered = 0;
    public int $recordsTotal = 0;
    public MetaDto|null $meta = null;

    public function result(): JsonResponse
    {
        return response()->json([
            'status' => $this->code >= 200 && $this->code < 300 ? 'success' : 'error',
            'response' => [
                'message' => $this->message,
                'data' => $this->data,
                'recordsFiltered' => $this->recordsFiltered,
                'recordsTotal' => $this->recordsTotal,
                'meta' => $this->meta?->toArray(),
            ]
        ], $this->code);
    }

    public function success(mixed $data = null, string $message = 'Success'): JsonResponse
    {
        $this->code = 200;
        $this->message = $message;
        $this->recordsFiltered = $data->total ?? 0;
        $this->meta = new MetaDto();
        $this->meta->perPage = $data->per_page;
        $this->meta->page = $data->current_page;
        $this->meta->lastPage = $data->last_page;
        $this->data = $data->data;
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
