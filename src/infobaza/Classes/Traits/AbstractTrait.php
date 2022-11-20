<?php

namespace T3Dev\Infobaza\Traits;

use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 *
 */
trait AbstractTrait
{

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
