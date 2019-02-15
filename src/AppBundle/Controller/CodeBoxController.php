<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CodeBox;
use AppBundle\Form\CodeBoxType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Code box controller.
 *
 * @Route("code_box")
 */
class CodeBoxController extends Controller
{
    /**
     * @Route("/", name="code_box_list", methods={"GET"})
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @param Request $request
     * @return Response
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $codeBoxes = $em->getRepository('AppBundle:CodeBox')->findAll();

        return $this->render('admin/code_box/list.html.twig', array(
            'codeBoxes' => $codeBoxes
        ));
    }

    /**
     * @Route("/new", name="code_box_new", methods={"GET", "POST"})
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request)
    {
        $codeBox = new CodeBox();
        $session = $this->get('session');
        $form = $this->createForm(CodeBoxType::class, $codeBox);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($codeBox);
            $em->flush();

            $session->getFlashBag()->add('success', 'Le boitier à clé a bien été créé !');
            return $this->redirectToRoute('code_box_list');
        }

        return $this->render('admin/code_box/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/delete/{id}", name="code_box_delete", methods={"GET"})
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @param Request $request
     * @return Response
     */
    public function deleteAction(Request $request, CodeBox $codeBox)
    {
        $session = $this->get('session');

        $em = $this->getDoctrine()->getManager();
        $em->remove($codeBox);
        $em->flush();

        $session->getFlashBag()->add('success', 'Le boitier à clé a bien été supprimé !');
        return $this->redirectToRoute('code_box_list');
    }

    /**
     * @Route("/edit/{id}", name="code_box_edit", methods={"GET", "POST"})
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @param Request $request
     * @param CodeBox $codeBox
     * @return Response
     */
    public function editAction(Request $request, CodeBox $codeBox)
    {
        $session = $this->get('session');
        $form = $this->createForm(CodeBoxType::class, $codeBox);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $session->getFlashBag()->add('success', 'Le boitier à clé a bien été édité !');

            return $this->redirectToRoute('code_box_list');
        }

        return $this->render('admin/code_box/edit.html.twig', array(
            'form' => $form->createView(),
            'codeBox' => $codeBox
        ));

    }
}