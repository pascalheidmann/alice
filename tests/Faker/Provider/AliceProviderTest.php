<?php

/*
 * This file is part of the Alice package.
 *
 * (c) Nelmio <hello@nelm.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Nelmio\Alice\Faker\Provider;

use Nelmio\Alice\Definition\Fixture\SimpleFixture;
use Nelmio\Alice\Definition\SpecificationBagFactory;
use Nelmio\Alice\Throwable\Exception\NoValueForCurrentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Nelmio\Alice\Faker\Provider\AliceProvider
 */
class AliceProviderTest extends TestCase
{
    public function testIdentityReturnsTheValueUnchanged(): void
    {
        $value = $expected ='foo';
        $actual = AliceProvider::identity($value);

        static::assertEquals($expected, $actual);
    }

    public function testCurrentReturnsFixtureCurrentValue(): void
    {
        $fixture = new SimpleFixture('dummy', 'Dummy', SpecificationBagFactory::create(), $expected = 'foo');
        $expected = 'foo';

        $actual = AliceProvider::current($fixture);

        static::assertEquals($expected, $actual);
    }

    public function testCurrentThrowsAnExceptionIfFixtureHasNoCurrentValue(): void
    {
        $fixture = new SimpleFixture('dummy', 'Dummy', SpecificationBagFactory::create());

        try {
            AliceProvider::current($fixture);
            static::fail('Expected exception to be thrown.');
        } catch (NoValueForCurrentException $exception) {
            static::assertEquals(
                'No value for \'<current()>\' found for the fixture "dummy".',
                $exception->getMessage()
            );
            static::assertEquals(0, $exception->getCode());
            static::assertNull($exception->getPrevious());
        }
    }
}
