<!--- The following README.md sample file was adapted from https://gist.github.com/PurpleBooth/109311bb0361f32d87a2#file-readme-template-md by Raghav Sampangi for academic use ---> 
# Assignment 4: CSCI 2170, Winter 2022

Date Created: 10-Mar-2022  
Last Modification Date: 22-Mar-2022  
Gitlab URL: https://git.cs.dal.ca/courses/2022-winter/csci-2170/a4/monowar.git

## Author(s)

- Full Name: Saahir Ahmed Monowar  
- Email: Saahir.Monowar@dal.ca

## Description

MailYoda is a simple email system, featuring an inbox, outbox and email-composing page, as well as a profile page, and login/registration section. This website includes the ability to register an account, before sending, saving, receiving and viewing emails. This website was built to demonstrate using PHP for session handling, database interaction, form validation (with regex), as well as general front-end web development.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

1. Set database up (See [Prerequisites](#prerequisites))
1. Move all files into a stack/server's web root folder
1. Using a browser, navigate to the "index.php" file on the local server

### Prerequisites

- A MySQL database called "jedi_encrypted_email", with 4 tables set-up according to the [assignment instructions](https://dal.brightspace.com/content/enforced/201526-20750.202220/AssignmentFiles/A4/MailYoda_ERD.png?_&d2lSessionVal=fXV63pkwEJHeSkYOaSKEL8WfF&ou=201526)
	- This should be a local database, accessed with username "root" and password "root"

## Citations/Attributions
1. Include citations in this format:
Author/Website URL, Content used from the source, Year published (if available), and Date accessed.

1. Someone on seekpng for user-profile placeholder image (https://www.seekpng.com/ipng/u2y3q8t4t4i1q8u2_placeholder-image-person-jpg/), which I've also used for A3. Accesesd 14:59 27-Feb-2022

1. Saahir Monowar (me) for Footer and logout code adapted from A3. Accessed 20:27 11-Mar-2022

1. PHP Docs (https://www.php.net/docs.php) for php syntax: password_verify @ 20:52 12-Mar-2022, unset @ 23:12 12-Mar-2022, intval & is_numeric @ 20:46 14-Mar-2022, and more.

1. zyBooks, Raghav Sampangi "CSCI 2170: Introduction to Server Side Scripting" (https://learn.zybooks.com/zybook/DALCSCI2170SampangiWinter2022) for general PHP & JS syntax. Accessed since 10-Mar-2022

1. This stack-overflow thread (https://stackoverflow.com/questions/17798835/auto-increment-skipping-numbers) to fix a MySQL auto_increment bug. Accessed 21:24 16-Mar-2022

1. PHP Sandbox (https://sandbox.onlinephpfunctions.com/) for occasional tests. Accessed 20-Mar-2022

1. PHP Live Regex (https://www.phpliveregex.com/) for occasional tests. Accessed 20-Mar-2022

1. Coolors (https://coolors.co/) for help picking colour pallete. Accesesd 21:22 22-Mar-2022

1. Saahir Monowar (me) for certain sections of this README file from A3. Accessed 21:38 22-Mar-2022

## Assumptions
1. Users won't register with dupe emails

1. Specific phone number format. Country code, area code, number always 1 digit, 3 digits, 7 digits respectively. All parts always present

1. Every user has one login, every login has one associated user