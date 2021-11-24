<?php
use Stringy\Stringy as S;

function performReplacement()
{
	global $helper;
	$mainfile_raw = $helper->getMainFile();
	$mainfile = S::create($mainfile_raw);
	$tags = $helper->parseFile(false);
	$end_index = 0;
	$replacements = [];
	foreach($tags as $tag)
	{
		$tag_marker = $helper->get('tag');
		$tag_start = '['.$tag_marker;
		$tag_end = ']';

		$index = strpos($mainfile_raw, $tag_start . $tag['name'], $end_index);
		$end_index = strpos($mainfile_raw, $tag_end, $index);

		$file = file_get_contents($helper->get('subFileDirectory') . "/" . $tag['name'] . ".md");

		$substr = substr($mainfile_raw, $index, ($end_index - ($index-1)));

		$mainfile_raw = str_replace($substr, $file, $mainfile_raw);

		

	}


	file_put_contents($helper->get('outputFile'), $mainfile_raw);

	echo "Saved.";



}
