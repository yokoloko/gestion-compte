<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CodeBox
 *
 * @ORM\Table(name="code_box")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CodeBoxRepository")
 * @UniqueEntity(fields={"name"}, message="Ce nom est déjà utilisé !")
 */
class CodeBox
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=55, unique=true)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=1023, nullable=true)
     */
    private $description;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Code", mappedBy="codeBox")
     * @OrderBy({"createdAt" = "DESC"})
     */
    private $codes;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="ReceivedSms", mappedBy="code_box",cascade={"persist", "remove"})
     * @OrderBy({"created_at" = "DESC"})
     */
    private $sms;

    /**
     * @var CodeBoxAccessForShifter
     * @Assert\Valid()
     * @ORM\OneToOne(targetEntity="CodeBoxAccessForShifter", mappedBy="codeBox")
     */
    private $accessForShifter;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="CodeBoxAccessByCode", mappedBy="codeBox")
     */
    private $accessesByCode;

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
     * Set name.
     *
     * @param string $name
     *
     * @return CodeBox
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description.
     *
     * @param string|null $description
     *
     * @return CodeBox
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return Collection
     */
    public function getCodes()
    {
        return $this->codes;
    }

    /**
     * @param Collection $codes
     */
    public function setCodes($codes): void
    {
        $this->codes = $codes;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->codes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sms = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add code.
     *
     * @param \AppBundle\Entity\Code $code
     *
     * @return CodeBox
     */
    public function addCode(\AppBundle\Entity\Code $code)
    {
        $this->codes[] = $code;

        return $this;
    }

    /**
     * Remove code.
     *
     * @param \AppBundle\Entity\Code $code
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeCode(\AppBundle\Entity\Code $code)
    {
        return $this->codes->removeElement($code);
    }

    /**
     * Add sm.
     *
     * @param \AppBundle\Entity\ReceivedSms $sms
     *
     * @return CodeBox
     */
    public function addSms(\AppBundle\Entity\ReceivedSms $sms)
    {
        $this->sms[] = $sms;

        return $this;
    }

    /**
     * Remove sm.
     *
     * @param \AppBundle\Entity\ReceivedSms $sms
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeSms(\AppBundle\Entity\ReceivedSms $sms)
    {
        return $this->sms->removeElement($sms);
    }

    /**
     * Get sms.
     *
     * @return Collection
     */
    public function getSms()
    {
        return $this->sms;
    }

    /**
     * @return CodeBoxAccessForShifter
     */
    public function getAccessForShifter() : ?CodeBoxAccessForShifter
    {
        return $this->accessForShifter;
    }

    /**
     * @param CodeBoxAccessForShifter $accessForShifter
     */
    public function setAccessForShifter(?CodeBoxAccessForShifter $accessForShifter): void
    {
        $this->accessForShifter = $accessForShifter;
    }

    /**
     * @return Collection|CodeBoxAccessByCode[]
     */
    public function getAccessesByCode() : ?Collection
    {
        return $this->accessesByCode;
    }

    /**
     * @param Collection $accessesByCode
     */
    public function setAccessesByCode(?Collection $accessesByCode): void
    {
        $this->accessesByCode = $accessesByCode;
    }
}
