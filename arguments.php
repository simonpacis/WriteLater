<?php
use \Fostam\GetOpts\Handler;

$getopts = new Handler();

$getopts->addOption('action')
		->short('a')
		->long('action')
		->argument('action')
		->description('The action you want Write Later to perform. Options include: replace|list. Defaults to "replace".')
		->defaultValue('empty');

$getopts->addOption('mainFile')
		->short('m')
		->long('main-file')
		->argument('main-file')
		->description('the main Markdown file that Write Later should parse from. Defaults to "Main.md".')
		->defaultValue('empty');

$getopts->addOption('outputFile')
		->short('o')
		->long('output-file')
		->argument('output-file')
		->description('The file that will be outputted with all files from the subfile directory inserted. Defaults to "Output.md".')
		->defaultValue('empty');

$getopts->addOption('subFileDirectory')
		->short('s')
		->long('sub-dir')
		->argument('subfile-directory')
		->description('Directory which contains the Markdown files to be inserted into the final output. Defaults to "Subfiles".')
		->defaultValue('empty');

$getopts->addOption('tag')
		->short('t')
		->long('tag')
		->argument('insertion-tag')
		->description('Tag which Write Later should mark as the replacement tag, and insert the corresponding Markdown file from the subfile directory. Defaults to "§", which would make the replacement tag [§Key Description]. Description is optional.')
		->defaultValue('empty');

$getopts->addOption('alphabetical')
		->short('l')
		->long('alphabetical')
		->argument('alphabetical')
		->description('Only relevant for the list action. If "true", sorts table alphabetically. If "false", sorts by occurence in document. Defaults to "true".')
		->defaultValue('empty');

$getopts->addOption('status')
		->short('t')
		->long('status')
		->argument('status')
		->description('Only relevant for the list action. Limits the returned tags for the table by the entered status. Optional. Example: "pending" would return all tags with the Pending status.')
		->defaultValue('empty');

$getopts->addOption('tableStyle')
		->short('y')
		->long('table-style')
		->argument('table-style')
		->description('The output styling of the table. Acceptable options are: raw|pretty. Defaults to "pretty".')
		->defaultValue('empty');

$getopts->addOption('override')
		->short('r')
		->long('override')
		->argument('override')
		->description('For any conflicts between command-line arguments and configuration file, the command-line arguments will take precedence if set to true. Defaults to "true".')
		->defaultValue('empty');

$getopts->addOption('save')
		->short('e')
		->long('save')
		->argument('save')
		->description('When set to true, saves the entered command line arguments as a .wlconfig file, so you can simply run "wl" next time to run Write Later with the same arguments. Will override existing .wlconfig. Defaults to "false".')
		->defaultValue('empty');

$getopts->addOption('defaultStatus')
		->short('d')
		->long('default-status')
		->argument('default-status')
		->description('The default status of newly created files. Defaults to "Pending". Will automatically uppercase first letter.')
		->defaultValue('empty');

$getopts->addOption('defaultDocMode')
		->short('c')
		->long('default-doc-mode')
		->argument('default-doc-mode')
		->description('The default inclusion mode for a document. If set to snippet, snippet will be the default mode for a document. This means that no newline will be added before or after the first line of the document. This is useful for things such as names or eye-color etc. Acceptable options are: document|snippet. Defaults to "document".')
		->defaultValue('empty');

$getopts->parse();

