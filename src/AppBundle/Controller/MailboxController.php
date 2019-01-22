<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Mailbox;
use AppBundle\Form\MailboxType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use PhpImap\Mailbox as ImapMailbox;

/**
 * Mailbox controller.
 *
 * @Route("mailbox")
 */
class MailboxController extends Controller
{

    /**
     * Mailboxes list
     *
     * @Route("/", name="mailbox_list")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        $mailboxes = $this->getDoctrine()->getManager()->getRepository('AppBundle:Mailbox')->findAll();
        return $this->render('admin/mailbox/list.html.twig', array('mailboxes' => $mailboxes));
    }

    /**
     * Mailbox new
     *
     * @Route("/new", name="mailbox_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request)
    {
        $session = new Session();

        $mailbox = new Mailbox();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(MailboxType::class, $mailbox);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($mailbox);
            $em->flush();

            $session->getFlashBag()->add('success', 'La nouvelle boîte mail a bien été créée !');

            return $this->redirectToRoute('mailbox_list');

        }

        return $this->render('admin/mailbox/new.html.twig', array(
            'mailbox' => $mailbox,
            'form' => $form->createView(),
        ));
    }

    /**
     * Mailbox emails
     *
     * @Route("/{id}", name="mailbox_inbox")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function inboxAction(Request $request, Mailbox $mailbox)
    {
        $config = $mailbox->getImapConfig();
        if ($config) {
            $imap = new ImapMailbox($config->getPath(), $config->getLogin(), $config->getPassword(), '/home/deshayeb/Téléchargements');
            $mailsIds = $imap->searchMailbox('ALL');
            $mails = array();
            foreach ($mailsIds as $mailId) {
                $mails[] = $imap->getMail($mailId);
            }
            return $this->render('admin/mailbox/emails.html.twig', array('mailbox' => $mailbox, 'mails' => $mails));
        } else {

        }
    }

    /**
     * Mailbox edit
     *
     * @Route("/{id}/edit", name="mailbox_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(Request $request, Mailbox $mailbox)
    {
        $session = new Session();

        $form = $this->createForm(MailboxType::class, $mailbox);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($mailbox);
            $em->flush();

            $session->getFlashBag()->add('success', 'Le boîte mail a bien été éditée !');

            return $this->redirectToRoute('mailbox_list');

        }

        return $this->render('admin/mailbox/edit.html.twig', array(
            'mailbox' => $mailbox,
            'form' => $form->createView(),
            'delete_form' => $this->getDeleteForm($mailbox)->createView(),
        ));
    }

    /**
     * Mailbox delete
     *
     * @Route("/{id}", name="mailbox_delete")
     * @Method({"DELETE"})
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function removeAction(Request $request, Mailbox $mailbox)
    {
        $session = new Session();
        $form = $this->getDeleteForm($mailbox);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mailbox);
            $em->flush();
            $session->getFlashBag()->add('success', 'La boîte mail a bien été supprimée !');
        }
        return $this->redirectToRoute('mailbox_list');
    }

    /**
     * @param Mailbox $mailbox
     * @return \Symfony\Component\Form\FormInterface
     */
    protected function getDeleteForm(Mailbox $mailbox)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mailbox_delete', array('id' => $mailbox->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

}
