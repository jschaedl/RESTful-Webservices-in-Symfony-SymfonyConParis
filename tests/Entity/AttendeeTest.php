<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Attendee;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class AttendeeTest extends TestCase
{
    /**
     * @dataProvider provideValidNames
     */
    public function test_name(string $firstname, string $lastname, string $name, string $expectedName): void
    {
        $attendee = new Attendee(
            Uuid::uuid4()->toString(),
            $firstname,
            $lastname,
            $name,
            'mail@janschaedlich.de'
        );

        self::assertSame($expectedName, $attendee->getName());
    }

    public function provideValidNames(): iterable
    {
        yield ['firstname', 'lastname', 'fullname', 'fullname'];
        yield ['', 'lastname', 'fullname', 'fullname'];
        yield ['firstname', '', 'fullname', 'fullname'];
        yield ['', '', 'fullname', 'fullname'];
        yield ['firstname', 'lastname', '', 'firstname lastname'];
    }

    /**
     * @dataProvider provideInvalidNames
     */
    public function test_it_throws_InvalidArgumentException_for_wrong_usage_of_name(string $firstname, string $lastname, string $name): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new Attendee(
            Uuid::uuid4()->toString(),
            $firstname,
            $lastname,
            $name,
            'mail@janschaedlich.de'
        );
    }

    public function provideInvalidNames(): iterable
    {
        yield ['', '', ''];
        yield ['firstname', '', ''];
        yield ['', 'lastname', ''];
    }
}
