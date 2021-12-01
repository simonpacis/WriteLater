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
		$totalcount = 0;
		foreach($results as $result)
		{
			$totalcount = $totalcount + $result['wc'];

		}


		$mainfilecount = str_word_count($app->getFile($app->get('mainFile')));
		$totalcount = $totalcount + $mainfilecount;
		
		if($app->get('tableStyle') == "pretty")
		{
			$table = new CliTable;
			$table->setTableColor('blue');
			$table->setHeaderColor('cyan');
			$table->addField('Tag', 'name');
			$table->addField('Description', 'description');
			$table->addField('Status', 'status');
			$table->addField('Word count', 'wc');

			$table->injectData($results);
			$table->display();
			echo "\033[0m";
			
			echo "Main file word count is: " . $mainfilecount . ".\n";
echo"Total word count is: " . $totalcount . ".\e[0m\n";
		}else{
			echo "\n";
			$prepped_results = [];
			foreach($results as $key => $result)
			{
				array_push($prepped_results, [$result['name'], $result['description'], $result['status'], $result['wc']]);
			}
			$tableBuilder = new \MaddHatter\MarkdownTable\Builder();
			$tableBuilder
				->headers(['Tag', 'Description', 'Status', 'Word count']) //headers
				->align(['L','L','L', 'L']) // set column alignment
				->rows($prepped_results);

			// display the result
			echo $tableBuilder->render();
			echo "\n";
			echo "Main file word count is: " . $mainfilecount . ".\n";
		echo "Total word count is: " . $totalcount . ".";

		}







	}
}
