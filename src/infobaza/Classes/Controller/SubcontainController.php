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
 * SubcontainController
 */
class SubcontainController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * subcontainRepository
     *
     * @var \T3Dev\Infobaza\Domain\Repository\SubcontainRepository
     */
    protected $subcontainRepository = null;

    /**
     * @param \T3Dev\Infobaza\Domain\Repository\SubcontainRepository $subcontainRepository
     */
    public function injectSubcontainRepository(\T3Dev\Infobaza\Domain\Repository\SubcontainRepository $subcontainRepository)
    {
        $this->subcontainRepository = $subcontainRepository;
    }

    /**
     * action list
     *
     * @return string|object|null|void
     */
    public function listAction()
    {
        $subcontains = $this->subcontainRepository->findAll();
        $this->view->assign('subcontains', $subcontains);
    }
}
