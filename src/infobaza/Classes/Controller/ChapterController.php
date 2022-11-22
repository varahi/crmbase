<?php

declare(strict_types=1);

namespace T3Dev\Infobaza\Controller;

use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use T3Dev\Infobaza\Domain\Repository\ChapterRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use T3Dev\Infobaza\Utility\CrestCustom as Crest;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

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
     * action index
     *
     * @return string|object|null|void
     */
    public function indexAction()
    {
        // Auth
        $directory = 'autoconsalt';
        $companiesPath = GeneralUtility::getFileAbsFileName('EXT:infobaza/Configuration/Companies');
        $iniArr = parse_ini_file($companiesPath. '/'. $directory . '/app.ini');
        $ufCrmKey = $iniArr['ufCrmKey'];
        //$abstractData = new AuthClass($ufCrmKey);
        //$abstractData = GeneralUtility::makeInstance(AuthClass::class);

        if (isset($_REQUEST['token_v1'])) {
            $user = $this->auth($directory);
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

    /**
     * @param $directory
     * @return array|mixed|string|string[]|void
     */
    public function auth($directory)
    {
        if (!session_id()) {
            session_start();
        }

        if (isset($_REQUEST['token_v1'])) {
            if (isset($_REQUEST['name_v1'])) {
                $name = strip_tags($_REQUEST['name_v1']);
            }
            if (isset($_REQUEST['secondname_v1'])) {
                $secondname = strip_tags($_REQUEST['secondname_v1']);
            }
            if (isset($_REQUEST['lastname_v1'])) {
                $lastname = strip_tags($_REQUEST['lastname_v1']);
            }
            if (isset($_REQUEST['telephone_v1'])) {
                $phone = strip_tags($_REQUEST['telephone_v1']);
                $phone = preg_replace("/[^0-9]/", '', $phone);
            }
            $cert = strip_tags($_REQUEST['cert_v1']);
        }

        if ($name!=""  && $lastname!="" && $cert!="") {
            if ($name!=""  && $lastname!="" && $cert!="") {
                $result = Crest::call(
                    'crm.deal.list',
                    $directory,
                    [
                        'filter' => [
                            $this->ufCrmKey => $cert
                        ],
                        'select' => [
                            'ID',
                            'DATE_CREATE'
                        ]
                    ]
                );
            }

            //\TYPO3\CMS\Core\Utility\DebugUtility::debug($result);
            //exit();

            if (isset($result['total']) && $result['total'] !==0) {
                $id_lead = $result['result'][0]['ID'];

                $result = Crest::call(
                    'crm.deal.contact.items.get',
                    $directory,
                    [
                        'id' => $id_lead

                    ],
                );

                if (isset($result['result'][0])) {
                    $id_contact=$result['result'][0]['CONTACT_ID'];

                    $result = Crest::call(
                        'crm.contact.get',
                        $directory,
                        [
                            'id' => $id_contact

                        ],
                    );

                    //$message = 'Предоставленные данные не корректны! Свяжитесь с представителем Вашего сертификата для получения технической консультации';

                    if (isset($result['result'])) {
                        $phone_lead = $result['result']['PHONE'][0]['VALUE'];
                        if ($name == $result['result']['NAME'] && $lastname == $result['result']['LAST_NAME']) {
                            $_SESSION['auth']=$cert;
                        } else {
                            $this->flashMessageService('tx_infobaza.incorrect_data', 'errorStatus', 'ERROR');
                            $this->redirectToPage((int)$this->settings['redirectPage']);
                        }
                    } else {
                        $this->flashMessageService('tx_infobaza.incorrect_data', 'errorStatus', 'ERROR');
                        $this->redirectToPage((int)$this->settings['redirectPage']);
                    }
                } else {
                    $this->flashMessageService('tx_infobaza.incorrect_data', 'errorStatus', 'ERROR');
                    $this->redirectToPage((int)$this->settings['redirectPage']);
                }
            } else {
                $this->flashMessageService('tx_infobaza.incorrect_data', 'errorStatus', 'ERROR');
                $this->redirectToPage((int)$this->settings['redirectPage']);
            }

            $_SESSION['auth'] = $cert;
            return $result;
        } else {
            $this->flashMessageService('tx_infobaza.incorrect_data', 'errorStatus', 'ERROR');
            $this->redirectToPage((int)$this->settings['redirectPage']);
        }
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
