<?php

declare(strict_types=1);

namespace T3Dev\Infobaza\Domain\Model;

/**
 * This file is part of the "infobaza" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2022 Dmitry Vasilev <info@t3dev.ru>, Cygenic
 */

/**
 * Chapter
 */
class Chapter extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * title
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $title = '';

    /**
     * contain
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3Dev\Infobaza\Domain\Model\Contain>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $contain = null;

    /**
     * bodytext
     *
     * @var string
     */
    protected $bodytext = '';

    /**
     * file
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $file = null;

    /**
     * __construct
     */
    public function __construct()
    {

        // Do not remove the next line: It would break the functionality
        $this->initializeObject();
    }

    /**
     * Initializes all ObjectStorage properties when model is reconstructed from DB (where __construct is not called)
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    public function initializeObject()
    {
        $this->contain = $this->contain ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * Adds a Contain
     *
     * @param \T3Dev\Infobaza\Domain\Model\Contain $contain
     * @return void
     */
    public function addContain(\T3Dev\Infobaza\Domain\Model\Contain $contain)
    {
        $this->contain->attach($contain);
    }

    /**
     * Removes a Contain
     *
     * @param \T3Dev\Infobaza\Domain\Model\Contain $containToRemove The Contain to be removed
     * @return void
     */
    public function removeContain(\T3Dev\Infobaza\Domain\Model\Contain $containToRemove)
    {
        $this->contain->detach($containToRemove);
    }

    /**
     * Returns the contain
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3Dev\Infobaza\Domain\Model\Contain>
     */
    public function getContain()
    {
        return $this->contain;
    }

    /**
     * Sets the contain
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3Dev\Infobaza\Domain\Model\Contain> $contain
     * @return void
     */
    public function setContain(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $contain)
    {
        $this->contain = $contain;
    }

    /**
     * Returns the bodytext
     *
     * @return string
     */
    public function getBodytext()
    {
        return $this->bodytext;
    }

    /**
     * Sets the bodytext
     *
     * @param string $bodytext
     * @return void
     */
    public function setBodytext(string $bodytext)
    {
        $this->bodytext = $bodytext;
    }

    /**
     * Returns the file
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Sets the file
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $file
     * @return void
     */
    public function setFile(\TYPO3\CMS\Extbase\Domain\Model\FileReference $file)
    {
        $this->file = $file;
    }
}
