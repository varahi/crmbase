<?php

declare(strict_types=1);

namespace T3Dev\Infobaza\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use T3Dev\Infobaza\Traits\AbstractTrait;
use T3Dev\Infobaza\Bitrix\AuthClass;
use T3Dev\Infobaza\Domain\Repository\ChapterRepository;

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

        $companiesPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:infobaza/Classes/Bitrix/companies');
        $iniArr = parse_ini_file($companiesPath. '/'. $directory . '/app.ini');

        $ufCrmKey = $iniArr['ufCrmKey'];
        $abstractData = new AuthClass($ufCrmKey);

        if (isset($_REQUEST['token_v1'])) {
            $user = $abstractData->auth($directory);
        }

        if (isset($user['total']) && $user['total'] == 0) {
            if ($user == false) {
                $this->flashMessageService('tx_infobaza.incorrect_data', 'errorStatus', 'Error');
                $this->redirectToPage((int)$this->settings['redirectPage']);
            } else {
                // ???
                //$this->addFlashMessage('Предоставленные данные не корректны! Свяжитесь с представителем Вашего сертификата для получения технической консультации', 'Incorect data', AbstractMessage::WARNING);
            }
        }

        $randomNumber = $this->getRandomNumber();
        $this->view->assign('randomNumber', $randomNumber);

        if (isset($_SESSION['auth'])) {
            // If logged in show profile and database
            $this->view->assign('show_profile', 1);
            $this->view->assign('show_databaze', 1);
            $chapters = $this->chapterRepository->findAll();
            $this->view->assign('chapters', $chapters);
        } else {
            // If not logged in show site content and login form
            // Showing select company form
            //$this->view->assign('show_select_form', 1);
            if (isset($_GET) && !empty($_GET)) {
                // Showing auth form
                $this->view->assign('show_auth_form', 1);
            }
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
                //header("Location: http://".$_SERVER['HTTP_HOST'].$redirect);
                //exit;
            }
        }
        $this->flashMessageService('tx_infobaza.you_logged_out', 'okStatus', 'OK');
        $this->redirectToPage((int)$this->settings['redirectPage']);
    }
}
