<?php

declare(strict_types=1);

namespace App\Tests\Integration\User\Application\Command;

use App\User\Application\Command\SignUp\Command;
use App\User\Application\Query\ByUuid\Query;
use App\User\Domain\Query\Projections\UserView;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class SignUpTest extends KernelTestCase
{
    private MessageBusInterface $commandBus;
    private MessageBusInterface $queryBus;

    protected function setUp(): void
    {
        self::bootKernel();

        $container = static::getContainer();

        $this->commandBus = $container->get('app.command.bus');
        $this->queryBus = $container->get('app.query.bus');

        parent::setUp();
    }

    public function testSuccess(): void
    {
        $command = new Command(
            '7f62ce4a-40c1-445f-b08d-ee53d5ffbc6e',
            'tony.montana@example.com',
            'tmontana',
            'Tony Montana',
            'F9tQvnYg'
        );

        $this->commandBus->dispatch($command);

        $query = new Query('7f62ce4a-40c1-445f-b08d-ee53d5ffbc6e');

        $stamp = $this->queryBus->dispatch($query)->last(HandledStamp::class);

        $this->assertNotNull($stamp);

        $item = $stamp->getResult();

        $this->assertInstanceOf(UserView::class, $item);
        $this->assertSame('7f62ce4a-40c1-445f-b08d-ee53d5ffbc6e', $item->uuid()->toString());
        $this->assertSame('tony.montana@example.com', $item->email()->toString());
        $this->assertSame('tmontana', $item->username()->toString());
        $this->assertSame('Tony Montana', $item->displayName()->toString());
    }
}
