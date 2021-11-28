# Write Later

While writing I had the thought that sometimes there are parts of my text that I am not ready to write yet, but I know where I want it.

At the same time i use Pandoc for my citations, which use the syntax [@Key Pages].

So, I started work on Write Later.
In your Markdown document, when there's something you want to Write Later, simply insert the replacement key [$Key Description (optional)].

When run through Write Later it creates a Markdown file for each replacement key in a directory.

So, here's an example:

```
# Heading

Here's some text.

[$Background Background info for this part would be nice.]

```

This creates a file "Background.md" in the directory "Subfiles", with the following contents:

```
[//]: # (Background: Background info for this part would be nice.)
[//]: # (Status: Pending)

```

Underneath the second line you can type whatever you want to, and when run through Write Later with the replace action 

```
[$Background Background info for this part would be nice.]
```

will be replaced with the contents of Background.md.

Both of the first two lines will not be included in your output document.

## Recursion

With the recent commit, Write Later is now recursive.
That means that tags found in your Subfiles will also work flawlessly.
Here's an example:

Main.md has the tag [$Level1].
This creates Subfiles/Level1.md.
Level1.md has the tag [$Level2].
This creates Subfiles/Level1/Level2.md.
And so on for how ever long you need it to.

## Installation

There are two ways to install Write Later.

### Install globally as a binary
If you want to use Write Later anywhere by just running the "wl" command, this is the right way for you.
Simply run this oneliner in your terminal:

```
curl -LJO https://github.com/simonpacis/WriteLater/blob/main/dist/write-later.phar && chmod +x write-later.phar && mv write-later.phar /usr/local/bin/wl
```

And you're all set.
Make sure PHP is installed prior to this.

### Install locally as a PHP-file
Download the directory, and run
```
composer install
```
in the Terminal.
Then run
```
php wl.php
```

## Usage
Run
```
wl --help
```
to figure out what arguments to pass, but generally only three things are needed:

```
wl --action replace
```

Which will process the files and replace replacement keys with their corresponding Markdown files from the Subfiles directory.

```
wl --action list 
```

Will list all current replacement keys and their status as defined in their second line, as such:

<img width="588" alt="Screen Shot 2021-11-23 at 10 14 57 PM" src="https://user-images.githubusercontent.com/7118482/143184862-7e56fa80-aa39-4ce6-8975-8ea39296ca36.png">


```
wl --action prep
```

Will create all Markdown files based on the tags in your documents.
Replace and list automatically runs this before doing their thing.

## Configuration File
If you have custom arguments that you want to run everytime in that directory, instead of using command-line arguments, you can create a file called

```
.wlconfig
```

And use ini syntax to define those arguments.
Here are the contents of an example ini file:

```
action=replace
insertionTag=&
outputFile=Final.md
```

It might be a little hard to figure out exactly what the arguments are called, so you can have Write Later generate the configuration file for you.
Enter your desired arguments in the commandline, and add the 

```
--save true
```

parameter, and Write Later will automaticall generate the .wlconfig file for you, and enter your chosen arguments.

### Conflict precedence
Normally, the configuration file takes precedence over all command-line entered arguments, but if you want to reverse that, simply use the argument

```
--override true
```

Which would mean that entered command-line arguments that conflict with the configuration file would take precedence.

Project is very new, documentation is bad.
Will get better.
Try it out!
