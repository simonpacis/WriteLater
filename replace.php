<?php
use Stringy\Stringy as S;

trait ReplaceTrait
{

	public function traverseResultReplace($results, $file)
	{
		global $app;
		$string_raw = $app->getFile($file);
		$string = S::create($string_raw);
		$end_index = 0;
		$replacements = [];
		$return_string = $string_raw;
		foreach($results as $tag)
		{
			$tag_marker = $app->get('tag');
			$tag_start = '['.$tag_marker;
			$tag_end = ']';

			$index = strpos($string_raw, $tag_start . $tag['name']);
			$end_index = strpos($string_raw, $tag_end, $index);
			$remove_newlines = false;

			if(count($tag['tags']) > 0)
			{
				$path = $tag['path'] . $tag['name'] . ".md";
				$substr = substr($string_raw, $index, ($end_index - ($index-1)));
				$string_raw = str_replace($substr, $file, $string_raw);

				$replacement = $this->traverseResultReplace($tag['tags'], $path);
				$file = explode("\n", $replacement);
				
				if(array_key_exists(2, $file))
				{
					if(substr($file[2], 0, 4) == "[//]")
					{
						$mode = explode(")", explode(": ", $file[2])[2])[0];
						if(strtolower($mode) == "snippet")
						{
							$remove_newlines = true;
						}
					}
				}
				unset($file[0]);
				$file = array_values($file);
				unset($file[0]);
				$file = array_values($file);
				unset($file[0]);
				$file = array_values($file);
				$file = join("\n", $file);

				$substr = substr($string_raw, $index, ($end_index - ($index-1)));
				if($remove_newlines)
				{
					$file = str_replace(["\n", "\r"], '', $file);
				}
				$string_raw = str_replace($substr, $file, $string_raw);

			} else {
				$file = file_get_contents($tag['path'] . $tag['name'] . ".md");
				$file = explode("\n", $file);
				if(array_key_exists(2, $file))
				{
					if(substr($file[2], 0, 4) == "[//]")
					{
						$mode = explode(")", explode(": ", $file[2])[2])[0];
						if(strtolower($mode) == "snippet")
						{
							$remove_newlines = true;
						}
					}
				}
				unset($file[0]);
				$file = array_values($file);
				unset($file[0]);
				$file = array_values($file);
				unset($file[0]);
				$file = array_values($file);
				$file = join("\n", $file);
				$substr = substr($string_raw, $index, ($end_index - ($index-1)));

				if($remove_newlines)
				{
					$file = str_replace(["\n", "\r"], '', $file);
				}

				$string_raw = str_replace($substr, $file, $string_raw);
			}



		}
		return $string_raw;


	}

	public function performReplacement()
	{
		global $app;
		$tags = $app->parse();
		$mainfile = $this->traverseResultReplace($tags, $this->get('mainFile'));

		file_put_contents($app->get('outputFile'), $mainfile);

		echo "Replacement tags replaced, file saved as \"".$app->get('outputFile')."\".\n";



	}
}
