<?php declare(strict_types=1);

namespace Rector\Tests\Rector\ClassMethod\AddReturnTypeDeclarationRector;

use Iterator;
use Rector\Rector\ClassMethod\AddReturnTypeDeclarationRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Rector\Tests\Rector\ClassMethod\AddReturnTypeDeclarationRector\Source\PHPUnitTestCase;

final class AddReturnTypeDeclarationRectorTest extends AbstractRectorTestCase
{
    /**
     * @dataProvider provideDataForTest()
     */
    public function test(string $file): void
    {
        $this->doTestFile($file);
    }

    public function provideDataForTest(): Iterator
    {
        yield [__DIR__ . '/Fixture/fixture.php.inc'];
        yield [__DIR__ . '/Fixture/extended_parent.php.inc'];
    }

    /**
     * @return mixed[]
     */
    protected function getRectorsWithConfiguration(): array
    {
        return [
            AddReturnTypeDeclarationRector::class => [
                '$typehintForMethodByClass' => [
                    'Rector\Tests\Rector\Typehint\AddReturnTypeDeclarationRector\Fixture\SomeClass' => [
                        'parse' => 'array',
                        'resolve' => 'SomeType',
                        'nullable' => '?SomeType',
                        'clear' => '',
                    ],
                    PHPUnitTestCase::class => [
                        'tearDown' => 'void',
                    ],
                ],
            ],
        ];
    }
}
