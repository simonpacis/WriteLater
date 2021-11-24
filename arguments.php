<?php
use \Fostam\GetOpts\Handler;

$getopts = new Handler();

$getopts->addOption('action')
		->short('a')
		->long('action')
		->argument('action')
		->description('The action you want Write Later to perform. Options include: replace:|prep|list. Defaults to "replace".')
		->defaultValue('parse');

$getopts->addOption('mainFile')
		->short('m')
		->long('main-file')
		->argument('main-file')
		->description('the main Markdown file that Write Later should parse from. Defaults to "Main.md".')
		->defaultValue('Main.md');

$getopts->addOption('outputFile')
		->short('o')
		->long('output-file')
		->argument('output-file')
		->description('The file that will be outputted with all files from the subfile directory inserted. Defaults to "Output.md".')
		->defaultValue('Output.md');

$getopts->addOption('subFileDirectory')
		->short('s')
		->long('sub-dir')
		->argument('subfile-directory')
		->description('Directory which contains the Markdown files to be inserted into the final output. Defaults to "Subfiles".')
		->defaultValue('Subfiles');

$getopts->addOption('tag')
		->short('t')
		->long('tag')
		->argument('insertion-tag')
		->description('Tag which Write Later should mark as the replacement tag, and insert the corresponding Markdown file from the subfile directory. Defaults to "§", which would make the replacement tag [§Key Description]. Description is optional.')
		->defaultValue('§');

$getopts->parse();

