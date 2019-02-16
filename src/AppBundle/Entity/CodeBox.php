<?php

namespace AppBundle\Entity;

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
     * @ORM\OneToMany(targetEntity="Code", mappedBy="codeBox")
     * @OrderBy({"createdAt" = "DESC"})
     */
    private $codes;

    /**
     * @ORM\OneToMany(targetEntity="ReceivedSms", mappedBy="author",cascade={"persist", "remove"})
     * @OrderBy({"created_at" = "DESC"})
     */
    private $sms;

    /**
     * @ORM\OneToOne(targetEntity="CodeBoxAccessForShifter", mappedBy="codeBox")
     */
    private $accessForShifter;

    /**
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
     * @return mixed
     */
    public function getCodes()
    {
        return $this->codes;
    }

    /**
     * @param mixed $codes
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
     * @param \AppBundle\Entity\ReceivedSms $sm
     *
     * @return CodeBox
     */
    public function addSm(\AppBundle\Entity\ReceivedSms $sm)
    {
        $this->sms[] = $sm;

        return $this;
    }

    /**
     * Remove sm.
     *
     * @param \AppBundle\Entity\ReceivedSms $sm
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeSm(\AppBundle\Entity\ReceivedSms $sm)
    {
        return $this->sms->removeElement($sm);
    }

    /**
     * Get sms.
     *
     * @return \Doctrine\Common\Collections\Collection
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
     * @return CodeBoxAccessByCode
     */
    public function getAccessesByCode() : ?CodeBoxAccessByCode
    {
        return $this->accessesByCode;
    }

    /**
     * @param CodeBoxAccessByCode $accessesByCode
     */
    public function setAccessesByCode(?CodeBoxAccessByCode $accessesByCode): void
    {
        $this->accessesByCode = $accessesByCode;
    }
}
