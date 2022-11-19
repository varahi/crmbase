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
 * ContainController
 */
class ContainController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * containRepository
     *
     * @var \T3Dev\Infobaza\Domain\Repository\ContainRepository
     */
    protected $containRepository = null;

    /**
     * @param \T3Dev\Infobaza\Domain\Repository\ContainRepository $containRepository
     */
    public function injectContainRepository(\T3Dev\Infobaza\Domain\Repository\ContainRepository $containRepository)
    {
        $this->containRepository = $containRepository;
    }

    /**
     * action list
     *
     * @return string|object|null|void
     */
    public function listAction()
    {
        $contains = $this->containRepository->findAll();
        $this->view->assign('contains', $contains);
    }
}
