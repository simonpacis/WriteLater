# Write Later

While writing I had the thought that sometimes there are parts of my text that I am not ready to write yet, but I know where I want it.

At the same time i use Pandoc for my citations, which use the syntax [@Key Pages].

So, I started work on Write Later.
In your Markdown document, when there's something you want to Write Later, simply insert the replacement key [§Key Description (optional)].

When run through Write Later it creates a Markdown file for each replacement key in a directory.

So, here's an example:

```
# Heading

Here's some text.

[§Background Background info for this part would be nice.]

```

This creates a file "Background.md" in the directory "Subfiles", with the following contents:

```
[//]: # (Background: Background info for this part would be nice.)
[//]: # (Status: Pending)

```

Underneath the second line you can type whatever you want to, and when run through Write Later with the replace action 

```
[§Background Background info for this part would be nice.]
```

will be replaced with the contents of Background.md.

Both of the first two lines will not be included in your output document.

## Installation

Download the directory, and run
```
composer install
```
in the Terminal.
Then run
```
php wl.php --help
```
to figure out what arguments to pass, but generally only three things are needed:

```
php wl.php --action replace
```

Which will process the files and replace replacement keys with their corresponding Markdown files from the Subfiles directory.
The replace action runs the prep action automatically.


```
php wl.php --action prep
```

Which will create all the necessary Markdown files based on your replacement keys.

```
php wl.php --action list 
```

Will list all current replacement keys and their status as defined in their second line, as such:

<img width="588" alt="Screen Shot 2021-11-23 at 10 14 57 PM" src="https://user-images.githubusercontent.com/7118482/143184862-7e56fa80-aa39-4ce6-8975-8ea39296ca36.png">

The list action runs the prep action automatically.

## Configuration File
If you have custom arguments that you want to run everytime in that directory, instead of using command-line arguments, you can create a file called

```
.wlconfig
```

And use INI syntax to define those arguments.
Here are contents of an example INI file:

```
action=replace
insertion-tag=&
output-file=Final.m,d

```

Project is very new, documentation is bad.
Will get better.
Try it out!
