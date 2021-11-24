# Write Later

While writing I had the thought that sometimes there are parts of my text that I am not ready to write yet, but I know where I want it.

At the same time i use Pandoc for my citations, which use the syntax [@Key Pages].

So, I started work on Write Later.
In your Markdown document, when there's something you want to Write Later, simply insert the replacement key [§Key Description].

When run through Write Later it creates a Markdown file for each replacement key.

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

Underneath the second line you can type whatever you want to, and when run through Write Parse with the replace action [§Background Background info for this part would be nice.] will be replaced with the contents of Background.md.

Both of the first two lines will not be included in your Markdown document, as they are comments.
