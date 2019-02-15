<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\CodeBox;
use AppBundle\Entity\User;

/**
 * ReceivedSms
 *
 * @ORM\Table(name="received_sms")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReceivedSmsRepository")
 */
class ReceivedSms
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
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="sms")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     */
    private $author;


    /**
     * @ORM\ManyToOne(targetEntity="CodeBox", inversedBy="sms")
     * @ORM\JoinColumn(name="codebox_id", referencedColumnName="id")
     */
    private $code_box;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=255)
     */
    private $content;

    /**
     * @var bool
     *
     * @ORM\Column(name="ignored", type="boolean")
     */
    private $ignored;


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
     * Set content.
     *
     * @param string $content
     *
     * @return ReceivedSms
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set ignored.
     *
     * @param bool $ignored
     *
     * @return ReceivedSms
     */
    public function setIgnored($ignored)
    {
        $this->ignored = $ignored;

        return $this;
    }

    /**
     * Get ignored.
     *
     * @return bool
     */
    public function getIgnored()
    {
        return $this->ignored;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return ReceivedSms
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set author.
     *
     * @param \AppBundle\Entity\User|null $author
     *
     * @return ReceivedSms
     */
    public function setAuthor(\AppBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author.
     *
     * @return \AppBundle\Entity\User|null
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set codeBox.
     *
     * @param \AppBundle\Entity\CodeBox|null $codeBox
     *
     * @return ReceivedSms
     */
    public function setCodeBox(\AppBundle\Entity\CodeBox $codeBox = null)
    {
        $this->code_box = $codeBox;

        return $this;
    }

    /**
     * Get codeBox.
     *
     * @return \AppBundle\Entity\CodeBox|null
     */
    public function getCodeBox()
    {
        return $this->code_box;
    }
}
