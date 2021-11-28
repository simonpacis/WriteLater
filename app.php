<?php
use Stringy\Stringy as S;

class App 
{
	use ReplaceTrait;
	use ListTrait;

	public $defaults;
	public $returnarr;
	public $maintext;
	public $maintext_raw;

	public function __construct()
	{
		$this->defaults = [
			"action" => "replace",
			"mainFile" => "Main.md",
			"outputFile" => "Output.md",
			"subFileDirectory" => "Subfiles",
			"tag" => "$",
			"alphabetical" => "true",
			"status" => "all",
			"override" => "false",
			'save' => 'false',
			'defaultStatus' => 'Pending'
		];

		$this->returnarr = [];
		$this->maintext = "";
		$this->maintext_raw = "";

	}

	public function get($key)
	{
		global $getopts;

		// Why the defaults array? We cannot deduce from $getopts->get() whether we're getting the default value or a user-entered value. So we set default to "empty", and then when we encouter an "empty" value, that means the user has not entered anything and it should use the default value from the defaults array.
		$defaults = $this->defaults;

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
					return $getopts->get($key);
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
		if(file_exists($this->get('mainFile')))
		{
			$file = file_get_contents($this->get('mainFile'));
		} else {
			echo "Main file \"" . $this->get('mainFile') . "\" not found. Exiting.\n";
			die();
		}
		return $file;
	}

	public function getFile($filename)
	{
		if(file_exists($filename))
		{
			$file = file_get_contents($filename);
		} else {
			echo "File \"" . $filename . "\" not found. Exiting.\n";
			die();
		}
		return $file;
	}

	public function parse()
	{
		return $this->parseFile($this->get('mainFile'));
	}

	public function getPath($file)
	{
		if($file == $this->get('mainFile'))
		{
			return $this->get('subFileDirectory') . "/";
		}
		$explode = explode(".md", $file);
		$path = join("/", array_slice($explode, 0, -1)) . "/";
		return $path;
	}

	function createPath($path) {
		if (is_dir($path)) return true;
		$prev_path = substr($path, 0, strrpos($path, '/', -2) + 1 );
		$return = $this->createPath($prev_path);
		return ($return && is_writable($prev_path)) ? mkdir($path) : false;
	}

	public function makeFile($path, $pretag)
	{
		$dir_path = join("/", array_slice(explode("/", $path), 0, -1));
		$this->createPath($dir_path);

		if(!file_exists($path))
		{
			$default_status = ucfirst($this->get('defaultStatus'));
			file_put_contents($path, "[//]: # (" . $pretag['name'] . ": " . $pretag['description'] . ")\n[//]: # (Status: ".$default_status.")");
		}
		return true;
	}

	public function parseFile($file)
	{
		$tag = $this->get('tag');
		$tag_start = '['.$tag;
		$tag_end = ']';
		$mainfile = S::create($this->getFile($file));
		$path = $this->getPath($file);
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
				if($index == false)
				{
					return;
				}
			}

			$last_find = $mainfile->between($tag_start, $tag_end, $last_index);

			if($index < $last_index)
			{
				$last_find = "none";
			} else {
				$last_index = $last_index + $last_find->length();
				array_push($pretags, ['tag' => $last_find, 'path' => $path]);
			}
			$i++;
		}


		foreach($pretags as $pretag)
		{
			$tag = $pretag['tag'];
			$explosion = explode(" ", $tag);
			$name = $explosion[0];
			$pretag['name'] = $name;
			$desc = "No description.";
			$rec_tags = [];
			if(array_key_exists(1, $explosion))
			{
				$desc = join(" ", array_slice($explosion, 1));
			}
			$pretag['description'] = $desc;
			$file = "No";
			$status = "Not created";
			$newpath = $path . $name . ".md";
			$this->makeFile($newpath, $pretag);
			$file = "Yes";
			$read = file_get_contents($pretag['path'] . $name . ".md");
			$status = explode(")", explode(": ", explode("\n", $read)[1])[2])[0];

			$newpath = $path . $name . ".md";
			$return = $this->parseFile($newpath);
			if($return != null)
			{
				$rec_tags = $return;
			}
			array_push($tags, ['name' => $name, 'description' => $desc, "file" => $file, 'status' => $status, 'path' => $pretag['path'], "tags" => $rec_tags]);
		}

		return $tags;

	}


	public function argToConfig()
	{
		global $getopts;
		$config_string = "";

		$i = 0;
		foreach($this->defaults as $key => $value)
		{
			if($getopts->get($key) != "empty" && $key != "save")
			{

				if($i != 0)
				{
					$config_string .= "\n";
				}
				$config_string .= $key . "=" . $getopts->get($key) . "\n";

			}
		}
		file_put_contents('.wlconfig', $config_string);
		return true;


	}

}
