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
