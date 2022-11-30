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
* **qc.php** - this is the main program.
* **qc.ini** - this is the configuration file.
* **qc_constants.php** - this is the file that contains some constants. It takes constants from qc.ini, but if you want you can take a look.
* **qc_listfunctions.php** - this file is the program that harvests the data. 
* **qc_printfunctions.php** - this file is used only to printout results. It will print a txt file and a csv file.
* **qc_qualityfunctions.php** - this is the core of the project. This file contains functions that check the dataset quality. 
* **qc_utilfunctions.php** - this is a collection of utility functions, like the logging and the CURL function.

## The quality check
The most important program is **qc_qualityfunctions.php**. It contains the routines to check for quality.
For each dataset, the program performs:
* ORGANIZATIONAL CHECK
* COMPLETENESS CHECK
* DATA-ACCESS CHECK
* USER-ORIENTED CHECKS
* PUBLISHER CHECKS
* FILE-ORIENTED CHECKS 

Each check returns a score (typically from 1 to 5).
All the score put together will form the average score of the dataset.

### Installation & run
Nothing special, you just need PHP and php CURL library, which is standard.
You just need to configure qc.ini, make sure you created a <pre>out</pre> folder, and then you can launch the quality check with the command:
<pre>php qc.php</pre>

### Configuration of qc.ini
You just need to set some parameters before running the program. 
The following applies:
* Scoring votes:
The following are the constants for scoring. Votes are 1 to 5, with 5 the best
<pre>
SCUMVOTE = 1
LOWVOTE = 2
MEDIUMVOTE = 3
HIGHVOTE = 4
MEGAVOTE = 5
</pre>

# output files
Provide a path and file for each file, or leave them like these but create "out" directory
<pre> 
TXTDS_OUT = "out/ds.txt"
CSVDS_OUT = "out/ds.csv" 
T_LOG = "out/log.txt"
</pre> 

* API Key and UNBLOCK Key
Insert your apikey if you want to scan also draft datasets
in the form like T_APIK = "key=xxxxxxxxxxxxxxxxxxxxxxxx"
<pre>
T_APIK = "key=xxxxxxxxxxxxxxxxxxxxxxxx"
</pre>

Insert your apikey if you want to scan also draft datasets
in the form like T_APIK = "key=xxxxxxxxxxxxxxxxxxxxxxxx"
<pre>
T_UNBLOCK = "unblock-key=xxxxxxxxxxxxxx";
</pre>

* Mandatory parameters 
<pre>T_URL = "https://dataverse.xxxxx.com.it/api/"</pre>
Mandatory!! Insert here your dataverse URL 
<pre>T_DVURL = "https://dataverse.xxxxx.com/dataverse/"</pre>
Mandatory!! Insert here your root dataverse
<pre>ROOTDV = "xxxxxxx Dataverse"</pre>
Mandatory!! Insert here your typical department dataverse name
<pre>DEPTDV = "department of"</pre>
Mandatory!! Insert here your publisher
<pre>ROOTPUBLISHER = "xxxxxxx Dataverse"</pre>

