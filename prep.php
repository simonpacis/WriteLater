<?php


function performPrep($print = true)
{
	global $helper;
	$results = $helper->parseFile();

	if(!is_dir($helper->get('subFileDirectory')))
	{
		mkdir($helper->get('subFileDirectory'));
	}

	foreach($results as $result)
	{
		if($result['file'] == "No")
		{
			file_put_contents($helper->get('subFileDirectory') . "/" . $result['name'] . ".md", "[//]: # (" . $result['name'] . ": " . $result['description'] . ")\n[//]: # (Status: Pending)");
		}
		if($print)
		{
			echo "Created " . $result['name'] . ".md.\n";
		}
	}
}
