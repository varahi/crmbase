<?php

namespace T3Dev\Infobaza\Bitrix;

use T3Dev\Infobaza\Traits\AbstractTrait;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use T3Dev\Infobaza\Bitrix\CrestCustom;

/**
 *
 */
class AuthClass extends ActionController
{
    use AbstractTrait;

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
                $result = CrestCustom::call(
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

                //\TYPO3\CMS\Core\Utility\DebugUtility::debug($result);
                //exit();
            }

            $id_contact="";
            $id_lead="";
            $phone_lead="";

            if (isset($result['total']) && $result['total'] !==0) {
                $id_lead = $result['result'][0]['ID'];

                $result = CrestCustom::call(
                    'crm.deal.contact.items.get',
                    $directory,
                    [
                        'id' => $id_lead

                    ],
                );

                if (isset($result['result'][0])) {
                    $id_contact=$result['result'][0]['CONTACT_ID'];

                    $result = CrestCustom::call(
                        'crm.contact.get',
                        $directory,
                        [
                            'id' => $id_contact

                        ],
                    );

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
}
