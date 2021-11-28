<?php
use jc21\CliTable;

trait ListTrait
{
	
	public function traverseResultList($results, $parent = null)
	{
		foreach($results as $result)
		{
			if(count($result['tags']) > 0)
			{
				$this->traverseResultList($result['tags'], $result);
			}

			$parent_string = "";
			if($parent != null)
			{
				$parent_string = $parent['name'] . "/";
			}

			array_push($this->returnarr, ['name' => $parent_string . $result['name'], 'description' => $result['description'], 'status' => $result['status'], "wc" => $result['wordcount']]);

		}

		return $this->returnarr;

	}

	public function performList()
	{
		global $app;
		$results = $app->parse();
		$table = new CliTable;
		$table->setTableColor('blue');
		$table->setHeaderColor('cyan');
		$table->addField('Tag', 'name');
		$table->addField('Description', 'description');
		$table->addField('Status', 'status');
		$table->addField('Word count', 'wc');
		$results = $this->traverseResultList($results);
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
