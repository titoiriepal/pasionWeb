var scrollspeed=1,speedjump=30,startdelay=1,topspace=-10,frameheight=270;function scrollStart(){dataobj=document.getElementById("scroll"),alturaNoticias=dataobj.offsetHeight,dataobj.style.top=topspace+"px",setTimeout("scrolling()",1e3*startdelay)}function scrolling(){dataobj.style.top=parseInt(dataobj.style.top)-scrollspeed+"px",parseInt(dataobj.style.top)<-1*alturaNoticias?(dataobj.style.top=frameheight+"px",setTimeout("scrolling()",0)):setTimeout("scrolling()",speedjump)}current=scrollspeed,document.addEventListener("DOMContentLoaded",(function(){scrollStart()}));