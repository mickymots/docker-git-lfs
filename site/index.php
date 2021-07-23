<html> 
<head>
    <link rel="stylesheet" href="/styles.css">
    <link href="http://db.onlinewebfonts.com/c/f0daf632a7f9d6b0c1741305664fefb4?family=Lint+McCree+Intl+BB" rel="stylesheet" type="text/css"/> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <!--<script>< ?PHP echo shell_exec("python3 printscreen.py"); ?></script> -->
    <!--<script>< ?PHP echo shell_exec("python3 model.py"); ?></script> -->
</head>   
    
<style>   
    
#speechBubbles
    {
        font-family: "Lint McCree Intl BB";
        display: flex;
    }
    
.inner-tri
{
width: 0;
height: 0;
position:relative;
bottom: 20px;
border-style: solid;
border-width: 0 12px 15px 5;
border-color: transparent white transparent transparent;
}
    
.out-tri
{
width: 0;
height: 0;
position:relative;
bottom: 35px;
z-index: -1;
border-style: solid;
border-width: 0 20px 20px 0;
border-color: transparent black transparent transparent;
}
    
/* Style tab links */
.tablinks{
background-color: #555;
color: white;
float: left;
border: none;
outline: none;
cursor: pointer;
padding: 14px 16px;
font-size: 17px;
width: 50%;
}

.tablinks:hover {
background-color: #777;
}
    
.charlink:hover {
background-color: #777;
}

/* Style the tab content (and add height:100% for full page content) */
.tabcontent,.charcontent{
color:black;
display: none;
padding: 100px 20px;
height: 100%;
}
    
    </style>
    

<body onload="init();">

     <center>
    <h1> Comic Interface</h1> <br>
    <table >
        
        <tr>
        <td>
         <center>
        <div id="n-box" style="display:none">
                
         <table class="canvas" id="canvastable">
             
            <tr id="speechBubbles">
            </tr>
        
            <tr id="charCanvas">
            </tr>
             
              <!-- Vertical Slider  -->
              <input type="range" min="0" max="0.9" step="0.1" value="0.9"  onchange="setup();" id="myRange3"> 
             
        </table> 
        
        <div align="center" class="slidecontainer">
            <br><br>
            <!-- Horizontal Slider  -->
            <input type="range" min="0" max="1" step="0.001" value="0.366" class="slider" onchange="setup();" id="myRange">  <br> <br> <br>
            
        </div>
        
        <button onclick="takeshot()" style="background-color: skyblue; color: white;padding: 6px;border: none;font-size: 20px;box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);-webkit-appearance: button;appearance: button;outline: none;">
            Post to Facebook
        </button>
        
        <br><br>

        </div>
            </center>
            </td>
        </tr>
         <tr>
             <td>
                 <div id="tabs" style="display:none">
                    <button class="tablinks" onclick="openPage('Set Expression', this, 'black')" id="defaultOpen">Choose Expression</button>
                    <button class="tablinks" onclick="openPage('Sentiment Analysis', this, 'black')" >Sentiment Analysis</button>


                    <div id="Set Expression" class="tabcontent">

                         <center>
                        <h3> Choose a Character's expression from their dropdown below:</h3> <br>
                        <!-- Expression Dropdowns  -->     
                        <table id="droptable">
                            <tr id="dropdown">
                            </tr> 
                        </table> 
                        </center>    


                    </div>

                    <div id="Sentiment Analysis" class="tabcontent">

                        <center>
                            <h3> Set the Character's expression from the Emotion of their Dialogue:</h3> <br>
                             <!-- Evaluate Dialogue  -->
                            
                             <table align="center" id="SAtable" >
                             <tr id="SAbuttons">
                            </tr>
                            <tr id="SAtextboxes">
                            </tr>
                            </table>
                            
                        </center>    

                    </div>
                </div>
             </td>
        </tr>
    </table>
         
    
    
         
<!--     <div id="output"></div>-->
         
    <br><br>
         
    <!-- Number of Characters  -->
    <div >
        <h2> Select number of Characters</h2>
        <select id="numChars">
            <option> 1</option>
            <option selected="selected"> 2</option>
            <option> 3</option>
            <option> 4</option>
            <option> 5</option>
        </select>
    </div>
         
    <!-- Selected Characters  -->   
    <div id="selectedChars" style="display:none;">
        <h2> Selected Characters</h2>
    </div>
         
    <!-- Expression Dropdowns  -->     
    <table id="droptable">
        <tr id="dropdown">
        </tr> 
    </table>
         
    <h2 id="selectChars"> Select Characters</h2>
    <h6> Re-click Character to replace</h6>
         
    <!-- Character tabs -->   
    <div class="tab">
    
     <?php

    $dir = "assets/CartoonFolder/";

    $emotions=[];

    $categories = scandir( $dir );
    $categories=array_splice($categories,2);


    foreach( $categories as $category ):
        $res= "'".$category."'";
        if (strcmp($category, "AnimalCharacters") == 0) {
            echo "<button class='charlinks' name='".$category."' onclick='openCity(event,this.name)' id='defOpen'>".$category." </button>";
        }
        else{
            echo "<button class='charlinks' name='".$category."' onclick='openCity(event,this.name)'>".$category." </button>";
        }

        $characters = scandir( $dir.$category );
        $characters=array_splice($characters,2);
    endforeach;

    ?>
        
    </div>
         
    
    <?php
         
    foreach( $categories as $category ):
         echo "<div class='charcontent' id='".$category."'>";
        $characters = scandir( $dir.$category );
        $characters=array_splice($characters,2);
         
        foreach( $characters as $character ):
        $emos=scandir( $dir.$category."/".$character );
        $emotions[$character]=array_splice($emos,2);
         
        echo "<figure style='display:inline;margin:2%;padding:0;float:left;'>";
        echo "<img src='" . $dir.$category."/".$character."/default.png" . "' class='polaroid' width='100' height='100' onclick='select_img(this.src,false,false);'/>";
        echo "<figcaption> <b>".preg_replace('/[0-9]+/', '', $character)."</b> </figcaption>";
        echo "</figure>";
            
        
    endforeach;
         echo "</div>";
         
    endforeach;
         
    ?>
     
   
    <br><br>

    </center>

    <script src="node_modules/pixi.js/dist/pixi.min.js"></script>
    
    <script>
        
        
        
         /* Character tab control */
        function init()
        {
            document.getElementsByClassName("tablinks")[0].click();
            document.getElementsByClassName("charlinks")[0].click();
            document.getElementById("selectChars").innerHTML = "Select 2 Characters";
        }
        
        function openCity(evt, cityName) {
          var i, tabcontent, tablinks;
          tabcontent = document.getElementsByClassName("charcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
          }
          tablinks = document.getElementsByClassName("charlinks");
          for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
          }
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
          }
          document.getElementById(cityName).style.display = "block";
          evt.currentTarget.className += " active";
        }
        
        function openPage(pageName,elmnt,color) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
        tablinks[i].style.backgroundColor = "gray";
        }
        document.getElementById(pageName).style.display = "block";
        elmnt.style.backgroundColor = color;
        }

        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defOpen").click();
    </script>
    
    <script>
        
    var emotions_list= <?php echo json_encode($emotions); ?>;
    var val;
    var diag_num;
    function evalSA(num)
    {
        val=document.getElementById("inside"+num.toString()).value;
        $.ajax({
            type: "GET",
            url: "http://0.0.0.0:5000/login?diag="+val,
            crossDomain : true,
            success: callbackFunc
         })
        
        
         diag_num=num;
    }
    
    function takeshot()
    {
         var rect = document.getElementById("canvastable").getBoundingClientRect();
        console.log(rect);
        
        $.ajax({url: "http://127.0.0.1:9000/?info="+rect.left+","+rect.top+","+rect.right+","+rect.bottom,
            //url: "http://127.0.0.1:printscreen.py/?info="+rect.left+","+rect.top+","+rect.right+","+rect.bottom,
            type: 'GET',
            crossDomain : true,
         })
    }

    function callbackFunc(response) 
    {
        // show response emotion
        
        var new_emo;
        var emo=response;
        console.log(emo);
        switch(emo)
            {
                case "hate":
                    new_emo="rage";
                    break;
                case "boredom":
                    new_emo="fakesmile";
                    break;
                case "empty":
                    new_emo="cry";
                    break;
                case "sadness":
                    new_emo="sad";
                    break;
                case "fun":
                case "enthusiasm":
                    new_emo="laugh";
                    break;
                case "love":
                case "happiness":
                    new_emo="sinceresmile";
                    break;
                case "enthusiasm":
                    new_emo="laugh";
                    break;
                case "neutral":
                case "relief":
                    new_emo="default";
                    break;
                default:
                    new_emo=response;
                
            }
        
        if(!emotions_list[images[diag_num].split("/")[6]].includes(new_emo+".png"))
            new_emo="default";
        
        document.getElementById("emolist"+diag_num).value=new_emo;
        select_img("emolist"+diag_num,true,new_emo);
    }
        
    /* Comic Canvas control */
        
    let Application = PIXI.Application,
    loader = PIXI.loader,
    resources = PIXI.loader.resources,
    Sprite = PIXI.Sprite;
    var images= new Array();
    var prev_del=0;
    let apps=[];
    let flipButtons=[];
    var flipFlags=new Array();
        
    var num = document.getElementById("numChars");
    var numChars=2;
    num.onclick=function()
    {    
        
    if(images.length==numChars)
        numChars = num.options[num.selectedIndex].value;
    
    while(images.length>numChars)
        {
            
               document.getElementById("charCanvas").removeChild(document.getElementById("c"+(images.length-1).toString()));
               document.getElementById("speechBubbles").removeChild(document.getElementById("bubble"+(images.length-1).toString()));
                
               select_img(images[images.length-1],false,false);
               
        }
        if(images.length==numChars)
            select_img("None",false,false);
        
    document.getElementById("selectChars").innerHTML = "Select "+numChars+" Characters";
    apps=[];
    }
        
        
        /* Character selection control */
    function select_img(val,truth_val,emo_val)
        {
            
            var selectedDiv=document.getElementById("selectedChars");   
            var SAbutton = document.getElementById("SAbuttons");
            var SAtext = document.getElementById("SAtextboxes");
            
            selectedDiv.style.display="inline";
            var img_ele,parent,td_ele,select;
            
            
            
            var flag=0;
            
             // Check if Character already exists 
            for(var i=0;i<images.length;i++)
            {
                basePath=val.split("/")[6];
                
                if(images[i].includes(basePath))
                    {
                    prev_del=i;
                    flag=1;
                    }
            }
            
            var old_selection=document.getElementById("selected"+prev_del);
            var old_flip=document.getElementById("button"+prev_del);
            var old_emo=document.getElementById("emo"+prev_del);
            var old_emolist=document.getElementById("emolist"+prev_del);
            var old_SAbutton=document.getElementById("SA"+prev_del.toString());
//            var old_SAtext=document.getElementById("SAres"+prev_del.toString());
            
            
            // if Character doesn't already exist and either of 2 characters remains 
            if(!flag && old_selection==null  && old_flip==null && old_emo==null && images.length!=num.options[num.selectedIndex].value && old_SAbutton==null)// && old_SAtext==null)
                {
                    
                img_ele=document.createElement("img");
                img_ele.setAttribute("id","selected"+prev_del);
                img_ele.setAttribute("src",val);
                img_ele.style.display="inline";
                img_ele.setAttribute("width",250);
                img_ele.setAttribute("height",250);
                    
                //button to mirror character vertically
                flip_button=document.createElement("input");
                flip_button.setAttribute("type","button");
                flip_button.setAttribute("id","button"+prev_del);
                flip_button.setAttribute("value","Flip");
                flip_button.setAttribute("class","1");
                flip_button.setAttribute("onclick","setup()");
                flip_button.setAttribute("style","background-color: skyblue; color: white;padding: 6px;width: 5%;border: none;font-size: 20px;box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);-webkit-appearance: button;appearance: button;outline: none;"); 
                    
                flipButtons.push(flip_button);
                flipFlags.push(1);
                    
                parent=document.getElementById("dropdown");   
                td_ele=document.createElement("td");
                td_ele.setAttribute("id","emo"+prev_del);
                td_ele.setAttribute("style","padding:10px; text-align:center");
                select=document.createElement("select");
//                select.setAttribute("id","emolist"+prev_del);
//                select.setAttribute("onchange","select_img(this.id,true,this.value)");
//                select.setAttribute("style","background-color: skyblue;color: white; padding: 6px;width: 250px;border: none;font-size: 20px;box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);-webkit-appearance: button;appearance: button;outline: none;");
                td_ele.appendChild(select);
                    
                SAbutton_td=document.createElement("td");
                SAbutton_td.setAttribute("id","SAbutton"+prev_del);
                SAbutton_td.setAttribute("style","padding:5px; text-align: center");

//                SAtext_td=document.createElement("td");
//                SAtext_td.setAttribute("id","SAtextbox"+prev_del);
//                SAtext_td.setAttribute("style","padding:5px;");

                eval_button = document.createElement("input");
                eval_button.setAttribute("id","SA"+prev_del);
                eval_button.setAttribute("style","background-color: skyblue;color: white; padding: 6px;width: 250px;border: none;font-size: 20px;box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);-webkit-appearance: button;appearance: button;outline: none;");
                eval_button.setAttribute("value","Evaluate Dialogue"+(prev_del+1));
                eval_button.setAttribute("name","field");
                eval_button.setAttribute("type","button");
                eval_button.setAttribute("onclick","evalSA("+prev_del+")");
                

//                eval_text = document.createElement("input");
//                eval_text.setAttribute("id","SAres"+prev_del);
//                eval_text.setAttribute("style","background-color: skyblue;color: white; padding: 6px;width: 250px;border: none;font-size: 20px;box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);-webkit-appearance: button;appearance: button;outline: none;");
//                eval_text.setAttribute("type","text");

                

                
                }
            
            
            if(images.length<numChars)
            {
                // if Character doesn't already exist, add it 
                if(!flag)
                {
                    images.splice(prev_del,0,val);
                    try
                    {
                        
                    basePath=images[prev_del].split("/")[6];
                    var current_emo=images[prev_del].split("/")[7].split(".")[0];
                        
                    var select_new=document.createElement("select");
                    select_new.setAttribute("id","emolist"+prev_del);
                    select_new.setAttribute("onchange","select_img(this.id,true,this.value)");
                    select_new.setAttribute("style","background-color: skyblue;color: white; padding: 6px;width: 250px;border: none;font-size: 20px;box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);-webkit-appearance: button;appearance: button;outline: none;");

                    var option_ele=document.createElement("option");
                    option_ele.innerHTML="Choose Expression"+(prev_del+1);
                    select_new.appendChild(option_ele);
                    if(current_emo=="default")
                        option_ele.setAttribute("selected","selected");
                        
                    for(var j=0;j<emotions_list[basePath].length;j++)
                    {
                        var option_eles=document.createElement("option");
                         var emo_value=emotions_list[basePath][j].split(".")[0];
                        if(emo_value!="info")
                            {
                            if(emo_value==current_emo && current_emo!="default")
                                option_eles.setAttribute("selected","selected");
                            option_eles.innerHTML=emo_value;
                            select_new.appendChild(option_eles);
                            }
                       
                    }
                    
                    if(old_emo!=null)
                        old_emo.replaceChild(select_new,old_emolist);
                    else
                        td_ele.replaceChild(select_new,select);
                    
                        
                    selectedDiv.appendChild(img_ele);
                    selectedDiv.appendChild(flip_button);
                    parent.appendChild(td_ele);
                    SAbutton_td.appendChild(eval_button);
//                    SAtext_td.appendChild(eval_text);
                    SAbutton.appendChild(SAbutton_td);
//                    SAtext.appendChild(SAtext_td);
                        
                    }
                    catch
                    {
                     old_selection.setAttribute("src",val);   
                     old_selection.style.display="inline";
                     old_flip.style.display="inline";
                     old_emo.style.display="inline";
                     old_SAbutton.style.display="inline";
//                     old_SAtext.style.display="inline";
                    
                    }
                   prev_del++;
                    
                }
                // if Character already exists, remove it 
                else
                {
                    document.getElementById("n-box").style.display="none";
                    document.getElementById("SAtext").style.display="none";
                    images.splice(prev_del,1);
                    old_selection.style.display="none";
                    old_flip.style.display="none";
                    old_emo.style.display="none";
                    old_SAbutton.style.display="none";
//                    old_SAtext.style.display="none";
                }
                
                
            }
            else
                {
                    // if Character already exists, remove it 
                    if(flag)
                    {

                        document.getElementById("n-box").style.display="none";
                        document.getElementById("tabs").style.display="none";
                        images.splice(prev_del,1);

                        old_selection.style.display="none";
                        old_flip.style.display="none";
                        old_emo.style.display="none";
                        old_SAbutton.style.display="none";
//                        old_SAtext.style.display="none";

                    }
                        
                }
        
            
            if(images.length==numChars)
                {
                    
                    // if Character emotion changes 
                    if(truth_val)
                    {
                        current_img=images[parseInt(val[val.length-1])];

                        new_img=current_img.split("/");
                        new_img.splice(new_img.length-1,1,emo_val+".png");
                        
                        new_img=new_img.join("/");
                        images.splice(val[val.length-1],1,new_img);

                    }
                    
                    // For each Character, update emotions, show as selected and add to canvas 
                    for(var i=0;i<images.length;i++)
                        {
                            
                            try
                            {
                                loader.add(images[i]);
                                
                                
                            }
                            catch
                            {
                                continue;
                            }
                        }
                     loader.load(setup);  
                     
                     $("#droptable").css('width',$("#selectedChars").css('width'));
                     $("#SAtable").css('width',$("#selectedChars").css('width'));
                     document.getElementById("n-box").style.display="block";
                     document.getElementById("tabs").style.display="block";
                     setup();
            }
            
        }
        
    /* Canvas setup  */
    function setup() {
    
      // total width
      const w =500;
        
      var imageSprites=[];
      var sumRatios= 0;
        
      // load characters    
      for (var i=0;i<images.length;i++)
          {
              
              imageSprites.push(new Sprite(resources[images[i]].texture));
              sumRatios += imageSprites[i].width/imageSprites[i].height;
          }
        
    let canvas_height=w/sumRatios;
    const initWidths = [];
    var totalWidths = 0;
        
    // default widths    
    for (var i=0;i<images.length;i++)
          {
              initWidths[i] = imageSprites[i].width/imageSprites[i].height*canvas_height;
              totalWidths+=initWidths[i];
          }
        
    var charCanvas = document.getElementById("charCanvas");
    var speechBubbles = document.getElementById("speechBubbles");
    
        
    // create canvases and speech bubbles    
    for (var i=0;i<images.length;i++)
          {
            
            apps[i] = new Application({ 
                            width: initWidths[i], 
                            height:canvas_height,                       
                            view : document.getElementById("c"+i),
                            backgroundColor: 0xFFFFFF
                          }
                        );
            var canvasCheck = document.getElementById("c"+i);
            if(canvasCheck==null)
            {
            var img_canvas=document.createElement("canvas");
            charCanvas.appendChild(img_canvas);
            img_canvas.setAttribute("id","c"+i);
            
            }
              
            var speechCheck = document.getElementById("diag"+i);
            if(speechCheck==null)
            {
              
            speech_td=document.createElement("td");
            speech_td.setAttribute("id","bubble"+i);
                
            speech_div=document.createElement("div");
              
            speech_textarea=document.createElement("textarea");
            speech_textarea.setAttribute("id","inside"+i);
            speech_textarea.setAttribute("style","border: none; overflow:hidden");
            speech_textarea.setAttribute("contenteditable","true");
              
            speech_div.setAttribute("id","diag"+i);
            speech_div.setAttribute("class","triangle-right");
            speech_div.setAttribute("style","border: 2.5px solid black");
              
            innertri_div=document.createElement("div");
            innertri_div.setAttribute("class","inner-tri");
              
            outertri_div=document.createElement("div");
            outertri_div.setAttribute("class","out-tri");
              
            speech_div.appendChild(speech_textarea);
            speech_td.appendChild(speech_div);
            speech_td.appendChild(innertri_div);
            speech_td.appendChild(outertri_div);
              
            speechBubbles.appendChild(speech_td);
                
            
            
            }
            var button=document.getElementById("button"+i);
            button.className="1";
            
          }
        
     const total_width=totalWidths;
     var vertical_amount=1-document.getElementById("myRange3").value;
     const total_height=canvas_height+vertical_amount*1000;
        
     $("#myRange").css('width',w);

    // current horizontal slider value 
    var t=document.getElementById("myRange").value;

    // current vertical slider value 
       
    // 1 character
    if(numChars==1)
        {
            
    let w0 = initWidths[0];
    let image0 = imageSprites[0];
    let app1= apps[0];
        
        
        // image0 becomes smaller
        if(t <= (w0/w))
        {

        var s0=t*w/w0;
            
        

        image0.scale.set(s0*canvas_height/image0.height);
            
        image0.x = 1;
        image0.y = (1-s0)*canvas_height ;//-vertical_amount*canvas_height;
            
        // resize canvas
        app1.renderer.resize(w, canvas_height);//*(1-vertical_amount));

            
            
        $("#diag0").css('width',image0.width*0.99);
        $("#inside0").css('width',parseFloat($("#diag0").css('width'))*0.99);
            
        $("#inside0").css('font-size',16*(1-vertical_amount+0.5)+'px')
        $("#diag0").css('height',(total_height-canvas_height)*0.8);
        $("#inside0").css('height',parseFloat($("#diag0").css('height'))*0.8);
        $("#bubble0").css('height',parseFloat($("#diag0").css('height'))+50);
            
        
            
//        $("#emolist0").css('width',image0.width);
//        $("#emolist1").css('width',(total_width-image0.width));


        }
            
        // image0 becomes bigger
        else
        {

        var s0 =   (1-t)*w/w0;
            
        

        image0.scale.set(s0*canvas_height/image0.height);
            
        // stop vertical translation when same height
        /*if(image0.height>canvas_height*(1-2*vertical_amount))
           {
            vertical_amount=1-(image0.height/canvas_height);
           }*/

            
        image0.x = 10;
        image0.y = (1-s0)*canvas_height/image0.height; 
            
            

        // resize canvas
        app1.renderer.resize(w, canvas_height);//*(1-vertical_amount));
            
         
        // resize speech bubble
        $("#diag0").css('width',(rem_width-image0.width)*0.99);
        $("#inside0").css('width',parseFloat($("#diag0").css('width'))*0.99);
            
        $("#inside0").css('font-size',16*(1-vertical_amount+0.5)+'px')
        $("#diag0").css('height',(total_height-canvas_height)*0.8);
        $("#inside0").css('height',parseFloat($("#diag0").css('height'))*0.8);
        $("#bubble0").css('height',parseFloat($("#diag0").css('height'))+50);
            

        }
        
        $("#myRange3").css('height',$(".canvas").css('height'));
        
            app1.stage.addChild(image0);
            
        }
        
        //2 or more characters
        else{
        
        
    let w0 = initWidths[0];
    let w1 = initWidths[initWidths.length-1];
    let image0 = imageSprites[0];
    let image1 = imageSprites[imageSprites.length-1];
    let app1= apps[0];
    let app2= apps[apps.length-1];
        
    var rem_width= w;
    var const_width=0;
        
    for (var i=1;i<images.length-1;i++)
          {
                    rem_width-=initWidths[i];
                    const_width+=initWidths[i];
          }
        
        // image1 becomes bigger
        if(t <= (w0/(rem_width)))
        {

        var s0=t*(rem_width)/w0;
        var s1=1+(2*(1-s0)*w0/w1);
            
        

        image0.scale.set(s0*canvas_height/image0.height);
        image1.scale.set(s1*canvas_height/image1.height);
            
        for (var i=1;i<images.length-1;i++)
          {
              
                    imageSprites[i].scale.set(canvas_height/imageSprites[i].height);
          }

        

        for (var i=1;i<images.length-1;i++)
          {
                    imageSprites[i].x=1;
                    imageSprites[i].y=(1-(canvas_height/imageSprites[i].height))*canvas_height;
                      
          }

        image0.x = 1;
        image0.y = (1-s0)*canvas_height;
            
        image1.x = 0.5 ;
        image1.y = (1-s1)*canvas_height/image1.height; 
            
        var resize_height=canvas_height;
            
         
        // resize canvases
        for (var j=images.length-1;j>0;j--)
          {
                     apps[j].renderer.resize(imageSprites[j].width, resize_height);
                      
          }
        
//        if(images.length==2)
//        {
//            document.getElementById("myRange3").style.display="block";
//            var vertical_amount=1-(document.getElementById("myRange3").value);
//        
//        // stop vertical translation when same height
//        if(image0.height>canvas_height*(1-2*vertical_amount))
//           {
//            vertical_amount=1-(image0.height/canvas_height);
//           }
//            
//        image0.y -= vertical_amount*canvas_height;
//        resize_height*=(1-vertical_amount);
//        }
            
        app1.renderer.resize(image0.width, resize_height);
        var total=total_width-image0.width;
        
        app2.renderer.resize(rem_width-image0.width, resize_height);

        

        // resize speech bubbles
         for (var j=images.length-2;j>0;j--)
          {
                $("#diag"+(j).toString()).css('width',imageSprites[j].width*0.99);
                $("#bubble"+(j).toString()).css('width',imageSprites[j].width);
                $("#inside"+(j).toString()).css('width',parseFloat($("#diag"+(j).toString()).css('width'))*0.8);
              
                $("#inside"+(j).toString()).css('font-size',16*(1-vertical_amount+0.5)+'px')
                $("#diag"+(j).toString()).css('height',(total_height-canvas_height)*0.8);
                $("#inside"+(j).toString()).css('height',parseFloat($("#diag"+(j).toString()).css('height'))*0.8);
                $("#bubble"+(j).toString()).css('height',parseFloat($("#diag"+(j).toString()).css('height'))+50);
                      
          }    
            
            
        $("#diag0").css('width',image0.width*0.99);
        $("#diag0").css('height',(total_height-canvas_height)*0.8);
            
        $("#bubble0").css('width',image0.width);
        $("#bubble0").css('height',parseFloat($("#diag0").css('height'))+50);
            
        $("#diag"+(images.length-1).toString()).css('width',(rem_width-image0.width)*0.99);
        $("#diag"+(images.length-1).toString()).css('height',(total_height-canvas_height)*0.8);    
            
        $("#bubble"+(images.length-1).toString()).css('width',(rem_width-image0.width));
        $("#bubble"+(images.length-1).toString()).css('height',parseFloat($("#diag"+(images.length-1).toString()).css('height'))+50);

        $("#inside0").css('width',parseFloat($("#diag0").css('width'))*0.99);
        $("#inside0").css('height',parseFloat($("#diag0").css('height'))*0.99);
        $("#inside0").css('font-size',16*(1-vertical_amount+0.5)+'px')
            
        $("#inside"+(images.length-1).toString()).css('width',parseFloat($("#diag"+(images.length-1).toString()).css('width'))*0.99);
        $("#inside"+(images.length-1).toString()).css('font-size',16*(1-vertical_amount+0.5)+'px')
        $("#inside"+(images.length-1).toString()).css('height',parseFloat($("#diag"+(images.length-1).toString()).css('height'))*0.99);
            
        var rect = document.getElementById("diag0").getBoundingClientRect();
        $("div#diag0 > .inner-tri").css('left',(rect.right-rect.left)/2+"px");
        $("div#diag0 > .outer-tri").css('left',-5+(rect.right-rect.left)/2+"px");
            
//        $("#emolist0").css('width',image0.width);
//        $("#emolist1").css('width',(total_width-image0.width));


        }
        // image0 becomes bigger
        else
        {

        var s1 =   (1-t)*(rem_width)/w1;
        var s0 =  1+(2*(1-s1)*w1/w0);
            
        

        image0.scale.set(s0*canvas_height/image0.height);
        image1.scale.set(s1*canvas_height/image1.height);

          for (var i=1;i<images.length-1;i++)
          {
                    imageSprites[i].scale.set(canvas_height/imageSprites[i].height);
          }

        for (var i=1;i<images.length-1;i++)
          {
                    imageSprites[i].x=1;
                    imageSprites[i].y=(1-canvas_height/imageSprites[i].height)*canvas_height;
                      
          }
            
        image0.x = 1;
        image0.y = (1-s0)*canvas_height/image0.height; 

        image1.x = 1;
        image1.y = (1-s1)*canvas_height;
            
         // resize canvases
         for (var j=images.length-1;j>0;j--)
          {
                     apps[j].renderer.resize(imageSprites[j].width, canvas_height);
                      
          }
            
         var resize_height=canvas_height;
//        if(images.length==2)
//        {
//            document.getElementById("myRange3").style.display="block";
//            var vertical_amount=1-(document.getElementById("myRange3").value);
//        
//        // stop vertical translation when same height
//        if(image1.height>canvas_height*(1-2*vertical_amount))
//           {
//            vertical_amount=1-(image1.height/canvas_height);
//           }
//            
//        image1.y -= vertical_amount*canvas_height;
//        resize_height*=(1-vertical_amount);
//            
//        }
            
        app1.renderer.resize(rem_width-image1.width, resize_height);
        app2.renderer.resize(image1.width, resize_height);
            
          // resize speech bubbles 
          for (var j=images.length-2;j>0;j--)
          {
                    $("#diag"+(j).toString()).css('width',imageSprites[j].width*0.99);
                    $("#bubble"+(j).toString()).css('width',imageSprites[j].width);
                    $("#inside"+(j).toString()).css('width',parseFloat($("#diag"+(j).toString()).css('width'))*0.8);
              
            $("#inside"+(j).toString()).css('font-size',16*(1-vertical_amount+0.5)+'px')
            $("#diag"+(j).toString()).css('height',(total_height-canvas_height)*0.8);
            $("#inside"+(j).toString()).css('height',parseFloat($("#diag"+(j).toString()).css('height'))*0.8);
            $("#bubble"+(j).toString()).css('height',parseFloat($("#diag"+(j).toString()).css('height'))+50);
                      
          }       
            
        $("#diag0").css('width',(rem_width-image1.width)*0.99);
        $("#diag0").css('height',(total_height-canvas_height)*0.8);    
            
        $("#bubble0").css('width',(rem_width-image1.width));
        $("#bubble0").css('height',parseFloat($("#diag0").css('height'))+50);    
            
        $("#diag"+(images.length-1).toString()).css('width',image1.width*0.99);
        $("#diag"+(images.length-1).toString()).css('height',(total_height-canvas_height)*0.8);        
            
        $("#bubble"+(images.length-1).toString()).css('width',image1.width);
        $("#bubble"+(images.length-1).toString()).css('height',parseFloat($("#diag"+(images.length-1).toString()).css('height'))+50);    

        $("#inside0").css('width',parseFloat($("#diag0").css('width'))*0.99);
        $("#inside0").css('height',parseFloat($("#diag0").css('height'))*0.99);
        $("#inside0").css('font-size',16*(1-vertical_amount+0.5)+'px')
            
        $("#inside"+(images.length-1).toString()).css('width',parseFloat($("#diag"+(images.length-1).toString()).css('width'))*0.99);
        $("#inside"+(images.length-1).toString()).css('font-size',16*(1-vertical_amount+0.5)+'px')
        $("#inside"+(images.length-1).toString()).css('height',parseFloat($("#diag"+(images.length-1).toString()).css('height'))*0.99);
            
//        $("#emolist0").css('width',(total_width-image1.width));
//        $("#emolist1").css('width',image1.width);
            

        }
        
        $("#myRange3").css('height',$(".canvas").css('height'));
        
        for (var i=0;i<images.length;i++)
          {
            apps[i].stage.addChild(imageSprites[i]);
                      
          }
    }
        
        
        // existing flip-status check
        for (var k=0;k<imageSprites.length;k++)
          {
        let image=imageSprites[k];
        let button=flipButtons[k];
              
        if (flipFlags[k]==-1)
            {
                image.anchor.x+=parseFloat(button.className);
                image.scale.x*=-1;
                button.className=(-parseFloat(button.className)).toString();
            }
              
          } 
        
        // flip button events
        for (var k=0;k<imageSprites.length;k++)
          {
        let image=imageSprites[k];
        let button=flipButtons[k];
            button.onclick=function()
        {
                    image.anchor.x+=parseFloat(button.className);
                    image.scale.x*=-1;
                    button.className=(-parseFloat(button.className)).toString();
                
                    flipFlags[parseFloat(button.id.charAt(button.id.length-1))]=parseFloat(button.className);
        };
              
          } 
        
        var renderer = PIXI.autoDetectRenderer(window.innerWidth, window.innerHeight);
        
        window.addEventListener("resize", function() {
            renderer.resize(window.innerWidth, window.innerHeight);
    }); 
        
        

    }
        
    
    
    

    
            
</script> 
</body>
</html> 