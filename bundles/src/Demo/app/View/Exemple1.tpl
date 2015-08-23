	{foreach from=$Exemple key=$iKey item=$oExemple}

		{$oExemple->get_title()} - {$oExemple->get_id()}<br/><br/>

	{/foreach}