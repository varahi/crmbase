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
class ContainTest extends UnitTestCase
{
    /**
     * @var \T3Dev\Infobaza\Domain\Model\Contain|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \T3Dev\Infobaza\Domain\Model\Contain::class,
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

    /**
     * @test
     */
    public function getFileReturnsInitialValueForFileReference(): void
    {
        self::assertEquals(
            null,
            $this->subject->getFile()
        );
    }

    /**
     * @test
     */
    public function setFileForFileReferenceSetsFile(): void
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setFile($fileReferenceFixture);

        self::assertEquals($fileReferenceFixture, $this->subject->_get('file'));
    }

    /**
     * @test
     */
    public function getChapterReturnsInitialValueForChapter(): void
    {
        self::assertEquals(
            null,
            $this->subject->getChapter()
        );
    }

    /**
     * @test
     */
    public function setChapterForChapterSetsChapter(): void
    {
        $chapterFixture = new \T3Dev\Infobaza\Domain\Model\Chapter();
        $this->subject->setChapter($chapterFixture);

        self::assertEquals($chapterFixture, $this->subject->_get('chapter'));
    }

    /**
     * @test
     */
    public function getSubcontainReturnsInitialValueForSubcontain(): void
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getSubcontain()
        );
    }

    /**
     * @test
     */
    public function setSubcontainForObjectStorageContainingSubcontainSetsSubcontain(): void
    {
        $subcontain = new \T3Dev\Infobaza\Domain\Model\Subcontain();
        $objectStorageHoldingExactlyOneSubcontain = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneSubcontain->attach($subcontain);
        $this->subject->setSubcontain($objectStorageHoldingExactlyOneSubcontain);

        self::assertEquals($objectStorageHoldingExactlyOneSubcontain, $this->subject->_get('subcontain'));
    }

    /**
     * @test
     */
    public function addSubcontainToObjectStorageHoldingSubcontain(): void
    {
        $subcontain = new \T3Dev\Infobaza\Domain\Model\Subcontain();
        $subcontainObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $subcontainObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($subcontain));
        $this->subject->_set('subcontain', $subcontainObjectStorageMock);

        $this->subject->addSubcontain($subcontain);
    }

    /**
     * @test
     */
    public function removeSubcontainFromObjectStorageHoldingSubcontain(): void
    {
        $subcontain = new \T3Dev\Infobaza\Domain\Model\Subcontain();
        $subcontainObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $subcontainObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($subcontain));
        $this->subject->_set('subcontain', $subcontainObjectStorageMock);

        $this->subject->removeSubcontain($subcontain);
    }
}
