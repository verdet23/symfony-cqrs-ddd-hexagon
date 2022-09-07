<?php

declare(strict_types=1);

namespace App\Blog\Post\UI\Http\Rest;

use App\Blog\Post\Application\Query\Post\ByUuid\Query;
use App\Blog\Post\Domain\ValueObject\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;

class GetPost
{
    /**
     * @var MessageBusInterface
     */
    private $queryBus;

    /**
     * @param MessageBusInterface $queryBus
     */
    public function __construct(MessageBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function __invoke(Request $request)
    {
        $result = $this->queryBus->dispatch(new Query(Uuid::fromString($request->query->get('uuid'))));

        dd($result);
    }
}
