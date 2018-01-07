<?php

namespace Crm\SandboxBundle\Controller\Common;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Collections\ArrayCollection;
use Crm\SandboxBundle\Entity\Deal;
use Crm\SandboxBundle\Entity\Contact;
use Crm\SandboxBundle\Entity\Lead;
use Crm\SandboxBundle\Form\LeadType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends Controller
{
    public function dashboardAction($id, $type)
    {
        $cur_user = $this->getUser();

        if(is_null($id) && is_null($type)) {
            if($cur_user->hasRole('ROLE_ADMIN')) {
                $id = 0;
                $type = 1;
            }
            if($cur_user->hasRole('ROLE_SALES_REPRESENTATIVE')) {
                $id = $cur_user->getId();
                $type = 0;
            }
            if($cur_user->hasRole('ROLE_SALES_MANAGER')) {
                $team = $cur_user->getLedTeam();
                if($team)
                    $id = $team->getId();
                else
                    return $this->redirect($this->generateUrl('sales_dashboard', ['id' => $cur_user->getId(), 'type' => 0]));
                $type = 1;
            }
        }

        // Simply making sure no one can view "All" but admins.
        if(!$cur_user->hasRole('ROLE_ADMIN') && $id == 0){
            echo "You are not allowed to view this page!";exit;
        }


        // Security protection from sales manager role
        if($cur_user->hasRole('ROLE_SALES_MANAGER') && $type == 1) {
            $team = $cur_user->getLedTeam();
            if($team)
                $id = $team->getId();
            else{
                return $this->redirect($this->generateUrl('sales_dashboard', ['id' => $cur_user->getId(), 'type' => 0]));
            }
        }
        if($cur_user->hasRole('ROLE_SALES_MANAGER') && $type == 0) {
            $team = $cur_user->getLedTeam();
            $in_search_user_is_in_team = false;
            if($team){
                foreach ($team->getUsers() as $member) {
                    if ($member->getId() == $id)
                        $in_search_user_is_in_team = true;
                }
                // && $cur_user->getId()!=$id : to prevent redirect loop.
                if(!$in_search_user_is_in_team && $cur_user->getId()!=$id) {
                    return $this->redirect($this->generateUrl('sales_dashboard', ['id' => $cur_user->getId(), 'type' => 0]));       
                }
            }

        }
        
        // Security protection from sales rep role
        if($cur_user->hasRole('ROLE_SALES_REPRESENTATIVE')) {
            $id = $cur_user->getId();
            $type = 0;
        }



        $em = $this->getDoctrine()->getManager();

        $deals; $calls; $leads; $target = 0; $agents; $isAll = false; $showingId; $instToBePaid; $agents = [];

        if($this->getUser()->hasRole('ROLE_ADMIN')){
            $agents = $em->getRepository("CrmSandboxBundle:User")->findByRole("ROLE_SALES_REPRESENTATIVE");
        } elseif ($this->getUser()->hasRole('ROLE_SALES_MANAGER')) {
            if($this->getUser()->getLedTeam() !== null )
                $agents = $this->getUser()->getLedTeam()->getUsers();
            else
                $agents = [];
        }
        $teamLeaders = $em->getRepository("CrmSandboxBundle:User")->findByRole("ROLE_SALES_MANAGER");
        // $adminAsAgents = $em->getRepository("CrmSandboxBundle:User")->findByRole("ROLE_ADMIN");
        // if ($this->getUser()->hasRole('ROLE_ADMIN'))
        //     $agents = array_merge($agents, $adminAsAgents);
        // elseif ($this->getUser()->getLedTeam())
        //     $agents = $this->getUser()->getLedTeam()->getUsers();
        $team = $type;

        $teams = $em->getRepository("CrmBrookerInventoryBundle:Team")->findAll();



        if ($id == 0)
        {

            ////////////////////////////////////////////////////////////////
            // To get payments in the upcoming 2 months
            $beginDate = new \DateTime('now');
            $endDate = new \DateTime('now');
            $endDate = $endDate->modify('+60 days');
            $propertiesWithInst = $em->getRepository('CrmBrookerInventoryBundle:Property')->getPropertiesByInterval($beginDate, $endDate);
            $pendingTasks = $em->getRepository("CrmSandboxBundle:Task")->getPendingTasks($this->getUser());
            $todaysTasks = $em->getRepository("CrmSandboxBundle:Task")->getTodaysTasks($this->getUser());
            $upcomingTasks = $em->getRepository("CrmSandboxBundle:Task")->getUpcomingTasks($this->getUser());
            $cancelledTasks = $em->getRepository("CrmSandboxBundle:Task")->getCancelledTasks($this->getUser());
            $instToBePaid = 0;

            foreach ($propertiesWithInst as $property) {
                $instToBePaid += $property->getNextPaymentAmount();
            }

            ////////////////////////////////////////////////////////////////

            $deals = $em->getRepository("CrmSandboxBundle:Deal")->findAll();

            $calls = $em->getRepository("CrmSandboxBundle:Call")->findAll();

            // Select only leads that we not finalized as non potential
            $leads = $em->getRepository("CrmSandboxBundle:Lead")->findAll();

            $isAll = true;

            $showingId = 0;

            foreach ($agents as $agent) {
                $target+= $agent->getTarget();
            }
        }
        // $id > 0
        else {
            $agent = $em->getRepository("CrmSandboxBundle:User")->find($id);
            if ($type == 1) {
                $team = $em->getRepository('CrmBrookerInventoryBundle:Team')->find($id);
                
                $pendingTasks = $em->getRepository("CrmSandboxBundle:Task")->getTeamPendingTasks($em->getRepository("CrmBrookerInventoryBundle:Team")->find($id));
                $todaysTasks = $em->getRepository("CrmSandboxBundle:Task")->getTeamTodaysTasks($em->getRepository("CrmBrookerInventoryBundle:Team")->find($id));
                $upcomingTasks = $em->getRepository("CrmSandboxBundle:Task")->getTeamUpcomingTasks($em->getRepository("CrmBrookerInventoryBundle:Team")->find($id));
                $cancelledTasks = $em->getRepository("CrmSandboxBundle:Task")->getTeamCancelledTasks($em->getRepository("CrmBrookerInventoryBundle:Team")->find($id));
            }
            else
            {
                $pendingTasks = $em->getRepository("CrmSandboxBundle:Task")->getPendingTasks($em->getRepository("CrmSandboxBundle:User")->find($id));
                $todaysTasks = $em->getRepository("CrmSandboxBundle:Task")->getTodaysTasks($em->getRepository("CrmSandboxBundle:User")->find($id));
                $upcomingTasks = $em->getRepository("CrmSandboxBundle:Task")->getUpcomingTasks($em->getRepository("CrmSandboxBundle:User")->find($id));   
                $cancelledTasks = $em->getRepository("CrmSandboxBundle:Task")->getCancelledTasks($em->getRepository("CrmSandboxBundle:User")->find($id));  
            }
            // if(is_empty($agent->getDeals()))
            $deals = [];

            $calls = [];

            // Return leads that are marked with is_lead
            //$leads = $agent->getLeads();
            // $leads = $em->getRepository('CrmSandboxBundle:Lead')->getSalesRepresentativeLeads($agent->getId());

            // Removed with previous line to make dashboard specific to progress
            // $leads = $em->getRepository('CrmSandboxBundle:Lead')->findBy([
            //     'assignedSalesRep' => $agent->getId(),
            //     'isLead' => true,
            //     'closedStatus' => null,
            // ]);


            // $target = $agent->getTarget();

            $showingId = $id;

        }


        $totalValue =0;
        $totalClosedDeals =0;
        $totalDealsInProgress = 0;

        foreach ($deals as $deal) {
            if($deal->getApproved()){
                if($deal->getClosed())
                    $totalClosedDeals+= $deal->getPrice();
                //This case isn't handled because it should not happen
                //else
                //    $totalDealsInProgress+= $deal->getPrice();    
            }
            else
                $totalDealsInProgress+= $deal->getPrice();
        }
        $totalValue = $totalClosedDeals + $totalDealsInProgress;


        
        $callsNumber = 0;
        $meetingsNumber = 0;
        $inBound = 0;
        foreach ($calls as $call) {
            if($call->getIsCall()){
                $callsNumber++;
                if($call->getOrientation() == "inbound")
                    $inBound++;
            } else {
                $meetingsNumber++;
            }
        }
        $outbound = $callsNumber - $inBound;

        
        // $leadsNumber = 0;
        // foreach ($leads as $call) {
        //     $leadsNumber++;
        // }

        // get calls breakdwon

        $callsBreakdown = $this->get('crm.sandboxbundle.callsManager')->getCallsBreakdown(); 

        
        if ($id == 0)
        {
            return $this->render('CrmSandboxBundle:Common:dashboard.html.twig', array('totalValue' => $totalValue,
             'totalClosedDeals'     => $totalClosedDeals, 
             'totalDealsInProgress' => $totalDealsInProgress, 
             'callsNumber'          => $callsNumber,
             'meetingsNumber'       => $meetingsNumber,
             // 'leadsNumber'          => $leadsNumber,
             'inbound'              => $inBound,
             'outbound'             => $outbound,
             'callsBreakdown'       => $callsBreakdown,
             'isAll'                => $isAll,
             'agents'               => $agents,
             'teamLeaders'          => $teamLeaders,
             'target'               => $target,
             'showingId'            => $showingId,
             'instToBePaid'         => $instToBePaid,
             'teams'                => $teams,
             // 'teamId'               => $team,
             'pendingTasks'         => $pendingTasks,
             'todaysTasks'          => $todaysTasks,
             'upcomingTasks'        => $upcomingTasks,
             'cancelledTasks'        => $cancelledTasks,
             'type'                 => $type,
             'teams'                => $teams,
             'teamId'               => $id
             ));
        }
        else {
            return $this->render('CrmSandboxBundle:Common:dashboard.html.twig', array('totalValue' => $totalValue,
             'totalClosedDeals'     => $totalClosedDeals, 
             'totalDealsInProgress' => $totalDealsInProgress, 
             'callsNumber'          => $callsNumber,
             'meetingsNumber'       => $meetingsNumber,
             // 'leadsNumber'          => $leadsNumber,
             'inbound'              => $inBound,
             'outbound'             => $outbound,
             'callsBreakdown'       => $callsBreakdown,
             'target'               => $target,
             'isAll'                => $isAll,
             'agents'               => $agents,
             'teamLeaders'          => $teamLeaders,
             'showingId'            => $showingId,
             'pendingTasks'         =>$pendingTasks,
             'todaysTasks'          =>$todaysTasks,
             'upcomingTasks'        =>$upcomingTasks,
             'cancelledTasks'        => $cancelledTasks,
             'type'                 => $type,
             'teams'                => $teams,
             'teamId'               => $id
             ));
        }
    }

    public function is_empty($var)
    { 
     return empty($var);
    }

    public function dashboardUpcomingPropertiesAction()
    {
        $em        = $this->getDoctrine()->getManager();
        // Add a table here
        $beginDate = new \DateTime('now');
        $endDate   = new \DateTime('now');
        $endDate   = $endDate->modify('+60 days');

        $propertiesWithInst = $em->getRepository('CrmBrookerInventoryBundle:Property')->getPropertiesByInterval($beginDate, $endDate);

        return $this->render('CrmSandboxBundle:Common:dashboard_upcoming_instals.html.twig', array('properties' => $propertiesWithInst));
    }

    public function dashboardSalesRepAction()
    {
        $em    = $this->getDoctrine()->getManager();
        $deals = $this->getUser()->getDeals();
        
        $totalValue           = 0;
        $totalClosedDeals     = 0;
        $totalDealsInProgress = 0;

        foreach ($deals as $deal) {
            
            if($deal->getApproved()){
                if($deal->getClosed())
                    $totalClosedDeals+= $deal->getPrice();
            }
            else
                $totalDealsInProgress+= $deal->getPrice();

        }
        $totalValue = $totalClosedDeals + $totalDealsInProgress;


        $calls = $this->getUser()->getCallLogs();
        $callsNumber = 0;
        $meetingsNumber = 0;
        $inBound = 0;
        foreach ($calls as $call) {
            if($call->getIsCall()){
                $callsNumber++;
                if($call->getOrientation() == "inbound")
                    $inBound++;
            } else {
                $meetingsNumber++;
            }
        }
        $outbound = $callsNumber - $inBound;

        $userId      = $this->getUser()->getId();
        $leadsNumber = count($em->getRepository('CrmSandboxBundle:Lead')->getSalesRepresentativeLeads($userId));

        $pendingTasks = $em->getRepository("CrmSandboxBundle:Task")->getPendingTasks($this->getUser());
        $todaysTasks = $em->getRepository("CrmSandboxBundle:Task")->getTodaysTasks($this->getUser());
        $upcomingTasks = $em->getRepository("CrmSandboxBundle:Task")->getUpcomingTasks($this->getUser());

        return $this->render('CrmSandboxBundle:Common:dashboardrep.html.twig', array('totalValue' => $totalValue,
         'totalClosedDeals'     => $totalClosedDeals, 
         'totalDealsInProgress' => $totalDealsInProgress, 
         'callsNumber'          => $callsNumber,
         'meetingsNumber'       => $meetingsNumber,
         'leadsNumber'          => $leadsNumber,
         'inbound'              => $inBound,
         'outbound'             => $outbound,
         'pendingTasks'         =>$pendingTasks,
         'todaysTasks'          =>$todaysTasks,
         'upcomingTasks'        =>$upcomingTasks,
         'target'               => $this->getUser()->getTarget()));
    }

    // Actions = 1:Call, 2:Meeting, 3:All
    public function dashboardAdminAction($agent, $action)
    {
        $results;
        $em = $this->getDoctrine()->getManager();
        $name;
        if ($agent>0){
            $agentUser = $em->getRepository('CrmSandboxBundle:User')->find($agent);
            $name = $agentUser->getName();
            //Switch on action to decide meeting, call, lead
            $results = $agentUser->getCallLogs();
        }
        else {
            $results = $em->getRepository('CrmSandboxBundle:Call')->findAll();
            $name = "All";
        }

        $properties = [];

        foreach ($results as $result) {
            if(!$result->getIsCall()){
                $properties[$result->getId()] = [];
                foreach ($result->getProperties() as $property) {
                    array_push($properties[$result->getId()], $property->__toString());
                }
            }
        }

        

        return $this->render('CrmSandboxBundle:Common:dashboard_actions_details.html.twig', array(
                'name'       => $name,
                'properties' => $properties,
                'results'    => $results,
                'action'     => $action
            ));
    }

    public function dashboardRepAction($action)
    {
        $results;
        $em = $this->getDoctrine()->getManager();
        $name;
        
        $name = $this->getUser()->getName();
        $results = $this->getUser()->getCallLogs();

        $properties = [];

        foreach ($results as $result) {
            if(!$result->getIsCall()){
                $properties[$result->getId()] = [];
                foreach ($result->getProperties() as $property) {
                    array_push($properties[$result->getId()], $property->__toString());
                }
            }
        }

        

        return $this->render('CrmSandboxBundle:Common:dashboard_actions_details.html.twig', array(
                'name'       => $name,
                'properties' => $properties,
                'results'    => $results,
                'action'     => $action
            ));   
    }

    public function dashboardLeadsAction($agent)
    {
        $em = $this->getDoctrine()->getManager();
        $leads;
        if ($this->getUser()->hasRole('ROLE_ADMIN'))
        {
            if ($agent>0){
                //Leads of this agent
                $agent = $em->getRepository('CrmSandboxBundle:User')->find($agent);
                $leads = $agent->getLeads();
            } else {
                //Get all leads
                $leads = $em->getRepository('CrmSandboxBundle:Lead')->findBy(array(
                        'isLead' => true
                    ));
            }
        }
        else {
            $agentId = $this->getUser()->getId();
            $leads =  $em->getRepository('CrmSandboxBundle:Lead')->getLeadsBySalesRepresentative($agentId);
        }
        return $this->render('CrmSandboxBundle:Common:dashboard_leads.html.twig', array(
                'leads' => $leads
            ));
    }
    /**
     * @ParamConverter("contact", class="CrmSandboxBundle:Contact")
     */
    public function contactHistoryAction(Request $request,Contact $contact)
    {
        $leadNotificationId = $request->get('notification');
            if ($leadNotificationId) {
                $em = $this->getDoctrine()->getManager();
                $leadNotification = $em->getRepository('CrmNotificationBundle:LeadNotification')->find($leadNotificationId);
                if ($leadNotification->getToUser() == $this->getUser()) {
                    $leadNotification->setSeen(true);
                    $em->persist($leadNotification);
                    $em->flush();
                }
            }
        $actions;
        if ($this->getUser()->hasRole('ROLE_ADMIN'))
        {
            $actions = $contact->getLead()->getCalls();
        }
        else {
            //$actions = $this->getUser()->getCallLogs;
            $actions = [];
            $temps = $contact->getLead()->getCalls();   
            foreach ($temps as $temp) {
                if($temp->getUser() === $this->getUser())
                {
                    array_push($actions, $temp);
                }
            }

        }            
        if(count($contact->getLead()->getCalls())==0)
            $actions = [];

        if(!is_array($actions))
            $actions = $actions->toArray();

        
        if(sizeof($actions)>1)
            $actions = array_reverse($actions);
        $calls = array();
        $meetings = array();

        // Sort actions by date
        // usort($actions, function($a, $b) {
        //     return strtotime($a['date']) - strtotime($b['date']);
        // });



        foreach ($actions as $action) {
            # code...
            if ($action->getIsCall())
                array_push($calls, $action);
            else 
                array_push($meetings, $action);
        }

        if (count($calls)!=0) {
            $interval = date_diff($calls[0]->getDate(), new \DateTime('now'));
            $daysSinceLastCall = $interval->format('%R%a days since last call');
        } else {
            $daysSinceLastCall = 'No calls';
        }

        if (count($meetings)!=0) {
            $interval = date_diff($meetings[0]->getDate(), new \DateTime('now'));
            $daysSinceLastMetting = $interval->format('%R%a days since last meeting');
        } else {
            $daysSinceLastMetting = 'No Meetings';    
        }

        $properties = [];

        foreach ($meetings as $result) {
            if(!$result->getIsCall()){
                $properties[$result->getId()] = [];
                foreach ($result->getProperties() as $property) {
                    array_push($properties[$result->getId()], $property->__toString());
                }
            }
        }

        $lead = $contact->getLead();
        $leadForm = $this->createEditForm($lead);
        




        if($contact->getLead() !== null)
            $id = $contact->getLead()->getId();
        else
            $id = 0;

        $has_history = false;
        if($id){
            $reader = $this->get('crm.auditingbundle.auditTransformer');
            $has_history = $reader->hasHistory('Crm\SandboxBundle\Entity\Lead', $id);
        }

        return $this->render('CrmSandboxBundle:Common:contact_history.html.twig', array(
                'lead'       => $lead,
                'leadId'       => $lead->getId(),
                'leadForm'   => $leadForm->createView(),
                'leadPotential'   => $lead->getIsLead(),
                'leadPotentialReason'   => $lead->getIsLeadReason(),
                'leadInterest'   => $lead->getIsInterested(),
                'leadInterestReason'   => $lead->getIsInterestedReason(),                
                'contact'    => $contact,
                'calls'      => $calls,
                'meetings'   => $meetings,
                'properties' => $properties,
                'lastMeet'   => $daysSinceLastMetting,
                'lastCall'   => $daysSinceLastCall,
                'leadPotential'=> $lead->getIsLead(),
                'leadPotentialReason'=> $lead->getIsLeadReason(),
                'hasHistory' => $has_history
            ));

    }
    /**
     * @ParamConverter("lead", class="CrmSandboxBundle:Lead")
     */
    public function trashLeadAction(Lead $lead)
    {
        $lead->setClosedStatus(1);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($lead);
        $em->flush();

        return new JsonResponse('Success');
    }

    public function allLeadsAction($agent)
    {

        $em = $this->getDoctrine()->getManager();
        $potentialLeads = 0; $nonPotentialLeads = 0; $trashedLeads = 0; $clients = 0; $total = 0;
        // GEEHINT
        // This must be updated because this way sales reps can view progress of colleages, just update agent if not admin or sales_manager 
        if($this->getUser()->hasRole('ROLE_SALES_REPRESENTATIVE'))
            $agent = $this->getUser()->getId();
        if(!$agent)
        { 
            $potentialLeads    = count($em->getRepository('CrmSandboxBundle:Lead')->findBy(array('isLead' => true, 'closedStatus' => null)));
            $nonPotentialLeads = count($em->getRepository('CrmSandboxBundle:Lead')->findBy(array('isLead' => false, 'closedStatus' => null)));
            $trashedLeads      = count($em->getRepository('CrmSandboxBundle:Lead')->findByClosedStatus(1));
            $clients           = count($em->getRepository('CrmSandboxBundle:Lead')->findByClosedStatus(0));

            $total             = $potentialLeads + $nonPotentialLeads + $trashedLeads + $clients;
        }
        else {
            // Now find as previous but with User Id ($agent)
            $repo = $em->getRepository('CrmSandboxBundle:Lead');

            $potentialLeads    = count($repo->createQueryBuilder('l')->where('(l.assignedSalesRep = :agent or l.user = :agent) and l.isLead = true and l.closedStatus IS NULL')->setParameter('agent', $agent)->getQuery()->getResult());
            $nonPotentialLeads = count($repo->createQueryBuilder('l')->where('(l.assignedSalesRep = :agent or l.user = :agent) and l.isLead = false and l.closedStatus IS NULL')->setParameter('agent', $agent)->getQuery()->getResult());            
            $trashedLeads      = count($repo->createQueryBuilder('l')->where('(l.assignedSalesRep = :agent or l.user = :agent) and l.closedStatus = 1')->setParameter('agent', $agent)->getQuery()->getResult()); 
            $clients           = count($repo->createQueryBuilder('l')->where('(l.assignedSalesRep = :agent or l.user = :agent) and l.closedStatus = 0')->setParameter('agent', $agent)->getQuery()->getResult()); 

            $total             = $potentialLeads + $nonPotentialLeads + $trashedLeads + $clients;
        }
       
        return $this->render('CrmSandboxBundle:Common:all_leads.html.twig', array(
                'potentialLeads'    => $potentialLeads,
                'nonPotentialLeads' => $nonPotentialLeads,
                'trashedLeads'      => $trashedLeads,
                'clients'           => $clients,
                'total'             => $total,
                'showingId'         => $agent
            ));
    }
    /** The Spcifics
     * potential     : 1
     * no-potentials : 2
     * trashed       : 3
     * clients       : 4
     */
    public function specificLeadsAction($type, $agent)
    {
        $em = $this->getDoctrine()->getManager();
        $leads;
        $loggedIn = $this->getUser();
        if($loggedIn->hasRole('ROLE_SALES_REPRESENTATIVE')){
            $agent = $this->getUser()->getId();
        }
        if(!$agent)
        {
            switch($type){
                case 1:
                    $leads = $em->getRepository('CrmSandboxBundle:Lead')->findBy(array('isLead' => true, 'closedStatus' => null));
                    break;
                case 2:
                    $leads = $em->getRepository('CrmSandboxBundle:Lead')->findBy(array('isLead' => false, 'closedStatus' => null));
                    break;
                case 3:
                    $leads = $em->getRepository('CrmSandboxBundle:Lead')->findByClosedStatus(1);
                    break;
                case 4:
                    $leads = $em->getRepository('CrmSandboxBundle:Lead')->findByClosedStatus(0);
                    break;    
            }
        }
        else 
        {
            $em   = $this->getDoctrine()->getManager();
            $repo = $em->getRepository('CrmSandboxBundle:Lead');
            switch($type){
                case 1:
                    $leads = $repo->createQueryBuilder('l')->where('(l.assignedSalesRep = :agent or l.user = :agent) and l.isLead = true and l.closedStatus IS NULL')->setParameter('agent', $agent)->getQuery()->getResult();
                    break;
                case 2:
                    $leads = $repo->createQueryBuilder('l')->where('(l.assignedSalesRep = :agent or l.user = :agent) and l.isLead = false and l.closedStatus IS NULL')->setParameter('agent', $agent)->getQuery()->getResult();
                    break;
                case 3:
                    $leads = $repo->createQueryBuilder('l')->where('(l.assignedSalesRep = :agent or l.user = :agent) and l.closedStatus = 1')->setParameter('agent', $agent)->getQuery()->getResult();
                    break;
                case 4:
                    $leads = $repo->createQueryBuilder('l')->where('(l.assignedSalesRep = :agent or l.user = :agent) and l.closedStatus = 0')->setParameter('agent', $agent)->getQuery()->getResult();
                    break;    
            }
        }
        return $this->render('CrmSandboxBundle:Common:dashboard_leads.html.twig', array(
                'leads' => $leads,
                'type'  => $type
            ));
    }

    public function widgetsAjaxAction(Request $request)
    {
        $em    = $this->getDoctrine()->getManager();
        $dates = $this->getDates($request);
        $id = $request->get('id');
        $type = $request->get('type');


        $leadsBydate    = $em->getRepository('CrmSandboxBundle:Lead')->getWholeLeadsByDate($dates['currentBeginDate'], $dates['currentEndDate'], $id, $type);
        $meetingsBydate = $em->getRepository('CrmSandboxBundle:Call')->getWholeMeetingsByDate($dates['currentBeginDate'], $dates['currentEndDate'], $id, $type);
        $callsBydate    = $em->getRepository('CrmSandboxBundle:Call')->getWholeCallsByDate($dates['currentBeginDate'], $dates['currentEndDate'], $id, $type);
        $depositedUnits = $em->getRepository('CrmBrookerInventoryBundle:Property')->getDepositedAmount();

        $deals = $this->get('crm.sandboxbundle.dealsManager')->getDealsSummaryByDate($dates['currentBeginDate'], $dates['currentEndDate'], $id, $type);



        return $this->render('CrmSandboxBundle:Common/AjaxTemplates:dashboard_widgets.html.twig', [
            'leadsNumber'    => count($leadsBydate),
            'meetingsNumber' => count($meetingsBydate),
            'callsNumber'    => count($callsBydate),
            'dealsSummary'   => $deals,
            'depositedUnits' => $depositedUnits,
            'dates'          => $dates,
            'type'           => $type,
            'id'             => $id
            ]);
    }

    public function callSourceAction(Request $request)
    {
        $em    = $this->getDoctrine()->getManager();
        $dates = $this->getDates($request);
        $type = $request->get('type');
        $id = $request->get('id');

        $callsSummary   = $em->getRepository('CrmSandboxBundle:Call')->getInboundVsOutboundByDate($dates['currentBeginDate'], $dates['currentEndDate'], $id, $type);

        return $this->render('CrmSandboxBundle:Common/AjaxTemplates:dashboard_team_inbound_outbound.html.twig', [
           'callsSummary' => $callsSummary
        ]);

    }

    public function teamCompletionAjaxAction(Request $request)
    {
        $em    = $this->getDoctrine()->getManager();
        $dates = $this->getDates($request);
        $type = $request->get('type');
        $id = $request->get('id');


        $deals   = $em->getRepository('CrmSandboxBundle:Deal')->getDashboardDeals($dates['currentBeginDate'], $dates['currentEndDate'], $id, $type);
        $graph = [];

        // Teams
        if($type) {
            //Specific team
            if($id) {
                $team  = $em->getRepository('CrmBrookerInventoryBundle:Team')->findOneBy(['id' => $id]);
                $users = $team->getUsers();

                foreach ($users as $salesRep) {
                    $graph[$salesRep->getName()] = ['in_progress' => 0, 'complete' => 0, 'target' => max(0, $salesRep->getTarget())];
                }


                foreach ($deals as $deal) {
                    if($deal->getApproved() && $deal->getClosed())
                     {
                        // Clean these if statements, they are not required anymore because of the prev users loop
                        if(array_key_exists($deal->getUser()->getName(), $graph))
                        {
                            $graph[$deal->getUser()->getName()]['complete'] += $deal->getPrice();
                        }
                     }               
                    else
                    {
                        if(in_array($deal->getUser()->getName(), $graph))
                        {
                            $graph[$deal->getUser()->getName()]['in_progress'] += $deal->getPrice();
                        }
                    }
                }
            }
            // All teams
            else {
                $teams  = $em->getRepository('CrmBrookerInventoryBundle:Team')->findAll();

                foreach ($teams as $team) {
                    $graph[$team->getName()] = ['in_progress' => 0, 'complete' => 0, 'target' => max(0, $team->getCollectiveTargets())];
                }
                foreach ($deals as $deal) {
                     # code...
                    if($deal->getApproved() && $deal->getClosed())
                     {
                        $graph[$deal->getTeam()->getName()]['complete'] += $deal->getPrice();
                     }
                     else {
                        $graph[$deal->getTeam()->getName()]['in_progress'] += $deal->getPrice();
                     } 
                 } 
            }
        }
        // Sales Rep
        else {
            // Specific sales rep
            if($id) {
                $salesRep  = $em->getRepository('CrmSandboxBundle:User')->findOneBy(['id' => $id]);
                $graph[$salesRep->getName()] = ['in_progress' => 0, 'complete' => 0, 'target' => $salesRep->getTarget() ];
                foreach ($deals as $deal) {
                     # code...
                    if($deal->getApproved() && $deal->getClosed())
                     {
                        $graph[$deal->getUser()->getName()]['complete'] += $deal->getPrice();
                     }
                     else {
                        $graph[$deal->getUser()->getName()]['in_progress'] += $deal->getPrice();
                     } 
                 } 
            }
            // All sales reps
            else {

            }
        }

        return $this->render('CrmSandboxBundle:Common/AjaxTemplates:dashboard_target_completion.html.twig', [
           'graph' => $graph
        ]);
       
    }

    public function callsHistoryAction(Request $request)
    {
        $currentBeginDate = $request->get('currentBeginDate'); 
        $currentEndDate = $request->get('currentEndDate');
        $id = $request->get('id');
        $type = $request->get('type');       

        $em = $this->getDoctrine()->getManager();
        $callsBydate    = $em->getRepository('CrmSandboxBundle:Call')->getWholeCallsByDate( new \DateTime($currentBeginDate['date']), new \DateTime($currentEndDate['date']), $id, $type);

        return $this->render('CrmSandboxBundle:Common:calls_history.html.twig', [
           'calls' => $callsBydate,
        ]);       
    }


    public function meetingsHistoryAction(Request $request)
    {
        $currentBeginDate = $request->get('currentBeginDate'); 
        $currentEndDate = $request->get('currentEndDate');
        $id = $request->get('id');
        $type = $request->get('type');       

        $em = $this->getDoctrine()->getManager();
        $meetingsBydate    = $em->getRepository('CrmSandboxBundle:Call')->getWholeMeetingsByDate( new \DateTime($currentBeginDate['date']), new \DateTime($currentEndDate['date']), $id, $type);

        return $this->render('CrmSandboxBundle:Common:meetings_history.html.twig', [
           'meetings' => $meetingsBydate,
        ]);       
    }

    public function leadsHistoryAction(Request $request)
    {
        $currentBeginDate = $request->get('currentBeginDate'); 
        $currentEndDate = $request->get('currentEndDate');
        $id = $request->get('id');
        $type = $request->get('type');       

        $em = $this->getDoctrine()->getManager();
        $leadsBydate    = $em->getRepository('CrmSandboxBundle:Lead')->getWholeLeadsByDate(new \DateTime($currentBeginDate['date']), new \DateTime($currentEndDate['date']), $id, $type);

        return $this->render('CrmSandboxBundle:Common:leads_history.html.twig', [
           'leads' => $leadsBydate,
        ]);
    }

    private function getDates(Request $request)
    {
        $result = [];
        $result['beginDate'] = $request->get('beginDate');
        $result['endDate']   = $request->get('endDate');
        $result['smonth']    = $request->get('smonth');
        $result['emonth']    = $request->get('emonth');
        $result['syear']     = $request->get('syear');
        $result['eyear']     = $request->get('eyear');

        $toReturn = [];

        $toReturn['currentBeginDate'] = new \DateTime($result['beginDate'].'-'.$result['smonth'].'-'.$result['syear']);
        $toReturn['currentEndDate']   = new \DateTime($result['endDate'].'-'.$result['emonth'].'-'.$result['eyear']);

        return $toReturn;
    }

    /**
    * Creates a form to edit a Lead entity.
    *
    * @param Lead $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Lead $entity)
    {
        $form = $this->createForm(new LeadType(), $entity, array(
            'action' => $this->generateUrl('lead_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

}
