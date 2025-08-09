<?php

namespace WebAppId\SmartResponse;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

/**
 * Class SmartResponse
 *
 * Provides standardized JSON API responses for Laravel applications.
 */
class SmartResponse
{
    /**
     * HTTP status code
     * @var int
     */
    public int $code = 200;

    /**
     * Response message
     * @var string
     */
    public string $message = '';

    /**
     * Response data
     * @var mixed
     */
    public mixed $data = null;

    /**
     * Number of filtered records (for paginated responses)
     * @var int
     */
    public int $records_filtered = 0;

    /**
     * Total number of records (for paginated responses)
     * @var int
     */
    public int $records_total = 0;

    /**
     * Pagination metadata
     * @var MetaDto|null
     */
    public ?MetaDto $meta = null;

    /**
     * Build the JSON response.
     *
     * @return JsonResponse
     */
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

    /**
     * Return a success response, optionally with paginated data.
     *
     * @param array $data
     * @param string $message
     * @return JsonResponse
     */
    public function success(array $data = [], string $message = 'Success'): JsonResponse
    {
        $this->code = 200;
        $this->message = $message;

        if (!empty($data)) {
            $this->records_total = $data['total'] ?? 0;
            $this->records_filtered = $data['total'] ?? 0;
            $this->meta = new MetaDto();
            $this->meta->per_page = $data['per_page'] ?? 0;
            $this->meta->page = $data['current_page'] ?? 0;
            $this->meta->last_page = $data['last_page'] ?? 0;
            $this->data = $data['data'] ?? [];
        } else {
            $this->data = [];
        }
        return $this->result();
    }

    /**
     * Return a created response (HTTP 201).
     *
     * @param mixed $data
     * @param string $message
     * @return JsonResponse
     */
    public function created(mixed $data = null, string $message = 'Created'): JsonResponse
    {
        $this->code = 201;
        $this->message = $message;
        $this->data = $data;

        return $this->result();
    }

    /**
     * Return a not found response (HTTP 404).
     *
     * @param string $message
     * @return JsonResponse
     */
    public function notFound(string $message = 'Not found'): JsonResponse
    {
        $this->code = 404;
        $this->message = $message;
        $this->data = null;

        return $this->result();
    }

    /**
     * Return an unauthorized response (HTTP 401).
     *
     * @param string $message
     * @return JsonResponse
     */
    public function unauthorized(string $message = 'Unauthorized'): JsonResponse
    {
        $this->code = 401;
        $this->message = $message;
        $this->data = null;

        return $this->result();
    }

    /**
     * Return a forbidden response (HTTP 403).
     *
     * @param string $message
     * @return JsonResponse
     */
    public function forbidden(string $message = 'Forbidden'): JsonResponse
    {
        $this->code = 403;
        $this->message = $message;
        $this->data = null;

        return $this->result();
    }

    /**
     * Return an unprocessable entity response (HTTP 422), typically for validation errors.
     *
     * @param string $message
     * @param mixed $errors
     * @return JsonResponse
     */
    public function unprocessableEntity(string $message = 'Validation error', mixed $errors = null): JsonResponse
    {
        $this->code = 422;
        $this->message = $message;
        $this->data = $errors;

        return $this->result();
    }

    /**
     * Return a server error response (HTTP 500).
     *
     * @param string $message
     * @return JsonResponse
     */
    public function serverError(string $message = 'Internal server error'): JsonResponse
    {
        $this->code = 500;
        $this->message = $message;
        $this->data = null;

        return $this->result();
    }

    /**
     * Return a custom response with arbitrary status code and data.
     *
     * @param int $code
     * @param string $message
     * @param mixed $data
     * @return JsonResponse
     */
    public function custom(int $code, string $message = '', mixed $data = null): JsonResponse
    {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
        return $this->result();
    }

    /**
     * Handle common exceptions and return appropriate JSON responses.
     *
     * @param Throwable $e
     * @return JsonResponse
     */
    public function handle(Throwable $e): JsonResponse
    {
        if ($e instanceof ValidationException) {
            return $this->unprocessableEntity('Validation failed', $e->errors());
        }

        if ($e instanceof AuthenticationException) {
            return $this->unauthorized('You are not authenticated');
        }

        if ($e instanceof AuthorizationException) {
            return $this->forbidden('You are not authorized to perform this action');
        }

        if ($e instanceof ModelNotFoundException) {
            return $this->notFound('Resource not found');
        }

        if ($e instanceof HttpExceptionInterface) {
            $this->code = $e->getStatusCode();
            $this->message = $e->getMessage() ?: 'HTTP error';
            return $this->result();
        }

        return $this->serverError(config('app.debug') ? $e->getMessage() : 'Something went wrong');
    }
}
