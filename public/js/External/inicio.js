var scene = document.getElementById('scene');
var parallaxInstance = new Parallax(scene);
var scene2 = document.getElementById('scene2');
var parallaxInstance = new Parallax(scene2);
$("#header-p").height($(window).height()*0.85);
$( "#fa2" ).click(function() {
  window.location.href = "productos/acciones";
});
$("#fa1").click(function(e) {
  console.log("new tab");
  e.preventDefault(); var tab = window.open('https://www.youtube.com/watch?v=bfNuILaopkY', '_blank');
  if(tab){
    tab.focus(); //ir a la pestaña
  }else{
    alert('Pestañas bloqueadas, activa las ventanas emergentes (Popups) ');
    return false;
  }
});
$("#fa3").click(function(e) {
  console.log("new tab");
  e.preventDefault(); var tab = window.open('https://www.youtube.com/watch?v=NI0XslOXuZ8', '_blank');
  if(tab){
    tab.focus(); //ir a la pestaña
  }else{
    alert('Pestañas bloqueadas, activa las ventanas emergentes (Popups) ');
    return false;
  }
});
