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
 * Contain
 */
class Contain extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * title
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $title = '';

    /**
     * bodytext
     *
     * @var string
     */
    protected $bodytext = '';

    /**
     * chapter
     *
     * @var \T3Dev\Infobaza\Domain\Model\Chapter
     */
    protected $chapter = null;

    /**
     * file
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $file = null;

    /**
     * subcontain
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3Dev\Infobaza\Domain\Model\Subcontain>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $subcontain = null;

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
     * Returns the chapter
     *
     * @return \T3Dev\Infobaza\Domain\Model\Chapter
     */
    public function getChapter()
    {
        return $this->chapter;
    }

    /**
     * Sets the chapter
     *
     * @param \T3Dev\Infobaza\Domain\Model\Chapter $chapter
     * @return void
     */
    public function setChapter(\T3Dev\Infobaza\Domain\Model\Chapter $chapter)
    {
        $this->chapter = $chapter;
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
        $this->subcontain = $this->subcontain ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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

    /**
     * Adds a Subcontain
     *
     * @param \T3Dev\Infobaza\Domain\Model\Subcontain $subcontain
     * @return void
     */
    public function addSubcontain(\T3Dev\Infobaza\Domain\Model\Subcontain $subcontain)
    {
        $this->subcontain->attach($subcontain);
    }

    /**
     * Removes a Subcontain
     *
     * @param \T3Dev\Infobaza\Domain\Model\Subcontain $subcontainToRemove The Subcontain to be removed
     * @return void
     */
    public function removeSubcontain(\T3Dev\Infobaza\Domain\Model\Subcontain $subcontainToRemove)
    {
        $this->subcontain->detach($subcontainToRemove);
    }

    /**
     * Returns the subcontain
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3Dev\Infobaza\Domain\Model\Subcontain>
     */
    public function getSubcontain()
    {
        return $this->subcontain;
    }

    /**
     * Sets the subcontain
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3Dev\Infobaza\Domain\Model\Subcontain> $subcontain
     * @return void
     */
    public function setSubcontain(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $subcontain)
    {
        $this->subcontain = $subcontain;
    }
}
