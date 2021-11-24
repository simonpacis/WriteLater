<?php
use jc21\CliTable;

function performList()
{
	global $helper;
	performPrep(false);
	$results = $helper->parseFile();
	$table = new CliTable;
	$table->setTableColor('blue');
	$table->setHeaderColor('cyan');
	$table->addField('Tag', 'name');
	$table->addField('Description', 'description');
	$table->addField('Status', 'status');
	if($helper->get('alphabetical') == "true")
	{
		usort($results, function($a, $b){ return strcmp($a["name"], $b["name"]); });
	}
	if($helper->get('status') != "all")
	{
		$new_results = [];
		$status = $helper->get('status');
		$i = 0;
		foreach($results as $result)
		{
			if(strtolower($result['status'] != strtolower($status))
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
