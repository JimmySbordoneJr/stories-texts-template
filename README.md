# Interactive Bilingual Stories & Texts

This is the template code for creating interactive bilingual stories and texts which was presented at the 6th International Conference on Language Documentation & Conservation (ICLDC) as "Web Design Strategies for Interactive Stories and Texts". This user's guide will be expanded in the coming weeks to include more detailed instructions for downloading and using our code, but everything you need to get your own stories and texts database up and running is included. 

# Getting Started

You do not need to be a programmer to use this code. Each file includes detailed instructions for what text to change.

In order to download this code, click the green clone or download button, and then click Download Zip. Once you have extracted these files, you can then edit them and upload them to your website.

# Basics

For curious programmers, the Stories and Texts web application uses HTML5, CSS3, Javascript, and PHP. The texts are stored in an XML file.

To view a live example of interactive stories and texts in action, view [Northern Pomo Stories & Texts](http://northernpomolanguagetools.com/texts). 

# Uploading the Code to Your Website

Depending on the structure of your website, the instructions for how to upload the code to your website will vary greatly. If you have questions about how to upload the code to your site, email Jimmy Sbordone at jsbordone96@gmail.com

Most web hosting services, such as Bluehost, allow you to access files either by logging in online or by using an File Transfer Protocol program like FileZilla. When you log into your site using FileZilla, for example, you can simply drag and drop files to upload them onto the website. In most cases, they will go into a directory named public_html or htdocs. To upload this code, drag the texts folder and morphemes folder into this directory. 

In the coming weeks, more instructions will be given here, but feel free to ask us questions as they arise. We'd love to help you add interactive stories to your revitalization project!

# Adding & Editing Stories

Once the files have been uploaded to your website, go to yourwebsite.com/texts/update and log in. 

# Editing the Code

You can use any text editor to edit these files. Some popular ones include Notepad, Notepad++, Atom, Sublime, and Visual Studio Code. Personally, I find Visual Studio Code to be the best free text editor for editing these files. It color codes the code and underlines syntax errors, which is extremely helpful for novice and advanced programmers alike. A link to Visual Studio Code can be found [here](https://code.visualstudio.com/). 

# A Note About File Uploading
There is a possible issue with users uploading images, sound files, and handout files. Your web hosting service may limit the amount of files that can be uploaded at once. If you exceed that limit, you may get an error message, and the files will not be uploaded. If this happens, you may be able to increase the limit on file uploading by talking with your web hosting provider (such as GoDaddy or Bluehost). 

# Using the Update Page
When entering stories and editing them, you can enter simple text into the fields. Additionally, you can include HTML markup in the fields, which makes it easier to give unique styling to certain parts of your text. You may want to make a stretch of text bold, or italic, for example. 

# Ambitious Goals for This Project

Here are some ideas for ways to improve this project that we may pursue in the future.
- The segmentation function could greatly be improved by taking context or part of speech into effect.
- Automatically suggesting morphemes while typing in the Update page. We tried to implement this, but two implementations of this feature ground the pages to a halt, and our segmenter is effective enough that suggesting morphemes would not gain us much.
- Having the ability to mass edit multiple morphemes at once would be cool.
- A merge morphemes button would allow users to combine the contents of that morpheme with that of the following morpheme into one. 
- Adding a section to the update page that would let users see what files are in the sound files directory, handouts directory, or images directory and delete them or replace them.
- Autosuggest multiple narrators and interviewers in the update page. Currently, it only suggests a single name.
- We want to have a page where we show links to other tribes' versions of a story. We are currently working on incorporating this feature into our database.
