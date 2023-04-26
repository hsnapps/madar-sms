<?php

namespace NotificationChannels\Madar\Test;

use NotificationChannels\Madar\MadarMessage;
use PHPUnit\Framework\TestCase;

class MadarMessageTest extends TestCase
{
    public function testPassMessageToConstructor()
    {
        $message = new MadarMessage('This is my message.');
        $this->assertEquals('This is my message.', $message->getPayloadValue('text'));
    }

    public function testCreateMessageWithCreateMethod()
    {
        $message = MadarMessage::create('This is my message.');
        $this->assertEquals('This is my message.', $message->getPayloadValue('text'));
    }

    public function testMessageCanBeSet()
    {
        $message = new MadarMessage();
        $message->content('This is my message.');
        $this->assertEquals('This is my message.', $message->getPayloadValue('text'));
    }

    public function testApiJsonResponseIsEnabledByDefault()
    {
        $message = new MadarMessage('This is my message.');
        $this->assertEquals(1, $message->getPayloadValue('json'));
    }

    public function testMessageCanReturnPayloadAsArray()
    {
        $message = (new MadarMessage('This is my message.'))
            ->debug()
            ->from('SMS')
            ->to('123456789')
            ->flash();

        $expected = [
            'json' => 1,
            'from' => 'SMS',
            'to' => '123456789',
            'text' => 'This is my message.',
            'flash' => 1,
            'debug' => 1,
        ];

        $this->assertEquals($expected, $message->toArray());
    }
}
