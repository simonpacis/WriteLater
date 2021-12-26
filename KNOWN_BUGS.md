# Known bugs

## Critical
None.

## Major 

### Unnecessary files are created in subdirectories.

#### To recreate:
Add [$Chapter1] and [$Chapter2] to Main.md and prep.
Subfiles/Chapter1.md and Subfiles/Chapter2.md.
Add [$Part1] to Subfiles/Chaper1.md

having Subfiles/Chapter1/Part1.md will also create Subfiles/Chapter1/Chapter1.md file.
This file will not be included in outout.

## Minor
