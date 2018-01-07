<?php
namespace Crm\UserBundle    \Security\Authentication\Handler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    protected 
    $router,
    $security;
    
    public function __construct(Router $router, SecurityContext $security)
    {
        $this->router = $router;
        $this->security = $security;
    }
    
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        // URL for redirect the user to where they were before the login process begun if you want.
        // $referer_url = $request->headers->get('referer');

        // Default target for unknown roles. Everyone else go there.
                // Default target for unknown roles. Everyone else go there.
         $url = 'homepage';
         $user = $this->security->getToken()->getUser();
         if($this->security->isGranted('ROLE_ADMIN')) {
               $url = 'sales_dashboard';
               $response = new RedirectResponse($this->router->generate($url,array('type' => 1 , 'id' => 0)));
               return $response;
         }
         elseif($this->security->isGranted('ROLE_MARKETING')) {
             $url = 'marketing_dashboard';
               $response = new RedirectResponse($this->router->generate($url));
               return $response;
         }
         elseif($this->security->isGranted('ROLE_SALES_MANAGER')) {
               $url = 'sales_dashboard';
               $response = new RedirectResponse($this->router->generate($url,array('type' => 1 , 'id' => $user->getId())));
               return $response;
         }   
         elseif($this->security->isGranted('ROLE_SALES_REPRESENTATIVE')) {
              $url = 'sales_dashboard'; 
              $response = new RedirectResponse($this->router->generate($url,array('type' => 0 , 'id' => $user->getId())));
           return $response;
        }
        elseif($this->security->isGranted('ROLE_CALL_CENTER')) {
               $url = 'callcenter_log_inbound_call';
               $response = new RedirectResponse($this->router->generate($url));
               return $response;
         }
 
           $response = new RedirectResponse($this->router->generate($url,array('type' => 0 , 'id' => 0)));
         return $response;
     }
 
}