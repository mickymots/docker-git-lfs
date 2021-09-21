# storytelling.viz.tamu.edu

## Project Struture
The code and images reside in a GitHub.com repository where changes can be made and pipelined to a docker container. The latest version of the repository is stored in a docker container on the Azures Container Instances. Every time a change is made in the update branch of the repository, a script is run to create a docker image with caddy which is push to Azures Container Instances. The latest docker container is then rebuilt. The rebuilding process typically takes ~ 5 mins.

## How to Operate Repository:
1. To push a new version of the container you must first create a new branch in the format of <b> update/&lt;name of change&gt; </b>
2. Any changes that you do not want to automatically apply to the production site must have the branch name in the format of <b> dev/&lt;name of change&gt; </b>
3. To revert back to a previous version, re-run a previous job located in the Actions tab

## Important Files and Web Page Locations:
| Item | Location | Contact/Owner|
| ------ | ------ | ------ |
| Application Website | <a href="http://storytelling.viz.tamu.edu" target="_blank">storytelling.viz.tamu.edu</a> | N/A |
| Current Repository | <a href="https://github.com/TAMUArchSD/storytelling.viz.tamu.edu" target="_blank">https://github.com/TAMUArchSD/storytelling.viz.tamu.edu</a> | Alec Smith - asmith@arch.tamu.edu |
| Deprecated Repository | <a href="https://github.tamu.edu/coaresearch" target="_blank">https://github.tamu.edu/coaresearch</a> | Ergun Akleman - ergun.akleman@tamu.edu  |
| Server Hosting | Azure Container Instances |Alec Smith - asmith@arch.tamu.edu |
|Internal Documentation| N/A |Alec Smith - asmith@arch.tamu.edu | 


## Getting Started
To contribute to the project, make sure to run the instance in a docker container. You will need to <a href="https://www.docker.com/products/docker-desktop" target ="_blank"> Download Docker</a> from their website.
If you are unfamilar with docker, <a href="https://www.youtube.com/watch?v=Tyy1BUEmhwg" target="_blank">Docker Crash Course 2021</a> is a great resource.  
Additionally, make sure you have apache2 and php installed for faster editing. The structure of this project should be:  
/var/www/  
         |->html  
         |     |-> index.php and related files  
         |  
         |->flaskApp  
               |-> model.py and related files  
<p>Once you have installed apache2 and php, go to var/www/ and delete the current html folder. then clone this repo:</P>
``` git clone https://github.com/TAMUArchSD/storytelling.viz.tamu.edu.git ```  
<p>you will need to move everything up one level. don't forget to move the hidden files too.</p>  
<p>You are now ready to begin. </p>
<p>create a new branch with the name of the edit:</p>
   ``` git checkout -b update/NAME_OF_EDIT ```
<p> you will need to update the facebook token to post to a facebook group. To create a person access token, you'll need a facebook developer account and an 'app' with the correct creditials. <a href="https://youtu.be/qI1s_DrzA-o" target="_blank">This youtube video</a> explains in detail. Once you understand the basics of Docker, you can run an instance in a docker container with:</p>
   ``` docker build -t IMAGE_NAME ./[path to docker file]```
<p>To run the docker image use:</p>
   ``` docker container run --name INSTANCE_NAME -p 5000:5000 -p 80:80 IMAGE_NAME ```
<p>for a summary of commands the <a href="https://www.docker.com/sites/default/files/d8/2019-09/docker-cheat-sheet.pdf" target="_blank">Docker cheat sheet</a></p>
<p>. </p>
