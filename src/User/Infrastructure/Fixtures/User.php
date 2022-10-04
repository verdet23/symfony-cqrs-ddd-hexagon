<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Fixtures;

use App\User\Application\Command\SignUp\Command;
use Sylius\Bundle\FixturesBundle\Fixture\AbstractFixture;
use Symfony\Component\Messenger\MessageBusInterface;

class User extends AbstractFixture
{
    public const USER_ONE_UUID = '2a503bf2-1fbd-4b64-99ad-2ac185a1eeb6';
    public const USER_ONE_PASSWORD = '2ac185a1eeb6';
    public const USER_ONE_EMAIL = 'swortzik@example.com';
    public const USER_ONE_USERNAME = 'swortzik';

    public const USER_TWO_UUID = '008cdadc-3ccf-44a0-90dd-4e0b2444c41e';
    public const USER_TWO_PASSWORD = '4e0b2444c41e';

    private MessageBusInterface $commandBus;

    /**
     * @var array<int,array<string, string>>
     */
    private array $data = [
        [
            'uuid' => self::USER_ONE_UUID,
            'email' => self::USER_ONE_EMAIL,
            'username' => self::USER_ONE_USERNAME,
            'displayName' => 'Sonny Wortzik',
            'plainPassword' => self::USER_ONE_PASSWORD,
        ],
        [
            'uuid' => self::USER_TWO_UUID,
            'email' => 'akirkland@example.com',
            'username' => 'akirkland',
            'displayName' => 'Arthur Kirkland',
            'plainPassword' => self::USER_TWO_PASSWORD,
        ],
    ];

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param array<mixed> $options
     */
    public function load(array $options): void
    {
        foreach ($this->data as $userData) {
            $command = new Command(
                $userData['uuid'],
                $userData['email'],
                $userData['username'],
                $userData['displayName'],
                $userData['plainPassword']
            );

            $this->commandBus->dispatch($command);
        }
    }

    public function getName(): string
    {
        return 'users';
    }
}
