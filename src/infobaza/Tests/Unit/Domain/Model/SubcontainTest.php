<?php

declare(strict_types=1);

namespace T3Dev\Infobaza\Tests\Unit\Domain\Model;

use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 *
 * @author Dmitry Vasilev <info@t3dev.ru>
 */
class SubcontainTest extends UnitTestCase
{
    /**
     * @var \T3Dev\Infobaza\Domain\Model\Subcontain|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \T3Dev\Infobaza\Domain\Model\Subcontain::class,
            ['dummy']
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getTitleReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getTitle()
        );
    }

    /**
     * @test
     */
    public function setTitleForStringSetsTitle(): void
    {
        $this->subject->setTitle('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('title'));
    }

    /**
     * @test
     */
    public function getBodytextReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getBodytext()
        );
    }

    /**
     * @test
     */
    public function setBodytextForStringSetsBodytext(): void
    {
        $this->subject->setBodytext('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('bodytext'));
    }
}
