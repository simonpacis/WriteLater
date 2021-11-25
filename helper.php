<?php
use Stringy\Stringy as S;

class Helper
{

	public function get($key)
	{
		global $getopts;

		// Why the defaults array? We cannot deduce from $getopts->get() whether we're getting the default value or a user-entered value. So we set default to "empty", and then when we encouter an "empty" value, that means the user has not entered anything and it should use the default value from the defaults array.
		$defaults = [

			"action" => "parse",
			"mainFile" => "Main.md",
			"outputFile" => "Output.md",
			"subFileDirectory" => "Subfiles",
			"tag" => "§",
			"alphabetical" => "true",
			"status" => "all",
			"override" => "false"
		];

		$config = null;
		if(file_exists('.wlconfig') && $config == null)
		{
			$config = parse_ini_file('.wlconfig');
		}

		if($getopts->get($key) != "empty") // If manually entered a different value than default.
		{
			if($getopts->get('override') != "empty") // If override is set to true - arguments take precedence over configuration file.
			{
				return $getopts->get($key);
			} else { // If override is set to false - configuration file takes precedence over arguments.
				if($config != null)
				{
					if(array_key_exists($key, $config))
					{
						return $config[$key];
					} else {
						return $defaults[$key];
					}
				} else {
					return $defaults[$key≠;
				}
			}
			return $defaults[$key];
		} else {
			if($config != null)
			{
				if(array_key_exists($key, $config))
				{

					return $config[$key];
				}
			}
			return $defaults[$key];
		}
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
