<?php

namespace AppBundle\Twig\Extension;

use AppBundle\Entity\Code;
use AppBundle\Entity\CodeBox;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class CodeBoxExtension extends \Twig_Extension
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;
    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(TokenStorageInterface $tokenStorage, AuthorizationCheckerInterface $authorizationChecker, EntityManagerInterface $em)
    {
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $authorizationChecker;
        $this->em = $em;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('latestCode', array($this, 'latestCode')),
        );
    }

    public function latestCode(CodeBox $codeBox) : ?Code
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();
        if (!$user) {
            return null;
        }

        $qb = $this->em->getRepository('AppBundle:Code')->createQueryBuilder('c');
        $qb->andWhere('c.codeBox = :codeBox')
            ->andWhere('c.closed = 0')
            ->addOrderBy('c.createdAt', 'DESC')
            ->setMaxResults(1)
            ->setParameter('codeBox', $codeBox);

        $code = $qb->getQuery()->getOneOrNullResult();

        if (!$code || !$this->authorizationChecker->isGranted('view', $code)) {
            return null;
        }

        return $code;
    }

}