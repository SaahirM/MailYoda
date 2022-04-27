# YodaMail

- Author: Saahir Monowar (@SaahirM)
- Upload Date: 27-Apr-2022

## Desc

MailYoda is a simple email system, featuring an inbox, outbox and email-composing page, as well as a profile page, and login/registration section. This website includes the ability to register an account, before sending, saving, receiving and viewing emails. This website was built for an assignment to demonstrate using PHP for session handling, database interaction, form validation (with regex), as well as general front-end web development.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for testing purposes.

1. Set database up (See [Prerequisites](#prerequisites))
1. Move all files into a stack/server's web root folder
1. Using a browser, navigate to the "index.php" file on the local server

### Prerequisites

- A MySQL database called "jedi_encrypted_email", with 4 tables set-up according to this [ERD](https://github.com/SaahirM/YodaMail/blob/main/img/MailYoda_ERD.png) created by Raghav Sampangi for an assignment
	- This should be a local database, accessed with username "root" and password "root"

## Citations/Attributions

1. Someone on seekpng for user-profile placeholder image (https://www.seekpng.com/ipng/u2y3q8t4t4i1q8u2_placeholder-image-person-jpg/). Accesesd 14:59 27-Feb-2022

1. PHP Docs (https://www.php.net/docs.php) for php syntax: password_verify @ 20:52 12-Mar-2022, unset @ 23:12 12-Mar-2022, intval & is_numeric @ 20:46 14-Mar-2022, and more.

1. zyBooks, Raghav Sampangi "CSCI 2170: Introduction to Server Side Scripting" (Course textbook) for general PHP & JS syntax. Accessed since 10-Mar-2022

1. This stack-overflow thread (https://stackoverflow.com/questions/17798835/auto-increment-skipping-numbers) to fix a MySQL auto_increment bug. Accessed 21:24 16-Mar-2022

1. PHP Sandbox (https://sandbox.onlinephpfunctions.com/) for occasional tests. Accessed 20-Mar-2022

1. PHP Live Regex (https://www.phpliveregex.com/) for occasional tests. Accessed 20-Mar-2022

1. Coolors (https://coolors.co/) for help picking colour pallete. Accesesd 21:22 22-Mar-2022

1. PurpleBooth for original REAEDME.md template (https://gist.github.com/PurpleBooth/109311bb0361f32d87a2#file-readme-template-md), modified by Raghav Sampangi for academic purposes.

## Assumptions
1. Users won't register with dupe emails

1. Specific phone number format. Country code, area code, number always 1 digit, 3 digits, 7 digits respectively. All parts always present

1. Every user has one login, every login has one associated user
