<?php

declare(strict_types=1);

namespace T3Dev\Infobaza\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use T3Dev\Infobaza\Traits\AbstractTrait;
use T3Dev\Infobaza\Utility\AuthClass;
use T3Dev\Infobaza\Domain\Repository\ChapterRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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
class ChapterController extends ActionController
{
    use AbstractTrait;

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
     * action index
     *
     * @return string|object|null|void
     */
    public function indexAction()
    {
        // Auth
        /*if (isset($_GET['company']) && $_GET['company']) {
            $directory = $_GET['company'];
        } else {
            $directory = 'autoconsalt';
        }*/

        $directory = 'autoconsalt';
        $companiesPath = GeneralUtility::getFileAbsFileName('EXT:infobaza/Configuration/Companies');
        $iniArr = parse_ini_file($companiesPath. '/'. $directory . '/app.ini');
        $ufCrmKey = $iniArr['ufCrmKey'];
        $abstractData = new AuthClass($ufCrmKey);
        //$abstractData = GeneralUtility::makeInstance(AuthClass::class);

        if (isset($_REQUEST['token_v1'])) {
            $user = $abstractData->auth($directory);
        }

        if (empty($user) && !empty($_REQUEST)) {
            $this->flashMessageService('tx_infobaza.incorrect_data', 'errorStatus', 'ERROR');
            $this->redirectToPage((int)$this->settings['redirectPage']);
        }

        //\TYPO3\CMS\Core\Utility\DebugUtility::debug($_REQUEST);
        //exit();

        if (isset($user['total']) && $user['total'] == 0) {
            if ($user == false) {
                $this->flashMessageService('tx_infobaza.incorrect_data', 'errorStatus', 'ERROR');
                $this->redirectToPage((int)$this->settings['redirectPage']);
            }
        }

        $randomNumber = $this->getRandomNumber();
        $this->view->assign('randomNumber', $randomNumber);

        if (isset($_SESSION['auth']) && $_SESSION['auth'] !=='') {
            // If logged in show profile and database
            $this->view->assign('show_profile', true);
            $this->view->assign('show_databaze', true);
            $this->view->assign('show_auth_form', false);
            $chapters = $this->chapterRepository->findAll();
            $this->view->assign('chapters', $chapters);
            $this->view->assign('user', $user);
        } else {
            $this->view->assign('show_auth_form', true);
            $this->view->assign('show_profile', false);
            $this->view->assign('show_databaze', false);
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
}
