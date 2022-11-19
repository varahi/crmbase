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
class ChapterTest extends UnitTestCase
{
    /**
     * @var \T3Dev\Infobaza\Domain\Model\Chapter|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \T3Dev\Infobaza\Domain\Model\Chapter::class,
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
    public function getContainReturnsInitialValueForContain(): void
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getContain()
        );
    }

    /**
     * @test
     */
    public function setContainForObjectStorageContainingContainSetsContain(): void
    {
        $contain = new \T3Dev\Infobaza\Domain\Model\Contain();
        $objectStorageHoldingExactlyOneContain = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneContain->attach($contain);
        $this->subject->setContain($objectStorageHoldingExactlyOneContain);

        self::assertEquals($objectStorageHoldingExactlyOneContain, $this->subject->_get('contain'));
    }

    /**
     * @test
     */
    public function addContainToObjectStorageHoldingContain(): void
    {
        $contain = new \T3Dev\Infobaza\Domain\Model\Contain();
        $containObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $containObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($contain));
        $this->subject->_set('contain', $containObjectStorageMock);

        $this->subject->addContain($contain);
    }

    /**
     * @test
     */
    public function removeContainFromObjectStorageHoldingContain(): void
    {
        $contain = new \T3Dev\Infobaza\Domain\Model\Contain();
        $containObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $containObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($contain));
        $this->subject->_set('contain', $containObjectStorageMock);

        $this->subject->removeContain($contain);
    }
}
