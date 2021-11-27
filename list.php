<?php
use jc21\CliTable;

trait ListTrait
{
	public function performList()
	{
		global $app;
		$app->performPrep(false);
		$results = $app->parseFile();
		$table = new CliTable;
		$table->setTableColor('blue');
		$table->setHeaderColor('cyan');
		$table->addField('Tag', 'name');
		$table->addField('Description', 'description');
		$table->addField('Status', 'status');
		if($app->get('alphabetical') == "true")
		{
			usort($results, function($a, $b){ return strcmp($a["name"], $b["name"]); });
		}
		if($app->get('status') != "all")
		{
			$status = $app->get('status');
			$i = 0;
			foreach($results as $result)
			{
				if(strcmp(strtolower($result['status']),strtolower($status)) != 0)
				{
					unset($results[$i]);
					$results = array_values($results);
				}
				$i++;

			}
		}
		$table->injectData($results);
		$table->display();




	}
}
