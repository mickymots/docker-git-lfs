<html> 
    
<head>
    <link rel="stylesheet" href="/styles.css">
    <link href="http://db.onlinewebfonts.com/c/f0daf632a7f9d6b0c1741305664fefb4?family=Lint+McCree+Intl+BB" rel="stylesheet" type="text/css"/> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
</head>   
    
<style>  
    #homeButton 
    {
      background-color: skyblue;
      color: white;
      padding: 6px;
      width: auto;
      border: none;
      font-size: 20px;
      box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
      -webkit-appearance: button;
      appearance: button;
      outline: none;
    }   
</style>
    
<body> 
    
    <center>
    
        <h1> Comic Interface</h1> <br> <br>

        <h3>This website provides an interface to create single-panel cartoon comics as shown below: </h3>

        <table >
            <tr style="border: 2px solid black;">
                <td> <img src="assets/home/strip1.png" width="100%" style="padding:10px"></td>
                <td> <img id="img_strip2" src="assets/home/strip2.png" width="100%" style="padding:10px"></td>
                <td> <img id="img_strip3" src="assets/home/strip3.png" width="100%" style="padding:10px"></td>
                <td> <img src="assets/home/strip4.png" width="100%" style="padding:10px"></td>
            </tr>
        </table>

        <br><br>

        <form action="home.php" method="get">
            <input id="homeButton" type="submit" value="Create Single-Panel Comics by Choosing Expressions">
            <br> <br> <br>
            <h2> More to come...</h2>
        </form>
    
    </center>
    
    <script>

        var max_height=document.getElementById("img_strip3").height;
        var strip2_w=document.getElementById("img_strip2").width;
        var strip2_h=document.getElementById("img_strip2").height;

        document.getElementById("img_strip2").height=max_height;
        document.getElementById("img_strip2").width=strip2_w/strip2_h*max_height;

    </script>
    
</body>
    
</html> 