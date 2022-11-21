<?php

namespace T3Dev\Infobaza\Utility;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use T3Dev\Infobaza\Utility\CrestCustom as Crest;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;

/**
 *
 */
class AuthClass extends ActionController
{

    /**
     * @var string
     */
    protected $ufCrmKey = '';

    /**
     * @param $ufCrmKey
     */
    public function __construct(
        $ufCrmKey
    ) {
        $this->ufCrmKey = $ufCrmKey;
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
                            //$this->redirectTo('baza-dannykh', $message, 403, 'Error');
                        }
                    } else {
                        //$this->redirectTo('baza-dannykh', $message, 403, 'Error');
                    }
                } else {
                    //$this->redirectTo('baza-dannykh', $message, 403, 'Error');
                }
            } else {
                //$this->redirectTo('baza-dannykh', $message, 403, 'Error');
            }

            $_SESSION['auth'] = $cert;
            return $result;
        } else {
            //$this->flashMessageService('tx_infobaza.incorrect_data', 'errorStatus', 'ERROR');
            //$this->redirectTo('baza-dannykh', $message, 403, 'Error');
        }
    }

    /**
     * @return string
     */
    public function getDomain()
    {
        if (isset($_SERVER['HTTPS']) &&
            ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
            return 'https://'.$_SERVER['HTTP_HOST'];
        } else {
            return 'http://'.$_SERVER['HTTP_HOST'];
        }
    }

    /**
     * @param $page
     * @param $message
     * @param $statusCode
     * @return void
     */
    public function redirectTo($page, $message, $statusCode, $level)
    {
        session_start();
        $_SESSION['message'] = $message;
        $_SESSION['level'] = $level;
        header('Location:' . $this->getDomain() .'/'. $page, $statusCode);
        exit;
    }
}
