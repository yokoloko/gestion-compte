<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BookedShift;
use AppBundle\Entity\Period;
use AppBundle\Entity\PeriodException;
use AppBundle\Entity\PeriodPosition;
use AppBundle\Entity\Shift;
use AppBundle\Entity\User;
use AppBundle\Form\PeriodExceptionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Validator\Constraints\DateTime;

/**
* @Route("period/exception")
*/
class PeriodExceptionController extends Controller
{
    /**
     * @Route("/", name="period_exception")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction(Request $request)
    {
        $session = new Session();
        $exception = new PeriodException();

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(PeriodExceptionType::class, $exception);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($exception);
            $em->flush();
            $session->getFlashBag()->add('success', 'La nouvelle exception a bien été créée !');
        }

        $exceptions =  $em->getRepository('AppBundle:PeriodException')->findBy(array(), array('startDate' => 'ASC'));


        return $this->render('admin/period/exception/list.html.twig', array(
            'exceptions' => $exceptions,
            'form' => $form->createView()
        ));
    }

    /**
     * Deletes a period exception entity.
     *
     * @Route("/delete/{id}", name="period_exception_delete")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, PeriodException $exception)
    {
        $session = new Session();

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('period_exception_delete', array('id' => $exception->getId())))
            ->setMethod('DELETE')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($exception);
            $em->flush();
            $session->getFlashBag()->add('success', 'L\'exception a bien été supprimée !');
        }

        return $this->redirectToRoute('period_exception');

    }

    /**
     * @Route("/edit/{id}", name="period_exception_edit")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, PeriodException $exception)
    {
        $session = new Session();

        $form = $this->createForm(PeriodExceptionType::class, $exception);
        $form->handleRequest($request);

        $deleteForm = $this->createFormBuilder()
            ->setAction($this->generateUrl('period_exception_delete', array('id' => $exception->getId())))
            ->setMethod('DELETE')
            ->getForm();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($exception);
            $em->flush();
            $session->getFlashBag()->add('success', 'L\'exception a bien été éditée !');
            return $this->redirectToRoute('period_exception');
        }

        return $this->render('admin/period/exception/edit.html.twig', array(
            "form" => $form->createView(),
            'delete_form' => $deleteForm->createView(),
            "exception" => $exception
        ));
    }
    
}