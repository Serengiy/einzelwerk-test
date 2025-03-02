<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class HttpException extends Exception
{
    protected ?array $errors;
    protected ?int $statusCode;

    public function __construct(string $message, int $statusCode = Response::HTTP_BAD_REQUEST, array $errors = null)
    {
        parent::__construct($message);
        $this->statusCode = $statusCode;
        $this->errors = $errors;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getErrors(): ?array
    {
        return $this->errors;
    }

    public function render(): JsonResponse
    {
        $responseData = [
            'message' => $this->getMessage(),
        ];
        if ($this->errors !== null) {
            $responseData['errors'] = $this->errors;
        }
        return response()->json($responseData, $this->getStatusCode());
    }
}
