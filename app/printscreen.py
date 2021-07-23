import pyautogui
import pyscreenshot as ImageGrab

import requests
import config

from flask import Flask, render_template, redirect, url_for,request
from flask import make_response
from flask import Flask
from flask_cors import CORS

app = Flask(__name__)
CORS(app)

@app.route('/')
def takeshot():
    if request.method == 'GET':
        print(request.args['info'])
        left,top,right,bottom=str(request.args['info']).split(',')
        left,top,right,bottom=int(float(left)),int(float(top)),int(float(right)),int(float(bottom))
        left-=2
        right+=4
        top+=68
        bottom+=74
        # fullscreen
        im=ImageGrab.grab()

        # part of the screen
        im=ImageGrab.grab(bbox=(left,top,right,bottom))

        # to file
        im.save('grab.png')

        message="Comic Strip"

        post_url="https://graph.facebook.com/{}/photos".format(config.page_id)
        payload={
            "message":message,
            "access_token":config.fb_access_token
        }
        files = {
            'file': open("grab.png",'rb')
        }
        reply=requests.post(post_url,data=payload,files=files)
        print(reply)

        return "success"

if __name__ == "__main__":
	app.run(debug = True,port = 9000, host='0.0.0.0')