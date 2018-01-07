<?php

namespace Crm\AuditingBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CrmAuditingBundle extends Bundle
{
	public function getParent(){
		return 'SimpleThingsEntityAuditBundle';
	}
}
