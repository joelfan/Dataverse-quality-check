# Dataverse-quality-check

This project aims to check for Dataverse (https://dataverse.org/) quality of data and metadata.
Through the use of Dataverse API, the program will check for all published dataset in odrder to establish the degree of data and metadata quality.

The project consists of:
- A document to define FAIRness and data & metadata quality
- A batch program to check for many published dataset attributes and score the attributes

The project will go through the following milestones:
- November 2022 - Write a document to define FAIRness and data & metadata quality. In the same doc, state what are project goals and to obtain them.
- December 2022 - Code a batch program to check for many published dataset attributes and score the attributes
- January 2022 - Test & produce a list of datasets eligible for improvement

The coding language is PHP, version 7 or superior.
You can launch the program with a simple "php qc.php".
All the files are with comments in English language.
The project has the following files:
qc.php - this is the main program.
qc.ini - this is the configuration file.
qc_constants.php - this is the file that contains some constants. It takes constants from qc.ini, but if you want you can take a look.
qc_listfunctions.php - this file is the program that harvest the data. 
qc_printfunctions.php - this file is used only to printout results. It will print a txt file and a csv file.
qc_qualityfunctions.php - this is the core of the project. This file contains functions that check the dataset quality. 
qc_utilfunctions.php - this is a collection of utility functions, like the logging and the CURL function.

## The quality check in detail
for each dataset, the program will check: