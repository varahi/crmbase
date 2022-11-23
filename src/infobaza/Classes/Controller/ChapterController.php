<?php

declare(strict_types=1);

namespace T3Dev\Infobaza\Controller;

use AuthClass;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use T3Dev\Infobaza\Domain\Repository\ChapterRepository;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * This file is part of the "infobaza" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2022 Dmitry Vasilev <info@t3dev.ru>, Cygenic
 */

require_once(__DIR__ . '/AuthClass.php');
require_once(__DIR__ . '/CrestCustom.php');

/**
 * ChapterController
 */
class ChapterController extends ActionController
{

    /**
     * @var string
     */
    protected $ufCrmKey = 'UF_CRM_1639293355867';

    /**
     * chapterRepository
     *
     * @var ChapterRepository
     */
    protected $chapterRepository = null;

    /**
     * @param ChapterRepository $chapterRepository
     */
    public function injectChapterRepository(ChapterRepository $chapterRepository)
    {
        $this->chapterRepository = $chapterRepository;
    }

    /**
     * action auth
     *
     * @return string|object|null|void
     */
    public function indexAction()
    {
        $abstractData = new AuthClass($this->ufCrmKey);
        $directory = 'save_drive';
        if (isset($_REQUEST['token_v1'])) {
            $user = $abstractData->auth($directory);
        }

        if (isset($user['total']) && $user['total'] == 0) {
            if ($user == false) {
                $this->flashMessageService('tx_infobaza.incorrect_data', 'errorStatus', 'ERROR');
                $this->redirectToPage((int)$this->settings['redirectPage']);
            }
        }

        //\TYPO3\CMS\Core\Utility\DebugUtility::debug($_SESSION);

        if (isset($_SESSION['auth'])) {
            $chapters = $this->chapterRepository->findAll();
            $this->view->assign('chapters', $chapters);
            $this->view->assign('user', $user);
            $this->view->assign('showDatabase', true);
        } else {
            $this->view->assign('showAuthForm', true);
        }
    }

    /**
     * @return string
     */
    private function getRandomNumber()
    {
        $rand = rand(111111, 999999).rand(111111, 999999);
        return $rand;
    }

    /**
     * Action logout
     *
     * @return string|object|null|void
     */
    public function logoutAction()
    {
        if (session_id()) {
            if (isset($_GET['logout'])) {
                session_destroy();
            }
        }
        $this->flashMessageService('tx_infobaza.you_logged_out', 'okStatus', 'OK');
        $this->redirectToPage((int)$this->settings['redirectPage']);
    }

    /**
     * redirect to page
     *
     * @return void
     */
    protected function redirectToPage($pageUid)
    {
        $uriBuilder = $this->uriBuilder;
        $uri = $uriBuilder->setTargetPageUid($pageUid)->setTargetPageType(0)->build();
        $this->redirectToURI($uri, $delay=0, $statusCode=200);
    }

    /**
     * @param \string $messageKey
     * @param \string $statusKey
     * @param \string $level
     */
    public function flashMessageService($messageKey, $statusKey, $level)
    {
        switch ($level) {
            case "NOTICE":
                $level = AbstractMessage::NOTICE;
                break;
            case "INFO":
                $level = AbstractMessage::INFO;
                break;
            case "OK":
                $level = AbstractMessage::OK;
                break;
            case "WARNING":
                $level = AbstractMessage::WARNING;
                break;
            case "ERROR":
                $level = AbstractMessage::ERROR;
                break;
        }

        $this->addFlashMessage(
            LocalizationUtility::translate($messageKey, 'infobaza'),
            LocalizationUtility::translate($statusKey, 'infobaza'),
            $level,
            true
        );
    }
}
