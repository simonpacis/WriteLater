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
	$table->injectData($results);
	$table->display();




}
