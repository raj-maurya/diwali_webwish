

<?php


 ?>





<!doctype html>
<html>
    <head>
        <meta charset="utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>
        <meta name="format-detection"content="telephone=no">
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
        <meta name="keywords" content="" />
        <meta name="description" content="" />
<script type="text/javascript">
// <![CDATA[
var bits=80; // how many bits
var speed=33; // how fast - smaller is faster
var bangs=5; // how many can be launched simultaneously (note that using too many can slow the script down)
var colours=new Array("#03f", "#f03", "#0e0", "#93f", "#0cf", "#f93", "#f0c");
//                     blue    red     green   purple  cyan    orange  pink

/****************************
*      Fireworks Effect     *
*(c)2004-14 mf2fm web-design*
*  http://www.mf2fm.com/rv  *
* DON'T EDIT BELOW THIS BOX *
****************************/
var bangheight=new Array();
var intensity=new Array();
var colour=new Array();
var Xpos=new Array();
var Ypos=new Array();
var dX=new Array();
var dY=new Array();
var stars=new Array();
var decay=new Array();
var swide=800;
var shigh=600;
var boddie;

if (typeof('addRVLoadEvent')!='function') function addRVLoadEvent(funky) {
  var oldonload=window.onload;
  if (typeof(oldonload)!='function') window.onload=funky;
  else window.onload=function() {
    if (oldonload) oldonload();
    funky();
  }
}

addRVLoadEvent(light_blue_touchpaper);

function light_blue_touchpaper() { if (document.getElementById) {
  var i;
  boddie=document.createElement("div");
  boddie.style.position="fixed";
  boddie.style.top="-100px";
  boddie.style.left="0px";
  boddie.style.overflow="visible";
  boddie.style.width="1px";
  boddie.style.height="1px";
  boddie.style.backgroundColor="transparent";
  document.body.appendChild(boddie);
  set_width();
  for (i=0; i<bangs; i++) {
    write_fire(i);
    launch(i);
    setInterval('stepthrough('+i+')', speed);
  }
}}

function write_fire(N) {
  var i, rlef, rdow;
  stars[N+'r']=createDiv('|', 12);
  boddie.appendChild(stars[N+'r']);
  for (i=bits*N; i<bits+bits*N; i++) {
    stars[i]=createDiv('*', 13);
    boddie.appendChild(stars[i]);
  }
}

function createDiv(char, size) {
  var div=document.createElement("div");
  div.style.font=size+"px monospace";
  div.style.position="absolute";
  div.style.backgroundColor="transparent";
  div.appendChild(document.createTextNode(char));
  return (div);
}

function launch(N) {
  colour[N]=Math.floor(Math.random()*colours.length);
  Xpos[N+"r"]=swide*0.5;
  Ypos[N+"r"]=shigh-5;
  bangheight[N]=Math.round((0.5+Math.random())*shigh*0.4);
  dX[N+"r"]=(Math.random()-0.5)*swide/bangheight[N];
  if (dX[N+"r"]>1.25) stars[N+"r"].firstChild.nodeValue="/";
  else if (dX[N+"r"]<-1.25) stars[N+"r"].firstChild.nodeValue="\\";
  else stars[N+"r"].firstChild.nodeValue="|";
  stars[N+"r"].style.color=colours[colour[N]];
}

function bang(N) {
  var i, Z, A=0;
  for (i=bits*N; i<bits+bits*N; i++) {
    Z=stars[i].style;
    Z.left=Xpos[i]+"px";
    Z.top=Ypos[i]+"px";
    if (decay[i]) decay[i]--;
    else A++;
    if (decay[i]==15) Z.fontSize="7px";
    else if (decay[i]==7) Z.fontSize="2px";
    else if (decay[i]==1) Z.visibility="hidden";
	if (decay[i]>1 && Math.random()<.1) {
	   Z.visibility="hidden";
	   setTimeout('stars['+i+'].style.visibility="visible"', speed-1);
	}
    Xpos[i]+=dX[i];
    Ypos[i]+=(dY[i]+=1.25/intensity[N]);

  }
  if (A!=bits) setTimeout("bang("+N+")", speed);
}

function stepthrough(N) {
  var i, M, Z;
  var oldx=Xpos[N+"r"];
  var oldy=Ypos[N+"r"];
  Xpos[N+"r"]+=dX[N+"r"];
  Ypos[N+"r"]-=4;
  if (Ypos[N+"r"]<bangheight[N]) {
    M=Math.floor(Math.random()*3*colours.length);
    intensity[N]=5+Math.random()*4;
    for (i=N*bits; i<bits+bits*N; i++) {
      Xpos[i]=Xpos[N+"r"];
      Ypos[i]=Ypos[N+"r"];
      dY[i]=(Math.random()-0.5)*intensity[N];
      dX[i]=(Math.random()-0.5)*(intensity[N]-Math.abs(dY[i]))*1.25;
      decay[i]=16+Math.floor(Math.random()*16);
      Z=stars[i];
      if (M<colours.length) Z.style.color=colours[i%2?colour[N]:M];
      else if (M<2*colours.length) Z.style.color=colours[colour[N]];
      else Z.style.color=colours[i%colours.length];
      Z.style.fontSize="13px";
      Z.style.visibility="visible";
    }
    bang(N);
    launch(N);
  }
  stars[N+"r"].style.left=oldx+"px";
  stars[N+"r"].style.top=oldy+"px";
}

window.onresize=set_width;
function set_width() {
  var sw_min=999999;
  var sh_min=999999;
  if (document.documentElement && document.documentElement.clientWidth) {
    if (document.documentElement.clientWidth>0) sw_min=document.documentElement.clientWidth;
    if (document.documentElement.clientHeight>0) sh_min=document.documentElement.clientHeight;
  }
  if (typeof(self.innerWidth)!="undefined" && self.innerWidth) {
    if (self.innerWidth>0 && self.innerWidth<sw_min) sw_min=self.innerWidth;
    if (self.innerHeight>0 && self.innerHeight<sh_min) sh_min=self.innerHeight;
  }
  if (document.body.clientWidth) {
    if (document.body.clientWidth>0 && document.body.clientWidth<sw_min) sw_min=document.body.clientWidth;
    if (document.body.clientHeight>0 && document.body.clientHeight<sh_min) sh_min=document.body.clientHeight;
  }
  if (sw_min==999999 || sh_min==999999) {
    sw_min=800;
    sh_min=600;
  }
  swide=sw_min;
  shigh=sh_min;
}
// ]]>
</script>

        <meta property="og:title" content="Raj Kumar Maurya Wish You & Your Family A Very Happy Diwali" />
        <meta property="og:image" content="http://previews.123rf.com/images/alkkdsg/alkkdsg1408/alkkdsg140800108/30878249-Diwali-candle-light-Stock-Vector.jpg" />
        <meta property="og:image:width" content="1200" />
        <meta property="og:image:height" content="630" />
        <meta property="og:description" content="#DiwaliWishes By Raj Kumar Maurya" />

        <meta name="twitter:description" content="#DiwaliWishes By Raj Kumar Maurya" />
        <meta name="twitter:image" content="http://previews.123rf.com/images/alkkdsg/alkkdsg1408/alkkdsg140800108/30878249-Diwali-candle-light-Stock-Vector.jpg" />

        <title>Raj Kumar Maurya Wishes you a Very Happy & Prosperous Diwali</title>
        <link rel="shortcut icon" href="/https://diwali.oneplusstore.in/images/diwali-rush/favicon.ico" type="image/x-icon">

        <link href='//fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" type="text/css" href="https://diwali.oneplusstore.in/styles/diwali/swiper-3.3.1.min.css?20161025114">
        <link rel="stylesheet" type="text/css" href="https://diwali.oneplusstore.in/styles/diwali/diwali.css?20161025114">
    </head>
    <body class="body-loading" >

       <div class="loading-content">
            <div class="loading-img"><img alt="" src="https://diwali.oneplusstore.in/images/diwali-rush/loading.svg?20161025114"></div>
           <div style="width: 970px; margin: auto">
            </div>
            <div class="rotate">
                <span class="triangle base"></span><span class="triangle no1"></span><span class="triangle no2">
                </span><span class="triangle no3"></span>
            </div>
        </div>

        <div class="diwali-content">
            <header>
                <nav>
                    <ul class="clearfix">
                        <li class="header_logo">
                      <h3><a href="http://rajkmaurya.com" style="color: white;"><b>Raj Kumar Maurya | </b> <a href="https://www.google.co.in/webhp?sourceid=chrome-instant&ion=1&espv=2&es_th=1&ie=UTF-8#q=rajkmaurya111" style="color: white;"><b>rajkmaurya111</b></a></h3>
                        </li>
                        <li class="header_home">
                            <h3><b>#DiwaliWishes</b></h3>
                        </li>
                    </ul>
                </nav>
            </header>
            <main>
                <!-- 首屏 -->
                <section class="screen-enter">
                    <!-- 万花筒 -->
                    <div class="full">
                        <div class="Kaleidoscope">
                            <div class="imgbox">

                                <div class="fireworks">

                                    <img class="bg-img" alt="" src="https://diwali.oneplusstore.in/images/diwali-rush/5-1.svg?20161025114">
                                    <div class="s first"><img alt="" src="https://diwali.oneplusstore.in/images/diwali-rush/5-3.svg?20161025114"></div>
                                    <div class="s"><img alt="" src="https://diwali.oneplusstore.in/images/diwali-rush/5-2.svg?20161025114"></div>
                                    <div class="s"><img alt="" src="https://diwali.oneplusstore.in/images/diwali-rush/5-1.svg?20161025114"></div>
                                </div>
                                <div class="fireworks">
                                    <img class="bg-img" alt="" src="https://diwali.oneplusstore.in/images/diwali-rush/1-1.svg?20161025114">
                                    <div class="s first"><img alt="" src="https://diwali.oneplusstore.in/images/diwali-rush/1-5.svg?20161025114"></div>
                                    <div class="s"><img alt="" src="https://diwali.oneplusstore.in/images/diwali-rush/1-4.svg?20161025114"></div>
                                    <div class="s"><img alt="" src="https://diwali.oneplusstore.in/images/diwali-rush/1-3.svg?20161025114"></div>
                                    <div class="s"><img alt="" src="https://diwali.oneplusstore.in/images/diwali-rush/1-2.svg?20161025114"></div>
                                    <div class="s"><img alt="" src="https://diwali.oneplusstore.in/images/diwali-rush/1-1.svg?20161025114"></div>
                                </div>
                                <div class="fireworks">
                                    <img class="bg-img" alt="" src="https://diwali.oneplusstore.in/images/diwali-rush/2-1.svg?20161025114">
                                    <div class="s first"><img alt="" src="https://diwali.oneplusstore.in/images/diwali-rush/2-4.svg?20161025114"></div>
                                    <div class="s"><img alt="" src="https://diwali.oneplusstore.in/images/diwali-rush/2-3.svg?20161025114"></div>
                                    <div class="s"><img alt="" src="https://diwali.oneplusstore.in/images/diwali-rush/2-2.svg?20161025114"></div>
                                    <div class="s"><img alt="" src="https://diwali.oneplusstore.in/images/diwali-rush/2-1.svg?20161025114"></div>
                                </div>
                                <div class="fireworks">
                                    <img class="bg-img" alt="" src="https://diwali.oneplusstore.in/images/diwali-rush/3-1.svg?20161025114">
                                    <div class="s first"><img alt="" src="https://diwali.oneplusstore.in/images/diwali-rush/3-5.svg?20161025114"></div>
                                    <div class="s"><img alt="" src="https://diwali.oneplusstore.in/images/diwali-rush/3-4.svg?20161025114"></div>
                                    <div class="s"><img alt="" src="https://diwali.oneplusstore.in/images/diwali-rush/3-3.svg?20161025114"></div>
                                    <div class="s"><img alt="" src="https://diwali.oneplusstore.in/images/diwali-rush/3-2.svg?20161025114"></div>
                                    <div class="s"><img alt="" src="https://diwali.oneplusstore.in/images/diwali-rush/3-1.svg?20161025114"></div>
                                </div>
                                <div class="fireworks">
                                    <img class="bg-img" alt="" src="https://diwali.oneplusstore.in/images/diwali-rush/4-1.svg?20161025114">
                                    <div class="s first"><img alt="" src="https://diwali.oneplusstore.in/images/diwali-rush/4-3.svg?20161025114"></div>
                                    <div class="s"><img alt="" src="https://diwali.oneplusstore.in/images/diwali-rush/4-2.svg?20161025114"></div>
                                    <div class="s"><img alt="" src="https://diwali.oneplusstore.in/images/diwali-rush/4-1.svg?20161025114"></div>
                                </div>
                            </div>

                            <!-- 文案 -->
                            <div class="textbox">
                                <h1>A Very Happy & Prosperous Diwali to You & Your Family </h1>
                                <p class="p1">
                                    <span><b>From Raj Kumar Maurya</b></span>
                                    <br>
                                    <a href="http://rajkmaurya.com" style="color: white;"><b>http://rajkmaurya.com</b></a>
                                </p>
                            </div>
                        </div>
                    </div>


                </section>

                <!-- 转盘 -->
                <section class="screen-lottery" >
<br>
<h2 style="color: green;">   <b><i><center> "तेजोमय झाला आजचा प्रकाश,
जुना कालचा काळोख,
लुकलुकणार्‍या चांदण्याला किरणांचा सोनेरी अभिषेक,
सारे रोजचे तरीही भासे नवा सहवास,
सोन्यासारख्या लोकांसाठी खास,
दिवाळीच्या हार्दिक शुभेच्छा!"</center></i></b></h2>
<br>
                    <div class="wheelbox lotteryContainer">

                        <div class="lottery-intro">
                            <h2>It's a wrap</h2>


                        </div>

                        <div class="prize-info">

                        </div>

                        <div class="wheel">
                            <div class="ring">
                                <div class="v-box"></div>
                                <div class="s"><img alt="" src="https://diwali.oneplusstore.in/images/diwali-rush/wheel-4.svg?20161025114"></div>
                                <div class="s"><img alt="" src="https://diwali.oneplusstore.in/images/diwali-rush/wheel-3.svg?20161025114"></div>
                                <div class="s"><img alt="" src="https://diwali.oneplusstore.in/images/diwali-rush/wheel-2.svg?20161025114"></div>
                                <div class="s"><img alt="" src="https://diwali.oneplusstore.in/images/diwali-rush/wheel-1.svg?20161025114"></div>
                            </div>

                            <div class="dot"></div>
                            <div class="season">
                                <i class="active"></i>
                                <i></i>
                                <i></i>
                                <i></i>
                                <i></i>
                                <i></i>
                                <i></i>
                                <i></i>
                                <i></i>
                                <i></i>
                            </div>
                            <button id="start" class="start-button"><span class="go">Happy Diwali!</span></button>
                        </div>

                    </div>



                    </div>



                    </div>




                </section>





                                 </div>

            </div>
        </script>

        <script src="https://diwali.oneplusstore.in/scripts/diwali/jquery-3.1.1.min.js?20161025114"></script>
        <script src="https://diwali.oneplusstore.in/scripts/diwali/newDialog.js?20161025114"></script>
        <script src="https://diwali.oneplusstore.in/scripts/diwali/diwali.js?20161025114"></script>

    </body>
</noscript>
<div style="text-align: center;"><div style="position:relative; top:0; margin-right:auto;margin-left:auto; z-index:99999">
<script>
   (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
   (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
   m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
   })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

   ga('create', 'UA-75037254-1', 'auto');
   ga('send', 'pageview');

 </script>

</div></div>
</html>
