<?php

declare(strict_types=1);

namespace App\Tests\Functional\User\UI\Http\Rest;

use App\User\Infrastructure\Fixtures\User;
use Helmich\JsonAssert\JsonAssertions;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SignUpTest extends WebTestCase
{
    use JsonAssertions;

    public function testSignUp(): void
    {
        $client = static::createClient();

        $client->jsonRequest('POST', '/api/user/sign-up', [
            'email' => 'wdormer@mail.com',
            'username' => 'wdormer',
            'displayName' => 'Will Dormer',
            'password' => 'KBd_MsU$8L',
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testSignUpAlreadyExist(): void
    {
        $client = static::createClient();

        $client->jsonRequest('POST', '/api/user/sign-up', [
            'email' => User::USER_ONE_EMAIL,
            'username' => User::USER_ONE_USERNAME,
            'displayName' => User::USER_ONE_DISPLAY_NAME,
            'password' => 'KBd_MsU$8L',
        ]);

        $this->assertResponseStatusCodeSame(400);

        $content = $client->getResponse()->getContent();

        $this->assertJsonValueEquals($content, '$.email[:1].value', User::USER_ONE_EMAIL);
        $this->assertJsonValueEquals($content, '$.email[:1].message', 'Email already exist');

        $this->assertJsonValueEquals($content, '$.username[:1].value', User::USER_ONE_USERNAME);
        $this->assertJsonValueEquals($content, '$.username[:1].message', 'Username already exist');
    }

    public function testSignUpInvalidEmail(): void
    {
        $client = static::createClient();

        $client->jsonRequest('POST', '/api/user/sign-up', [
            'email' => 'wdormermail.com',
            'username' => 'wdormer',
            'displayName' => 'Will Dormer',
            'password' => 'KBd_MsU$8L',
        ]);

        $this->assertResponseStatusCodeSame(400);

        $content = $client->getResponse()->getContent();
        $this->assertJsonValueEquals($content, '$.email[:1].value', 'wdormermail.com');
        $this->assertJsonValueEquals($content, '$.email[:1].message', 'Value "wdormermail.com" was expected to be a valid e-mail address.');
    }

    public function testSignUpInvalidUsername(): void
    {
        $client = static::createClient();

        $client->jsonRequest('POST', '/api/user/sign-up', [
            'email' => 'wdormer@mail.com',
            'username' => 'wdorm%er',
            'displayName' => 'Will Dormer',
            'password' => 'KBd_MsU$8L',
        ]);

        $this->assertResponseStatusCodeSame(400);

        $content = $client->getResponse()->getContent();
        $this->assertJsonValueEquals($content, '$.username[:1].value', 'wdorm%er');
        $this->assertJsonValueEquals($content, '$.username[:1].message', 'Value "wdorm%er" does not match expression.');
    }

    public function testSignUpInvalidDisplayName(): void
    {
        $client = static::createClient();

        $client->jsonRequest('POST', '/api/user/sign-up', [
            'email' => 'wdormer@mail.com',
            'username' => 'wdormer',
            'displayName' => 'Wi',
            'password' => 'KBd_MsU$8L',
        ]);

        $this->assertResponseStatusCodeSame(400);

        $content = $client->getResponse()->getContent();
        $this->assertJsonValueEquals($content, '$.displayName[:1].value', 'Wi');
        $this->assertJsonValueEquals($content, '$.displayName[:1].message', 'Value "Wi" is too short, it should have at least 4 characters, but only has 2 characters.');
    }
}
