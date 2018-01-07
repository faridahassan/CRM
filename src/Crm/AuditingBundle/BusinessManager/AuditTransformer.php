<?php
namespace Crm\AuditingBundle\BusinessManager;

use Doctrine\ORM\EntityManager;
use Crm\SandboxBundle\Entity\Database;
use \DateTime;
use Crm\AuditingBundle\AuditReader;

class AuditTransformer 
{
	private $reader;
	public function __construct(AuditReader $reader) 
	{
		$this->reader = $reader;
	}
	public function getHistory($class, $requested_id)
	{
		//
		$revisions = $this->reader->findRevisions(
            $class,
            $id = $requested_id
        );

        $all_revisions = [];

        // Make sure revisions are greater than 1
        for ($i=count($revisions) - 1; $i > 0; $i--) { 
            $diff = $this->reader->diff($class, $requested_id, $revisions[$i]->getRev(), $revisions[$i - 1]->getRev());
            $all_revisions[] = [
                'diff' => $diff,
                'username' => $revisions[$i]->getUsername(),
                'timestamp' => $revisions[$i]->getTimestamp()
                ];
        }
        // dump($this->reader->diff($class, $requested_id, 27, 28));
        // exit;
        $result = [];
        if(count($all_revisions)) {
            // Get initial one to work with
            $initial = $all_revisions[0]['diff'];
            // Iterating over property fields
            foreach ($initial as $keyField => $valueField) {
                // Iterating over revisions
                foreach ($all_revisions as $keyRev => $valueRev) {
                    $current_diff = $valueRev['diff'];
                    if($current_diff[$keyField]['new'] === false)
                    	$result[$keyField][$keyRev] = 'No';
                    elseif($current_diff[$keyField]['new'] === true)
                    	$result[$keyField][$keyRev] = 'Yes';
                   	else
                    	$result[$keyField][$keyRev] = $current_diff[$keyField]['new'];
               }
            }
        }

        $optimized_result = $result;
        foreach ($result as $keyOut => $valueOut) { 
            $empty = true;
            foreach ($valueOut as $key => $value) {
                if(!empty($value)){
                    $empty = false;
                }
            }
            if($empty) {
                unset($optimized_result[$keyOut]);
            }
        }
        // Get first revision and add it
        $initial_property = $this->reader->find(
            $class,
            $id = $requested_id,
            $rev = end($revisions)->getRev()
        );

        
        foreach ($optimized_result as $key => $value) {
            $function = 'get'.ucwords($key);
            $initial_property_value = $initial_property->$function();
            array_unshift($optimized_result[$key], $initial_property_value);
        }

        // camelCase to words
        // $str = "contactName";
        // preg_match_all('/((?:^|[A-Z])[a-z]+)/',$str,$matches);
        // dump($matches);exit;

        $final['results'] = $optimized_result;
        $final['revisions'] = $all_revisions;

        return $final;
        
		
	}
	public function hasHistory($class, $requested_id) {
        $revisions = $this->reader->findRevisions(
            $class,
            $id = $requested_id
        );
        $has_history = false;
        if(count($revisions) > 1)
            $has_history = true;

        return $has_history;
	}
}

?>