# Write Later

## Warning
I recently discovered a bug in the recursive function.
For now, you cannot go deeper than two levels, that is to say this is the maximum file tree: Subfiles/Level1/Level2.
A Subfiles/Level1/Level2/Level3.md would not work at the moment.
Working on fixing this permanently.

## What is this project?
Essentially it is a Markdown-file compiler.
You can refer to other Markdown files that will then be compiled into one single Markdown file when run through WriteLater.

It can be used for organizing books, or it can be used to insert certain tidbits of information that you want to make sure is the same everywhere in your document.

### Examples
#### As a book organizer
Imagine splitting every single chapter into a separate Markdown file, and then you can compile it all together into one single Markdown file with WriteLater.
This makes it easy to be able to keep track of your project as it grows in size.

#### As a tidbit-inserter
Imagine you want to make sure your character has the same eye-color throughout your story?
You could have a Markdown document that simply says "green", and then have that inserted everywhere you call it.

## How did it come about, and how does it actually work?
While writing I had the thought that sometimes there are parts of my text that I am not ready to write yet, but I know where I want it.

At the same time I use Pandoc for my citations, and Pandoc uses the syntax [@Key Pages].

Inspired by that, I started work on Write Later.
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

Write Later is recursive.
This means that tags found in your Subfiles will also work flawlessly.
Here's an example:

```Main.md``` has the tag ```[$Level1]```.
This creates ```Subfiles/Level1.md```.
```Level1.md``` has the tag ```[$Level2]```.
This creates ```Subfiles/Level1/Level2.md```.
And so on for how ever long you need it to.

## Installation

There are two ways to install Write Later.

### Install globally 
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

<img width="478" alt="Screen Shot 2021-11-27 at 11 40 59 PM" src="https://user-images.githubusercontent.com/7118482/143734039-9c0065cd-d97f-4292-b21d-d207fb59675a.png">


```
wl --action prep
```

Will create all Markdown files based on the tags in your documents.
Replace and list automatically runs this before doing their thing.

### Running in a subdirectory
If you run the ```wl``` command in one of your subdirectories, Write Later will automatically go up levels until it reaches the main-file, and will then process this file.

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
Normally, the command-line entered arguments take precedence over all configuration arguments, but if you want to reverse that, simply use the argument

```
--override false 
```

Which would mean that entered command-line arguments that conflict with the configuration file would not take precedence.

# Write Later in Vim
I write exclusively in Vim, so I wrote up a little script which opens a window in Vim with the output of wl --action list.
Just press Leader + p to open the window, Leader + p to close it again.

https://gist.github.com/simonpacis/2e37c16491ec498dc7132b6d3af0c82f
