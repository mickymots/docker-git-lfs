#using apache server becuase tensor flow is not compatible with caddy
FROM php:7.3.0-apache AS base-image
RUN apt-get update

#install python and pip
RUN apt-get install -y python3-pip

#make directory for flask app
RUN mkdir /var/www/flaskApp

#move over files that will not change
COPY nltk_data /root/nltk_data
#download large ml files from google drive with gdown
RUN pip3 install gdown
RUN gdown --id 1RYQzhsBEPTjXuLY1KphvQWsC7C3XFk9F --output /var/www/flaskApp/Bidirectional_LSTM.hdf5
RUN gdown --id 13-E-IO0gpaz9wxb62QOiBiDfAY1p5RhW --output /var/www/flaskApp/glove_model.txt

#copy over requirements and install them
COPY flaskApp/py_requirements.txt /var/www/flaskApp/
RUN pip3 install --upgrade pip
RUN pip3 install -r /var/www/flaskApp/py_requirements.txt

#copy over the rest of flask app files
COPY flaskApp /var/www/flaskApp

#make executable to fire up server
RUN chmod +x /var/www/flaskApp/startup.sh

#
RUN mkdir /var/www/html/assets
COPY html/assets /var/www/html/assets
#copy over rest of site files
COPY html /var/www/html

#fireup server
CMD ["/var/www/flaskApp/startup.sh"]

EXPOSE 80 5000