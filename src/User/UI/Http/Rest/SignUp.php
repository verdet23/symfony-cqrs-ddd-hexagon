<?php

declare(strict_types=1);

namespace App\User\UI\Http\Rest;

use App\User\Application\Command\SignUp\Command;
use App\User\Domain\UuidGenerator;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;

class SignUp
{
    private MessageBusInterface $commandBus;

    private UuidGenerator $uuidGenerator;

    public function __construct(MessageBusInterface $commandBus, UuidGenerator $uuidGenerator)
    {
        $this->commandBus = $commandBus;
        $this->uuidGenerator = $uuidGenerator;
    }

    #[OA\Response(
        response: 201,
        description: 'User created'
    )]
    #[OA\Response(
        response: 400,
        description: 'Bad request'
    )]
    #[OA\Parameter(
        name: 'user',
        in: 'body',
        description: 'The field used to order rewards',
        schema: new OA\Schema(type: 'object'),
        required: true
    )]
    #[OA\Tag(name: 'users')]
    public function __invoke(Request $request): JsonResponse
    {
        $command = new Command(
            $this->uuidGenerator->generate()->toString(),
            (string) $request->request->get('email'),
            (string) $request->request->get('username'),
            (string) $request->request->get('displayName'),
            (string) $request->request->get('password')
        );

        $this->commandBus->dispatch($command);

        return new JsonResponse(null, JsonResponse::HTTP_CREATED);
    }
}
