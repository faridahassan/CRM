<?php

namespace Crm\SandboxBundle\Controller\UserManagement;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserManagementController extends Controller
{
	public function indexAction()
	{
		$em = $this->getDoctrine()->getManager();
		$users=$em->getRepository('CrmSandboxBundle:User')->findAll();
		return $this->render('CrmSandboxBundle:UserManagement:index.html.twig', array('users'=> $users));		    
	}

	/**
	 * @ParamConverter("user", class="CrmSandboxBundle:User")
	 */
	public function toggleEnabledAction($user)
	{
		$em = $this->getDoctrine()->getManager();
		$user->setEnabled(!$user->isEnabled());
		$em->persist($user);
		$em->flush();
		return $this->redirect($this->generateUrl('crm_sandbox_user_management_manage'));	
	}

	/**
	 * @ParamConverter("user", class="CrmSandboxBundle:User")
	 */
	public function resetPasswordAction($user)
	{
		$em = $this->getDoctrine()->getManager();
		$user->setPlainPassword('123');
		$user->setPasswordRequestedAt(new \DateTime());
		$em->persist($user);
		$em->flush();
		$this->get('session')->getFlashBag()->add(
			'notice',
			$user->getUsername(). "'s Password has been successfuly reset to 123"
			);
		return $this->redirect($this->generateUrl('crm_sandbox_user_management_manage'));
	}

	/**
	 * @ParamConverter("user", class="CrmSandboxBundle:User")
	 */
	public function assignTargetAction($user, $target)
	{
		$em = $this->getDoctrine()->getManager();
		$user->setTarget($target);
		$em->persist($user);
		$em->flush();
		return new JsonResponse(['state' => 'success', 'amount' => $target, 'userId' => $user->getId(), 'userName' => $user->getName()]);
		// return $this->redirect($this->generateUrl('crm_sandbox_user_management_manage'));
	}
	/**
	 * @ParamConverter("user", class="CrmSandboxBundle:User")
	 */
	public function editUserAction(Request $request,$user)
	{
		$form = $this->createFormBuilder($user)
            ->add('username', 'text')
            ->add('name', 'text')
            ->add('email', 'text')
            ->add('save', 'submit', array('label' => 'Edit User'))
            ->getForm();
         $editUser= $user;
         $form->handleRequest($request);

    		if ($form->isSubmitted() && $form->isValid()) {
    			$em = $this->getDoctrine()->getManager();
    			$userManager=$this->get('fos_user.user_manager');
    			$users = $em->getRepository('CrmSandboxBundle:User')->findBy(['username'=>$user->getUsername()]);

    			if(count($users)>0)
    			{    			
    				foreach ($users as $oldUser) {
    			
    					if ($oldUser->getId() != $editUser->getId()) {
		    				$session = new Session();
            				$session->getFlashBag()->add('error', 'this username already exists');
            				
	    					return $this->render('CrmSandboxBundle:UserManagement:edit_user.html.twig', array('form' => $form->createView()));     					
    					}
    				}

    			}
    			$users = $em->getRepository('CrmSandboxBundle:User')->findBy(['email'=>$user->getEmail()]);
				if(count($users)>0)
    			{    			
    				foreach ($users as $oldUser) {
    					if ($oldUser->getId() != $editUser->getId()) {
		    				$session = new Session();
            				$session->getFlashBag()->add('error', 'this email already exists');
	    					return $this->render('CrmSandboxBundle:UserManagement:edit_user.html.twig', array('form' => $form->createView()));     					
    					}
    				}

    			}
    			$session = new Session();
            	$session->getFlashBag()->add('notice', 'Action completed successfuly');
    			$userManager->updateUser($editUser);

		    }

		return $this->render('CrmSandboxBundle:UserManagement:edit_user.html.twig', array('form' => $form->createView())); 
	}



}
