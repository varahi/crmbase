<?php

declare(strict_types=1);

namespace T3Dev\Infobaza\Controller;

/**
 * This file is part of the "infobaza" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2022 Dmitry Vasilev <info@t3dev.ru>, Cygenic
 */

/**
 * ChapterController
 */
class ChapterController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * chapterRepository
     *
     * @var \T3Dev\Infobaza\Domain\Repository\ChapterRepository
     */
    protected $chapterRepository = null;

    /**
     * @param \T3Dev\Infobaza\Domain\Repository\ChapterRepository $chapterRepository
     */
    public function injectChapterRepository(\T3Dev\Infobaza\Domain\Repository\ChapterRepository $chapterRepository)
    {
        $this->chapterRepository = $chapterRepository;
    }

    /**
     * action index
     *
     * @return string|object|null|void
     */
    public function indexAction()
    {
        $chapters = $this->chapterRepository->findAll();
        $this->view->assign('chapters', $chapters);
    }

    /**
     * action list
     *
     * @return string|object|null|void
     */
    public function listAction()
    {
        $chapters = $this->chapterRepository->findAll();
        $this->view->assign('chapters', $chapters);
    }

    /**
     * action show
     *
     * @param \T3Dev\Infobaza\Domain\Model\Chapter $chapter
     * @return string|object|null|void
     */
    public function showAction(\T3Dev\Infobaza\Domain\Model\Chapter $chapter)
    {
        $this->view->assign('chapter', $chapter);
    }

    /**
     * action new
     *
     * @return string|object|null|void
     */
    public function newAction()
    {
    }

    /**
     * action create
     *
     * @param \T3Dev\Infobaza\Domain\Model\Chapter $newChapter
     * @return string|object|null|void
     */
    public function createAction(\T3Dev\Infobaza\Domain\Model\Chapter $newChapter)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->chapterRepository->add($newChapter);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \T3Dev\Infobaza\Domain\Model\Chapter $chapter
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("chapter")
     * @return string|object|null|void
     */
    public function editAction(\T3Dev\Infobaza\Domain\Model\Chapter $chapter)
    {
        $this->view->assign('chapter', $chapter);
    }

    /**
     * action update
     *
     * @param \T3Dev\Infobaza\Domain\Model\Chapter $chapter
     * @return string|object|null|void
     */
    public function updateAction(\T3Dev\Infobaza\Domain\Model\Chapter $chapter)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->chapterRepository->update($chapter);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \T3Dev\Infobaza\Domain\Model\Chapter $chapter
     * @return string|object|null|void
     */
    public function deleteAction(\T3Dev\Infobaza\Domain\Model\Chapter $chapter)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->chapterRepository->remove($chapter);
        $this->redirect('list');
    }

    /**
     * action
     *
     * @return string|object|null|void
     */
    public function Action()
    {
    }
}
