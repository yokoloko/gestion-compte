<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BookedShift;
use AppBundle\Entity\Period;
use AppBundle\Entity\PeriodException;
use AppBundle\Entity\PeriodPosition;
use AppBundle\Entity\Shift;
use AppBundle\Entity\User;
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
* @Route("period/exception/")
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

        $form = $this->createForm('AppBundle\Form\PeriodExceptionType',$exception);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $time = $form->get('date')->getData();
            $exception->setDate(new \DateTime($time));
            $em->persist($exception);
            $em->flush();
            $session->getFlashBag()->add('success', 'La nouvelle exception a bien été créé !');
            //return $this->redirectToRoute('exception_edit',array('id'=>$exception->getId()));
        }

        $exceptions =  $em->getRepository('AppBundle:PeriodException')->findBy(array(),array('date'=>'ASC'));


        return $this->render('admin/period/exception/list.html.twig',array(
            "exceptions" => $exceptions,
            "form" => $form->createView()
        ));
    }

    /**
     * @Route("/edit/{id}", name="period_edit")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request,Period $period)
    {
        $session = new Session();

        $form = $this->createForm('AppBundle\Form\PeriodType',$period);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $time = $form->get('start')->getData();
            $period->setStart(new \DateTime($time));
            $time = $form->get('end')->getData();
            $period->setEnd(new \DateTime($time));

            $em = $this->getDoctrine()->getManager();
            $em->persist($period);
            $em->flush();
            $session->getFlashBag()->add('success', 'Le créneau type a bien été édité !');
            return $this->redirectToRoute('period');
        }

        $form->get('start')->setData($period->getStart()->format('H:i'));
        $form->get('end')->setData($period->getEnd()->format('H:i'));

        $delete_form = $this->createFormBuilder()
            ->setAction($this->generateUrl('period_delete', array('id' => $period->getId())))
            ->setMethod('DELETE')
            ->getForm();

        $positions_delete_form = array();
        foreach($period->getPositions() as $position){
            $positions_delete_form[$position->getId()] = $this->createFormBuilder()
                ->setAction($this->generateUrl('remove_position_from_period', array('period' => $period->getId(),'position' => $position->getId())))
                ->setMethod('DELETE')
                ->getForm()->createView();
        }

        return $this->render('admin/period/edit.html.twig',array(
            "form" => $form->createView(),
            "period" => $period,
            "position_form" => $this->createForm('AppBundle\Form\PeriodPositionType',new PeriodPosition(),array('action'=>$this->generateUrl('add_position_to_period',array('id'=>$period->getId()))))->createView(),
            "delete_form" => $delete_form->createView(),
            "positions_delete_form" => $positions_delete_form
        ));
    }
    
}