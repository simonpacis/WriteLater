<?php

trait PrepTrait
{

	public function performPrep($print = true)
	{
		global $app;
		$results = $app->parse();
		print_r($results);
	}
}
