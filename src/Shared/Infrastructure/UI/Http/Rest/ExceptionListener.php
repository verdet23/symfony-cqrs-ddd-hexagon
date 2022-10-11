<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\UI\Http\Rest;

use App\Shared\Domain\ExceptionFormatter\ExceptionFormatter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Throwable;

final class ExceptionListener
{
    private string $env;

    /**
     * @var array<class-string, int>
     */
    private array $exceptionToStatus;

    /**
     * @var iterable<ExceptionFormatter>
     */
    private iterable $exceptionFormatters;

    /**
     * @param array<class-string, int>     $exceptionToStatus
     * @param iterable<ExceptionFormatter> $exceptionFormatters
     */
    public function __construct(string $env, array $exceptionToStatus, iterable $exceptionFormatters)
    {
        $this->env = $env;
        $this->exceptionToStatus = $exceptionToStatus;
        $this->exceptionFormatters = $exceptionFormatters;
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $request = $event->getRequest();
        if ('json' !== $request->getContentType()) {
            return;
        }

        $exception = $event->getThrowable();

        if ($exception instanceof HandlerFailedException) {
            $exception = $exception->getPrevious() ?: $exception;
        }

        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/vnd.api+json');
        $response->setStatusCode($this->determineStatusCode($exception));
        $response->setData($this->getWrappedMessage($exception));

        $event->setResponse($response);
    }

    private function getErrorMessage(Throwable $exception): array
    {
        foreach ($this->exceptionFormatters as $exceptionFormatter) {
            if ($exceptionFormatter->isSuitable($exception)) {
                return $exceptionFormatter->format($exception);
            }
        }

        return [
            'error' => [
                'title' => str_replace('\\', '.', \get_class($exception)),
                'detail' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ],
        ];
    }

    private function getWrappedMessage(Throwable $exception): array
    {
        $error = $this->getErrorMessage($exception);

        if ('dev' === $this->env) {
            $error = array_merge(
                $error,
                [
                    'meta' => [
                        'file' => $exception->getFile(),
                        'line' => $exception->getLine(),
                        'message' => $exception->getMessage(),
                        'trace' => $exception->getTrace(),
                        'traceString' => $exception->getTraceAsString(),
                    ],
                ]
            );
        }

        return $error;
    }

    private function determineStatusCode(Throwable $exception): int
    {
        $exceptionClass = \get_class($exception);

        foreach ($this->exceptionToStatus as $class => $status) {
            if (is_a($exceptionClass, $class, true)) {
                return $status;
            }
        }

        // Process HttpExceptionInterface after `exceptionToStatus` to allow overrides from config
        if ($exception instanceof HttpExceptionInterface) {
            return $exception->getStatusCode();
        }

        // Default status code is always 500
        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }
}
