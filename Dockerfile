# pull caddy php
FROM php:7.3.0-apache

COPY site /var/www/html



# update repos
RUN apt update

#Install pyhton

RUN apt install -y python3-pip

# change workdir to app

WORKDIR /app

#copy requirements
COPY app/requirements.txt .

# install requirements
RUN pip3 install -r requirements.txt

RUN pip3 install --upgrade pip

RUN pip3 install --upgrade tensorflow 

RUN pip3 install --upgrade keras

#COPY NLTK data
COPY nltk_data /root/nltk_data

#copy flask app
ADD app /app


# make startup.sh executable
RUN chmod +x /app/startup.sh


#install git
RUN apt install -y git wget

WORKDIR /tmp
RUN wget https://github.com/git-lfs/git-lfs/releases/download/v2.13.3/git-lfs-linux-amd64-v2.13.3.tar.gz
RUN gunzip git-lfs-linux-amd64-v2.13.3.tar.gz
RUN tar -xvf git-lfs-linux-amd64-v2.13.3.tar
RUN ./install.sh
RUN git lfs install

WORKDIR /app
RUN git lfs clone https://github.com/mickymots/docker-git-lfs.git

RUN cp docker-git-lfs/app/Bidirectional_LSTM.hdf5 /app/

CMD ["/app/startup.sh"]



EXPOSE 80 5000
