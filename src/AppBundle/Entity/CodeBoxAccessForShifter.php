<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CodeBoxAccessForShifter
 *
 * @ORM\Table(name="code_box_access_for_shifter")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CodeBoxAccessForShifterRepository")
 */
class CodeBoxAccessForShifter
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="before_delay", type="integer")
     */
    private $beforeDelay;

    /**
     * @var int
     *
     * @ORM\Column(name="after_delay", type="integer")
     */
    private $afterDelay;

    /**
     * @var bool
     *
     * @ORM\Column(name="can_generate", type="boolean")
     */
    private $canGenerate;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=55)
     */
    private $slug;

    /**
     * @ORM\OneToOne(targetEntity="CodeBox", inversedBy="accessForShifter", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="code_box_id", referencedColumnName="id")
     * @Assert\NotNull
     * @Assert\Valid
     */
    private $codeBox;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set beforeDelay.
     *
     * @param int $beforeDelay
     *
     * @return CodeBoxAccessForShifter
     */
    public function setBeforeDelay($beforeDelay)
    {
        $this->beforeDelay = $beforeDelay;

        return $this;
    }

    /**
     * Get beforeDelay.
     *
     * @return int
     */
    public function getBeforeDelay()
    {
        return $this->beforeDelay;
    }

    /**
     * Set afterDelay.
     *
     * @param int $afterDelay
     *
     * @return CodeBoxAccessForShifter
     */
    public function setAfterDelay($afterDelay)
    {
        $this->afterDelay = $afterDelay;

        return $this;
    }

    /**
     * Get afterDelay.
     *
     * @return int
     */
    public function getAfterDelay()
    {
        return $this->afterDelay;
    }

    /**
     * Set canGenerate.
     *
     * @param bool $canGenerate
     *
     * @return CodeBoxAccessForShifter
     */
    public function setGenerate($canGenerate)
    {
        $this->canGenerate = $canGenerate;

        return $this;
    }

    /**
     * Get canGenerate.
     *
     * @return bool
     */
    public function canGenerate()
    {
        return $this->canGenerate;
    }

    /**
     * Set slug.
     *
     * @param string $slug
     *
     * @return CodeBoxAccessForShifter
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return mixed
     */
    public function getCodeBox()
    {
        return $this->codeBox;
    }

    /**
     * @param mixed $codeBox
     */
    public function setCodeBox($codeBox): void
    {
        $this->codeBox = $codeBox;
    }
}
