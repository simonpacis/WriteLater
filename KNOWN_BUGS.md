# Known bugs

## Critical
None.

## Major 

### Unnecessary files are created in subdirectories.

#### To recreate:
- Add [$Chapter1] and [$Chapter2] to Main.md and run prep action.
- Add [$Part1] to Subfiles/Chapter1.md and Subfiles/Chapter2.md and run prep action.

Notice that the file Subfiles/Chapter1/Chapter2.md exists.
This file should not exist.
Luckily, this file will not be included in output.

The error lies somewhere in pretag-generation.

## Minor
