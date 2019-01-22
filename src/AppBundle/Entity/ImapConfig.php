<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\Group;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Mailbox
 *
 * @ORM\Table(name="imap_config")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImapConfigRepository")
 */
class ImapConfig
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=256)
     */
    protected $path;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=128)
     */
    protected $login;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=128)
     */
    protected $password;

    /**
     * ImapConfig is attached to a mailbox.
     * @ORM\OneToOne(targetEntity="Mailbox", inversedBy="imapConfig")
     * @ORM\JoinColumn(name="mailbox_id", referencedColumnName="id")
     * @Assert\NotNull
     * @Assert\Valid
     */
    private $mailbox;

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getMailbox()
    {
        return $this->mailbox;
    }

    /**
     * @param mixed $mailbox
     */
    public function setMailbox($mailbox): void
    {
        $this->mailbox = $mailbox;
    }

}
