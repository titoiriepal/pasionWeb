const ruta=window.location.origin;function iniciarApp(){navegacionFija()}function navegacionFija(){const e=document.querySelector(".barra"),o=document.querySelector(".title-header"),t=document.querySelector(".box-header"),i=document.querySelector("body");window.addEventListener("scroll",(function(){o.getBoundingClientRect().bottom<0?(e.classList.add("fijo"),t.classList.add("fijo"),i.classList.add("body-scroll")):(e.classList.remove("fijo"),t.classList.remove("fijo"),i.classList.remove("body-scroll"))}))}document.addEventListener("DOMContentLoaded",(function(){iniciarApp()}));