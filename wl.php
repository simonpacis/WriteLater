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
require_once('helper.php');
$helper = new Helper();
require_once('prep.php');
require_once('replace.php');
require_once('list.php');

if($getopts->get('save') == 'true')
{
	$helper->argToConfig();
}

switch($helper->get('action'))
{
case 'replace':
	performReplacement();
	break;
case 'prep':
	performPrep();
	break;
case 'list':
	performList();
	break;
default:
	performReplacement();
}
