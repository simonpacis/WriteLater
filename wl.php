<?php
require_once(__DIR__ . '/vendor/autoload.php');
use jc21\CliTable;
use \Fostam\GetOpts\Handler;
use Stringy\Stringy as S;

/*
 *
 * Write Later
 * by: Simon Pacis
 *
 */

require_once('arguments.php');
require_once('prep.php');
require_once('replace.php');
require_once('list.php');
require_once('app.php');
$app = new App();

if($getopts->get('save') == 'true')
{
	$app->argToConfig();
}

switch($app->get('action'))
{
case 'replace':
	$app->performReplacement();
	break;
case 'prep':
	$app->performPrep();
	break;
case 'list':
	$app->performList();
	break;
default:
	echo "Action " . $app->get('action') . " not found. Exiting.\n";
}
