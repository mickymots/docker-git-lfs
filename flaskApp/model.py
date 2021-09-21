from flask import Flask, render_template, redirect, url_for,request
from flask import make_response
from flask import Flask
from flask_cors import CORS
from flask import send_from_directory

import pandas as pd
import numpy as np
import contractions
import codecs
import os
import pickle
import re
os.environ['TF_CPP_MIN_LOG_LEVEL'] = '3'

from tensorflow.keras.models import load_model
from nltk.tokenize import RegexpTokenizer
from tensorflow.python.keras.preprocessing import text, sequence
from tensorflow import keras

from nltk.stem.snowball import SnowballStemmer
from nltk.tokenize import word_tokenize


list_of_classes = ['anger', 'boredom', 'empty', 'enthusiasm', 'fear', 'fun', 'happiness', 'hate', 'love', 'neutral', 'relief', 'sadness', 'surprise']
positive_emotions = ['enthusiasm','fun', 'happiness','love','relief']
neutral_emotions = ['neutral','surprise']
negative_emotions = ['anger','boredom','empty','fear', 'hate', 'sadness']


def pre_processing(text):

	# Convert to lowercase
	text = text.lower()

	# Convert multiple spaces in single spaces
	text = re.sub(r' +', ' ', text, flags=re.I)

	# remove hashtags and @usernames
	text = re.sub(r"(#[\d\w\.]+)", '', text)
	text = re.sub(r"(@[\d\w\.]+)", '', text)

	# Remove Special Characters
	text = re.sub(r'[^\w\s]', '', text)

	# Remove Numbers
	text = re.sub(r'[0-9]','',text)

	# Remove Repetitions (Ex: helloooooo -> hello)
	text = re.sub("(.)\\1{2,}", "\\1", text)

	# Expand Contractions (Ex: shouldn't -> should not)
	text = contractions.fix(text)

	# Stemmer
	snow_stemmer = SnowballStemmer(language='english')
	text_tokenized = word_tokenize(text)
	text = " ".join([snow_stemmer.stem(word) for word in text_tokenized])

	return text

def predict_expression(text):

	# Load in Tokenizer
	with open('tokenizer.pickle', 'rb') as handle:
		x_tokenizer = pickle.load(handle)

	# Tokenize Text and Predict an Expression
	x_test_tokenized = x_tokenizer.texts_to_sequences([text])
	x_testing = sequence.pad_sequences(x_test_tokenized, maxlen=400)
	y_testing = model.predict(x_testing, verbose = 1)

	return y_testing[0]

def load_glove_model():

	word_idx = {}
	weights = []

	with codecs.open('/var/www/flaskApp/glove_model.txt', encoding='utf-8') as f:
		for line in f:
			word, vec = line.split(u' ', 1)
			word_idx[word] = len(weights)
			weights.append(np.array(vec.split(), dtype=np.float32))

	word_idx[u'-LRB-'] = word_idx.pop(u'(')
	word_idx[u'-RRB-'] = word_idx.pop(u')')

	weights.append(np.random.uniform(-0.05, 0.05, weights[0].shape).astype(np.float32))
	return np.stack(weights), word_idx

def get_intensity_prediction(model, data, idx):

	word_list = []
	word_list_np = np.zeros((56,1))

	# split the sentence into its words and remove any punctuations.
	tokenizer = RegexpTokenizer(r'\w+')
	data_sample_list = tokenizer.tokenize(data)

	# Intensity Level from 1 (Most Negative)-10 (Most Positive)
	labels = [1,2,3,4,5,6,7,8,9,10]

	data_index = np.array([idx[word.lower()] if word.lower() in idx else 0 for word in data_sample_list])
	data_index_np = np.array(data_index)

	# padded with zeros of maximum length = 56 words
	padded_array = np.zeros(56)
	padded_array[:data_index_np.shape[0]] = data_index_np
	word_list.append(padded_array.astype(int))
	word_list_np = np.asarray(word_list)

	# Predictions
	score = model.predict(word_list_np, batch_size=1, verbose=0)

	# weighted score of top 3 bands
	top_3_index = np.argsort(score)[0][-3:]
	top_3_scores = score[0][top_3_index]
	top_3_weights = top_3_scores/np.sum(top_3_scores)
	weighted_score = np.round(np.dot(top_3_index, top_3_weights)/10, decimals = 2)

	return weighted_score
def get_sentiment_classification(score):

	sentiment = ''

	if(score >0.45 and score<0.55):
		sentiment = "Neutral"
	elif(score <= 0.45):
		sentiment = "Negative"
	elif(score >= 0.55):
		sentiment = "Positive"

	return sentiment

def narrowed_expression_based_on_setiment(results, label):

	global positive_emotions, neutral_emotions, negative_emotions
	expression = ''

	if(label == 'Negative'):
		negative_emotions_weights = [results[list_of_classes.index(negative_emotions[i])]for i in range(len(negative_emotions))]
		expression = negative_emotions[negative_emotions_weights.index(max(negative_emotions_weights))]


	elif(label == 'Positive'):
		positive_emotions_weights = [results[list_of_classes.index(positive_emotions[i])]for i in range(len(positive_emotions))]
		expression = positive_emotions[positive_emotions_weights.index(max(positive_emotions_weights))]

	else:
		neutral_emotions_weights = [results[list_of_classes.index(neutral_emotions[i])]for i in range(len(neutral_emotions))]
		expression = neutral_emotions[neutral_emotions_weights.index(max(neutral_emotions_weights))]

	return expression

weight_matrix, word_idx = load_glove_model()
bi_lstm_model = load_model('/var/www/flaskApp/Bidirectional_LSTM.hdf5')
model = keras.models.load_model('/var/www/flaskApp/model.h5')


UPLOAD_FOLDER = '/app'
app = Flask(__name__)
CORS(app)

app.config['CORS_HEADERS'] = 'Content-Type'
app.config['UPLOAD_FOLDER'] = UPLOAD_FOLDER

@app.route("/file_upload", methods=['GET','POST'])


def upload_file():
    if request.method == 'POST':
        # check if the post request has the file part
        if 'photo' not in request.files:
           return '''
			<!doctype html>
			<title>Upload new File</title>
			<h1>Upload File failed</h1>
			
			'''
        file = request.files['photo']

        if file:
            filename = file.filename
            file.save(os.path.join(app.config['UPLOAD_FOLDER'], filename))
            return url_for('download_file', name=filename)

@app.route('/uploads/<name>')
def download_file(name):
    return send_from_directory(app.config["UPLOAD_FOLDER"], name)

@app.route('/login', methods=['GET', 'POST'])

# Convert Text to bag-of_words representation
def login():
	if request.method == 'GET':

		text = str(request.args["diag"])
		#text = input('Enter a piece of text: ')
		pre_processed_text = pre_processing(text)

		# Sentiment Analysis
		intensity_score = get_intensity_prediction(bi_lstm_model, text, word_idx)

		sentiment_label = get_sentiment_classification(intensity_score)

		# Expression Analysis
		results = predict_expression(pre_processed_text)

		# Narrow down expressions based on the predicted sentiment
		narrowed_down_expression = narrowed_expression_based_on_setiment(results,sentiment_label)


		print('Sentiment:',sentiment_label,'\tIntensity:',intensity_score,'\n')
		print('Predict Expression:',narrowed_down_expression,'\n')
		return narrowed_down_expression

if __name__ == "__main__":
	app.run(debug = False, port=5000, host='127.0.0.1')