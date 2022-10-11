<?php

declare(strict_types=1);

namespace App\User\UI\Http\Rest;

use App\User\Application\Command\SignUp\Command;
use App\User\Domain\UuidGenerator;
use App\User\Domain\ValueObject\Username;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;

final class SignUp
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
    #[OA\Tag(name: 'users')]
    #[OA\RequestBody(
        description: 'Create user',
        required: true,
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'email', type: 'string', maxLength: 320, example: 'jmilton@example.com'),
                new OA\Property(
                    property: 'username',
                    type: 'string',
                    maxLength: 64,
                    minLength: 4,
                    pattern: Username::REGEX,
                    example: 'jmilton'
                ),
                new OA\Property(property: 'displayName', type: 'string', maxLength: 128, minLength: 4, example: 'John Milton'),
                new OA\Property(property: 'password', type: 'string', minLength: 7, example: 'tG.+~U+I3.tt'),
            ],
            type: 'object'
        )
    )]
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
