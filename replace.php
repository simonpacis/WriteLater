<?php
use Stringy\Stringy as S;

trait ReplaceTrait
{
	public function performReplacement()
	{
		global $app;
		$app->performPrep(false);
		$mainfile_raw = $app->getMainFile();
		$mainfile = S::create($mainfile_raw);
		$tags = $app->parseFile(false);
		$end_index = 0;
		$replacements = [];
		foreach($tags as $tag)
		{
			$tag_marker = $app->get('tag');
			$tag_start = '['.$tag_marker;
			$tag_end = ']';

			$index = strpos($mainfile_raw, $tag_start . $tag['name']);
			$end_index = strpos($mainfile_raw, $tag_end, $index);

			$file = file_get_contents($app->get('subFileDirectory') . "/" . $tag['name'] . ".md");

			$file = explode("\n", $file);
			unset($file[0]);
			$file = array_values($file);
			unset($file[0]);
			$file = array_values($file);
			$file = join("\n", $file);

			$substr = substr($mainfile_raw, $index, ($end_index - ($index-1)));

			$mainfile_raw = str_replace($substr, $file, $mainfile_raw);


		}


		file_put_contents($app->get('outputFile'), $mainfile_raw);

		echo "Replacement tags replaced, file saved as \"".$app->get('outputFile')."\".";



	}
}
