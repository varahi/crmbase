<?php

declare(strict_types=1);

namespace T3Dev\Infobaza\Tests\Unit\Controller;

use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 *
 * @author Dmitry Vasilev <info@t3dev.ru>
 */
class ChapterControllerTest extends UnitTestCase
{
    /**
     * @var \T3Dev\Infobaza\Controller\ChapterController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\T3Dev\Infobaza\Controller\ChapterController::class))
            ->onlyMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function listActionFetchesAllChaptersFromRepositoryAndAssignsThemToView(): void
    {
        $allChapters = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $chapterRepository = $this->getMockBuilder(\T3Dev\Infobaza\Domain\Repository\ChapterRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $chapterRepository->expects(self::once())->method('findAll')->will(self::returnValue($allChapters));
        $this->subject->_set('chapterRepository', $chapterRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('chapters', $allChapters);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenChapterToView(): void
    {
        $chapter = new \T3Dev\Infobaza\Domain\Model\Chapter();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('chapter', $chapter);

        $this->subject->showAction($chapter);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenChapterToChapterRepository(): void
    {
        $chapter = new \T3Dev\Infobaza\Domain\Model\Chapter();

        $chapterRepository = $this->getMockBuilder(\T3Dev\Infobaza\Domain\Repository\ChapterRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $chapterRepository->expects(self::once())->method('add')->with($chapter);
        $this->subject->_set('chapterRepository', $chapterRepository);

        $this->subject->createAction($chapter);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenChapterToView(): void
    {
        $chapter = new \T3Dev\Infobaza\Domain\Model\Chapter();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('chapter', $chapter);

        $this->subject->editAction($chapter);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenChapterInChapterRepository(): void
    {
        $chapter = new \T3Dev\Infobaza\Domain\Model\Chapter();

        $chapterRepository = $this->getMockBuilder(\T3Dev\Infobaza\Domain\Repository\ChapterRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $chapterRepository->expects(self::once())->method('update')->with($chapter);
        $this->subject->_set('chapterRepository', $chapterRepository);

        $this->subject->updateAction($chapter);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenChapterFromChapterRepository(): void
    {
        $chapter = new \T3Dev\Infobaza\Domain\Model\Chapter();

        $chapterRepository = $this->getMockBuilder(\T3Dev\Infobaza\Domain\Repository\ChapterRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $chapterRepository->expects(self::once())->method('remove')->with($chapter);
        $this->subject->_set('chapterRepository', $chapterRepository);

        $this->subject->deleteAction($chapter);
    }
}
