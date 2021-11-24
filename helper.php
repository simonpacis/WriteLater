<?php
use Stringy\Stringy as S;

class Helper
{

	public function get($key)
	{
		global $getopts;
		return $getopts->get($key);
	}

	public function getMainFile()
	{
		$file = file_get_contents($this->get('mainFile'));
		return $file;
	}

	public function parseFile()
	{
		$tag = $this->get('tag');
		$tag_start = '['.$tag;
		$tag_end = ']';
		$mainfile = S::create($this->getMainFile());
		$pretags = [];
		$tags = [];
		$descriptions = [];

		$last_index = 0;
		$last_find = "";
		$index = 0;
		$i = 0;
		while($last_find != "none")
		{
			$index = $mainfile->indexOf($tag_start, $last_index);
			if($i == 0)
			{
				$last_index = $index;
			}

			$last_find = $mainfile->between($tag_start, $tag_end, $last_index);

			if($index < $last_index)
			{
				$last_find = "none";
			} else {
				$last_index = $last_index + $last_find->length();
				array_push($pretags, $last_find);
			}
			$i++;
		}

		foreach($pretags as $tag)
		{
			$explosion = explode(" ", $tag);
			$desc = "No description.";
			if(array_key_exists(1, $explosion))
			{
				$desc = join(" ", array_slice($explosion, 1));
			}
			$file = "No";
			$status = "Not created";
			if(file_exists($this->get('subFileDirectory') . "/". $explosion[0] . ".md"))
			{
				$file = "Yes";
				$read = file_get_contents($this->get('subFileDirectory') . "/" . $explosion[0] . ".md");
				$status = explode(")", explode(": ", explode("\n", $read)[1])[2])[0];

			}



			array_push($tags, ['name' => $explosion[0], 'description' => $desc, "file" => $file, 'status' => $status]);
		}

		return $tags;

	}
}
