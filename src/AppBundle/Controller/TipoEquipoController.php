<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TipoEquipo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Tipoequipo controller.
 *
 * @Route("tipoequipo")
 */
class TipoEquipoController extends Controller
{
    /**
     * Lists all tipoEquipo entities.
     *
     * @Route("/", name="tipoequipo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tipoEquipos = $em->getRepository('AppBundle:TipoEquipo')->findAll();

        return $this->render('tipoequipo/index.html.twig', array(
            'tipoEquipos' => $tipoEquipos,
        ));
    }

    /**
     * Creates a new tipoEquipo entity.
     *
     * @Route("/new", name="tipoequipo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tipoEquipo = new Tipoequipo();
        $form = $this->createForm('AppBundle\Form\TipoEquipoType', $tipoEquipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipoEquipo);
            $em->flush();

            return $this->redirectToRoute('tipoequipo_show', array('id' => $tipoEquipo->getId()));
        }

        return $this->render('tipoequipo/new.html.twig', array(
            'tipoEquipo' => $tipoEquipo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a tipoEquipo entity.
     *
     * @Route("/{id}", name="tipoequipo_show")
     * @Method("GET")
     */
    public function showAction(TipoEquipo $tipoEquipo)
    {
        $deleteForm = $this->createDeleteForm($tipoEquipo);

        return $this->render('tipoequipo/show.html.twig', array(
            'tipoEquipo' => $tipoEquipo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing tipoEquipo entity.
     *
     * @Route("/{id}/edit", name="tipoequipo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TipoEquipo $tipoEquipo)
    {
        $deleteForm = $this->createDeleteForm($tipoEquipo);
        $editForm = $this->createForm('AppBundle\Form\TipoEquipoType', $tipoEquipo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tipoequipo_edit', array('id' => $tipoEquipo->getId()));
        }

        return $this->render('tipoequipo/edit.html.twig', array(
            'tipoEquipo' => $tipoEquipo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a tipoEquipo entity.
     *
     * @Route("/{id}", name="tipoequipo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TipoEquipo $tipoEquipo)
    {
        $form = $this->createDeleteForm($tipoEquipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tipoEquipo);
            $em->flush();
        }

        return $this->redirectToRoute('tipoequipo_index');
    }

    /**
     * Creates a form to delete a tipoEquipo entity.
     *
     * @param TipoEquipo $tipoEquipo The tipoEquipo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TipoEquipo $tipoEquipo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tipoequipo_delete', array('id' => $tipoEquipo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
