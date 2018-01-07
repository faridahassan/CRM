<?php

namespace Crm\SandboxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Crm\SandboxBundle\Entity\Call;
use Crm\SandboxBundle\Entity\Lead;
use Crm\SandboxBundle\Form\CallType;

/**
 * Call controller.
 *
 */
class CallController extends Controller
{

    /**
     * Lists all Call entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CrmSandboxBundle:Call')->findAll();

        return $this->render('CrmSandboxBundle:Call:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Call entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Call();

        $entity->setUser($this->getUser());
        $entity->setDate(new \DateTime());
        // $entity->setLead(new Lead());
        
        
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            // $task;

            $taskId = $request->get('task');
            if ($taskId) {
                $taskCompleted = $em->getRepository('CrmSandboxBundle:Task')->find($taskId);
                if ($taskCompleted) {
                    $taskCompleted->setDone(true);
                    $em->persist($taskCompleted);
                }

            }
            if(is_null($entity->getTask()->getType()))
            {
                $task = $entity->getTask();
                $em->remove($task);
                $entity->setTask(null);
            }
            else
            {
                $task = $entity->getTask();
                $task->setUser($this->getUser());
                $task->setLead($entity->getLead());
                $task->setCall($entity);
                $date = $task->getDate()->format('Y-m-d');
                $time = $form->get('time')->getData();
                
                $hour   = preg_split('/\:+/', $time);
                $min   = preg_split('/\s+/', $hour[1]);
                
                if($min[1]=="PM")
                {
                    $hour[0]+=12;
                    $time = $hour[0].':'.$min[0];   
                }
                else
                {
                    $time = $hour[0].':'.$min[0];
                }
                $task->setDate(\DateTime::createFromFormat('Y-m-d H:i', $date.' '.$time));
                // dump($task->getDate());
                // exit;
                $em->persist($task);
                if($this->getUser()->getGoogleAccessToken())
                {
                    $client = new \Google_Client();
                    $client->setClientId("767995864730-bc63nl4uho7j76r2mlnom8258339osf7.apps.googleusercontent.com");
                    $client->setClientSecret("YffwQ0EBeVvv7TUN8THIKudh");
                    $client->setAccessType('offline');
                    // Refresh the token if it's expired.
                    $access_token=$this->getUser()->getGoogleAccessToken();
                    $client->setAccessToken(json_encode([
                        'access_token' => $access_token,
                        'refresh_token' => $this->getUser()->getGoogleRefreshToken(),
                        'expires_in' => '3600',
                    ]));
                    
                    $service = new \Google_Service_Calendar($client);
                    $event = new \Google_Service_Calendar_Event(array(
                      'summary' => $task->getType(). ' '. $task->getLead()->getContact()->getName(),
                      'description' => $task->getComment(),
                      'start' => array(
                        'dateTime' => $task->getDate()->format('Y-m-d').'T'.$task->getDate()->format('H:m:s'),
                        'timeZone' => 'Africa/Cairo',
                      ),
                      'end' => array(
                        'dateTime' => $task->getDate()->format('Y-m-d').'T'.$task->getDate()->format('H:m:s'),
                        'timeZone' => 'Africa/Cairo',
                      ),
                      'reminders' => array(
                            'useDefault' => FALSE,
                            'overrides' => array(
                              array('method' => 'email', 'minutes' => 0),
                              array('method' => 'popup', 'minutes' => 60),
                            ),
                          ),
                    ));
                    $calendarId = 'primary';
                    $event = $service->events->insert($calendarId, $event);   

                }

            }

            
            $team;
            if ($this->getUser()->hasRole('ROLE_SALES_REPRESENTATIVE'))
            {
                $team = $this->getUser()->getTeam();
                $entity->setTeam($team);
            }
            elseif ($this->getUser()->hasRole('ROLE_SALES_MANAGER'))
            {
                $team = $this->getUser()->getLedTeam();
                $entity->setTeam($team);
            }

            
            $em->persist($entity);

            $session = new Session();
            $session->getFlashBag()->add('notice', 'Action completed successfuly');
            $em->flush();

            if($this->getUser()->hasRole('sales_representative_log_inbound_call')){
                return $this->redirect($this->generateUrl('sales_representative_log_inbound_call'));
            } else {
                return $this->redirect($this->generateUrl('callcenter_log_inbound_call'));
            }
        }

        return $this->render('CrmSandboxBundle:Call:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Call entity.
     *
     * @param Call $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Call $entity)
    {
        $form = $this->createForm(new CallType(), $entity, array(
            'action' => $this->generateUrl('call_create'),
            'method' => 'POST',
        ));
        $form->add('time', 'text', array('mapped'=>false));
        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Call entity.
     *
     */
    public function newAction()
    {
        $entity = new Call();
        $form   = $this->createCreateForm($entity);

        return $this->render('CrmSandboxBundle:Call:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Call entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmSandboxBundle:Call')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Call entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrmSandboxBundle:Call:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Call entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmSandboxBundle:Call')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Call entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrmSandboxBundle:Call:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Call entity.
    *
    * @param Call $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Call $entity)
    {
        $form = $this->createForm(new CallType(), $entity, array(
            'action' => $this->generateUrl('call_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Call entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmSandboxBundle:Call')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Call entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('call_edit', array('id' => $id)));
        }

        return $this->render('CrmSandboxBundle:Call:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Call entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CrmSandboxBundle:Call')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Call entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('call'));
    }

    /**
     * Creates a form to delete a Call entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('call_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
