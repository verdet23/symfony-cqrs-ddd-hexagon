<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\UI\Http\Rest;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Throwable;

final class JsonBodyParserListener
{
    public function __invoke(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if (!$this->isJsonRequest($request)) {
            return;
        }

        $content = $request->getContent();
        if (empty($content)) {
            return;
        }

        if (!$this->transformJsonBody($request)) {
            $response = new Response('Unable to parse json request.', Response::HTTP_BAD_REQUEST);
            $event->setResponse($response);
        }
    }

    private function isJsonRequest(Request $request): bool
    {
        return 'json' === $request->getContentType();
    }

    private function transformJsonBody(Request $request): bool
    {
        try {
            $data = json_decode(
                (string) $request->getContent(),
                true,
                512,
                \JSON_THROW_ON_ERROR
            );
        } catch (Throwable $exception) {
            return false;
        }

        if (null === $data) {
            return true;
        }

        $request->request->replace($data);

        return true;
    }
}
