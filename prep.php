<?php

trait PrepTrait
{

	public function performPrep($print = true)
	{
		global $app;
		$results = $app->parseFile();

		if(!is_dir($app->get('subFileDirectory')))
		{
			mkdir($app->get('subFileDirectory'));
		}

		foreach($results as $result)
		{
			if($result['file'] == "No")
			{
				file_put_contents($app->get('subFileDirectory') . "/" . $result['name'] . ".md", "[//]: # (" . $result['name'] . ": " . $result['description'] . ")\n[//]: # (Status: Pending)");
			}
			if($print)
			{
				echo "Created " . $result['name'] . ".md.\n";
			}
		}
	}
}
