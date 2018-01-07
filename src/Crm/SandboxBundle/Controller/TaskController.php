<?php

namespace Crm\SandboxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Crm\SandboxBundle\Entity\Task;
use Crm\SandboxBundle\Form\TaskType;

/**
 * Task controller.
 *
 */
class TaskController extends Controller
{

    /**
     * Lists all Task entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CrmSandboxBundle:Task')->findAll();

        return $this->render('CrmSandboxBundle:Task:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Task entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Task();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('task_show', array('id' => $entity->getId())));
        }

        return $this->render('CrmSandboxBundle:Task:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Task entity.
     *
     * @param Task $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Task $entity)
    {
        $form = $this->createForm(new TaskType(), $entity, array(
            'action' => $this->generateUrl('task_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Task entity.
     *
     */
    public function newAction()
    {
        $entity = new Task();
        $form   = $this->createCreateForm($entity);

        return $this->render('CrmSandboxBundle:Task:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Task entity.
     *
     */
    public function showAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('CrmSandboxBundle:Task')->getDueTasks($this->getUser());
        return $this->render('CrmSandboxBundle:Task:show.html.twig', array(
            'entities'      => $entities    
        ));
    }

    /**
     * Displays a form to edit an existing Task entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmSandboxBundle:Task')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Task entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrmSandboxBundle:Task:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Task entity.
    *
    * @param Task $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Task $entity)
    {
        $form = $this->createForm(new TaskType(), $entity, array(
            'action' => $this->generateUrl('task_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Task entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmSandboxBundle:Task')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Task entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('task_edit', array('id' => $id)));
        }

        return $this->render('CrmSandboxBundle:Task:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Task entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CrmSandboxBundle:Task')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Task entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('task'));
    }

    /**
     * Creates a form to delete a Task entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('task_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    public function rescheduleTaskAction($id,$date,$time)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CrmSandboxBundle:Task')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Task entity.');
            }

            $hour   = preg_split('/\:+/', $time);
            $min   = preg_split('/\s+/', $hour[1]);
            if($min[1]=="PM")
            {
                $hour[0]+=12;
                $time = $hour[0].':'.$min[0];
                
            }
         $entity->setDate(\DateTime::createFromFormat('Y-m-d H:i', $date.' '.$time));
         $entity->setPostponed(true);
         $em->persist($entity);
         $em->flush();
        return new JsonResponse("Success");
    }

    public function cancelAction($id,$reason)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CrmSandboxBundle:Task')->find($id);
        $entity->setCanceled(true);
        $entity->setReason($reason);
        $entity->setCancelDate(new \DateTime('now'));
         $em->persist($entity);
         $em->flush();
        return new JsonResponse("Success");
    }

    public function getMeetingsOnDateAction($user,$date)
    {
        $em = $this->getDoctrine()->getManager();
        $beginDate=\DateTime::createFromFormat('Y-m-d H:i', $date ."0:00");
        $endDate=\DateTime::createFromFormat('Y-m-d H:i', $date ."0:00");
        
        $endDate->modify('+1 day');

        $meetings= $em->getRepository('CrmSandboxBundle:Task')->getMeetingsOn($user,$beginDate,$endDate);
        
        return $this->render('CrmSandboxBundle:Task:upcoming_meetings.html.twig', array(
            'notifications'      => $meetings,
        ));
    }
}
