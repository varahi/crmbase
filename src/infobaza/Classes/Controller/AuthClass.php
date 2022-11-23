<?php

/**
 *
 */
class AuthClass
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
     * @return string
     */
    public function getRandomNumber()
    {
        $rand = rand(111111, 999999).rand(111111, 999999);
        return $rand;
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
            }

            //var_dump($result);

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
                            //$this->redirect('knowledgebase/', 'Предоставленные данные не корректны! Свяжитесь с представителем Вашего сертификата для получения технической консультации', 403, 'Error');
                        }
                    } else {
                        //$this->redirect('knowledgebase/', 'Предоставленные данные не корректны! Свяжитесь с представителем Вашего сертификата для получения технической консультации', 403, 'Error');
                    }
                } else {
                    //$this->redirect('knowledgebase/', 'Предоставленные данные не корректны! Свяжитесь с представителем Вашего сертификата для получения технической консультации', 403, 'Error');
                }
            } else {
                //$this->redirect('knowledgebase/', 'Предоставленные данные не корректны! Свяжитесь с представителем Вашего сертификата для получения технической консультации', 403, 'Error');
            }

            $_SESSION['auth'] = $cert;
            return $result;
        } else {
            //$this->redirect('knowledgebase/', 'Предоставленные данные не корректны! Свяжитесь с представителем Вашего сертификата для получения технической консультации', 403, 'Error');
        }
    }

    /**
     * @return void
     */
    public function logout($redirect)
    {
        if (session_id()) {
            if (isset($_GET['logout'])) {
                session_destroy();
                header("Location: http://".$_SERVER['HTTP_HOST'].$redirect);
                exit;
            }
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
    public function redirect($page, $message, $statusCode, $level)
    {
        session_start();
        $_SESSION['message'] = $message;
        $_SESSION['level'] = $level;
        header('Location:' . $this->getDomain() .'/'. $page, $statusCode);
        exit;
    }
}
