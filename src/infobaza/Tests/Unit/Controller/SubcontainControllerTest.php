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
class SubcontainControllerTest extends UnitTestCase
{
    /**
     * @var \T3Dev\Infobaza\Controller\SubcontainController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\T3Dev\Infobaza\Controller\SubcontainController::class))
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
    public function listActionFetchesAllSubcontainsFromRepositoryAndAssignsThemToView(): void
    {
        $allSubcontains = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $subcontainRepository = $this->getMockBuilder(\T3Dev\Infobaza\Domain\Repository\SubcontainRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $subcontainRepository->expects(self::once())->method('findAll')->will(self::returnValue($allSubcontains));
        $this->subject->_set('subcontainRepository', $subcontainRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('subcontains', $allSubcontains);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }
}
