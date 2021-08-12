# pull caddy php
FROM php:7.3.0-apache AS base-image

COPY site /var/www/html



# update repos
RUN apt update

#Install pyhton

RUN apt install -y python3-pip

# change workdir to app

WORKDIR /app

#copy requirements
COPY base_requirements.txt .

# install requirements
RUN pip3 install -r base_requirements.txt

RUN pip3 install --upgrade pip

# RUN pip3 install --upgrade tensorflow 

# RUN pip3 install --upgrade keras

RUN apt install -y wget


# Seperate build stage for application

FROM base-image as app-image 

#copy requirements
COPY app_requirements.txt .

# install requirements
RUN pip3 install -r app_requirements.txt

#COPY NLTK data
COPY nltk_data /root/nltk_data

#copy flask app
ADD app /app


# make startup.sh executable
RUN chmod +x /app/startup.sh


#install git
RUN apt install -y git

WORKDIR /tmp
RUN wget https://github.com/git-lfs/git-lfs/releases/download/v2.13.3/git-lfs-linux-amd64-v2.13.3.tar.gz
RUN gunzip git-lfs-linux-amd64-v2.13.3.tar.gz
RUN tar -xvf git-lfs-linux-amd64-v2.13.3.tar
RUN ./install.sh
RUN git lfs install

WORKDIR /app
RUN git lfs clone https://github.com/mickymots/docker-git-lfs.git

RUN cp docker-git-lfs/app/Bidirectional_LSTM.hdf5 /app/
RUN cp -r  docker-git-lfs/site/node_modules /var/www/html
CMD ["/app/startup.sh"]



EXPOSE 80 5000
