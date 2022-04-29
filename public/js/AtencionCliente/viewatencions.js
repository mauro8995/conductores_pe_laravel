function load_viewatencions(){
  $.ajax({
    url: "/atencion/facetofacegetatencions",
    type:"GET",
    beforeSend: function () {
    },
  }).done( function(data) {
   $('#atencionsopens').html('');
   if (data.atencionsopencount > 0){
     $.each(JSON.parse(data.atencionsopen), function( key, value ) {
       var pizza = value.get_customer.first_name;
       var porciones = pizza.split(' ');
       var apepater = value.get_customer.last_name;
       var letra = apepater.charAt(0);
       if (value.id_status_att == 6){
         $("#atencionsopens").append('<div class="col-sm-3"><label class="zoomt atentionsopenactive" style="">'+porciones[0]+' '+letra+'</label></div>');
       }else{
         $("#atencionsopens").append('<div class="col-sm-3"><label class="atentionsopen">'+porciones[0]+' '+letra+'</label></div>');
       }
     });
   }else{
       $('#atencionsopens').html('');
   }
   $('#atencionspends').html('');
   if (data.atencionspendientescount > 0){
     $.each(JSON.parse(data.atencionspendientes), function( key, value ) {
       var pizza1 = value.get_customer.first_name;
       var porciones1 = pizza1.split(' ');
       var apepater1 = value.get_customer.last_name;
       var letra1 = apepater1.charAt(0);
       $("#atencionspends").append('<div class="col-sm-4"><label class="atentionspends">'+porciones1[0]+' '+letra1+' - '+value.nro_ticket+'</label><label class="atentionpendmods">MOD '+value.nro_modulo+'</label></div>');
     });
   }else{
      $('#atencionspends').html('');
   }

   $('#divfinanzasTK').html('');
   if (data.registeratencionfinancount > 0){
     $.each(JSON.parse(data.registeratencionfinan), function( key, value ) {
       var pizza2 = value.get_customer.first_name;
       var porciones2 = pizza2.split(' ');
       var apepater2 = value.get_customer.last_name;
       var letra2 = apepater2.charAt(0);
       if (value.id_status_ts == 2){
         $("#divfinanzasTK").append('<center><label  class="atentionsfinancss">'+porciones2[0]+' '+letra2+' - #'+value.nro_ticket+'</label></center>');
       }else if (value.id_status_ts == 3){
         $("#divfinanzasTK").append('<center><label  class="atentionsfinancssblock">'+porciones2[0]+' '+letra2+' - #'+value.nro_ticket+' <i style="color: #fafafa !important; "class="fa fa-lock"></i></label></center>');
       }else{
         $("#divfinanzasTK").append('<center><label class="atentionsfinancssactive zoom">'+porciones2[0]+' '+letra2+' - #'+value.nro_ticket+'</label></center>');
       }
     });
   }else{
      $('#divfinanzasTK').html('');
   }

   $('#divadministracionTK').html('');
   if (data.registeratencionadmincount > 0){
     $.each(JSON.parse(data.registeratencionadmin), function( key, value ) {
       var pizza3 = value.get_customer.first_name;
       var porciones3 = pizza3.split(' ');
       var apepater3 = value.get_customer.last_name;
       var letra3 = apepater3.charAt(0);
       if (value.id_status_ts == 2){
         $("#divadministracionTK").append('<center><label class="atentionsadmincss">'+porciones3[0]+' '+letra3+' - #'+value.nro_ticket+'</label></center>');
       }else if (value.id_status_ts == 3){
         $("#divadministracionTK").append('<center><label  class="atentionsadmincssblock">'+porciones3[0]+' '+letra3+' - #'+value.nro_ticket+' <i class="fa fa-lock"></i></label></center>');
       }else{
         $("#divadministracionTK").append('<center><label class="zoom" style="text-align: left; padding:25px; margin: 30px 0px 0px 0px; width: 800px; background: #fcbe00; font-size: 80px; color: white !important; border: 6px dashed #ffe23c;">'+porciones3[0]+' '+letra3+' - #'+value.nro_ticket+'</label></center>');
       }
     });
   }else{
      $('#divadministracionTK').html('');
   }

   if (data.callatentioncount > 0){
     $.each(JSON.parse(data.callatention), function( key, value ) {
       var nameatencion = value.get_customer.first_name;
       var apeatencion = value.get_customer.last_name;
       var nroatencion = value.nro_modulo;
       var letra = nameatencion.split(' ');
       var letra1 = apeatencion.split(' ');
       var text = letra[0].toLowerCase()+' '+letra1[0].toLowerCase()+' '+letra1[1].toLowerCase()+' acercarse al módulo de atención '+nroatencion;
       responsiveVoice.speak(text,"Spanish Female");
       text=encodeURIComponent(text);
       var url="http://translate.google.com/translate_tts?tl=es&q="+text;
       $("audio").attr('src',url).get(0).play();
     });
   }



   if (data.callticketgestcount > 0){
     $.each(JSON.parse(data.callticketgest), function( key, value ) {
       var nameatenciond = value.get_customer.first_name;
       var apeatenciond = value.get_customer.last_name;
       var groupd = value.get_groups.description;
       var letrad = nameatenciond.split(' ');
       var letra1d = apeatenciond.split(' ');
       console.log(letrad);
       console.log(letra1d);
       var text1 = letrad[0].toLowerCase()+' '+letra1d[0].toLowerCase();
       responsiveVoice.speak(text1,"Spanish Female");
       text1=encodeURIComponent(text1);
       var url="http://translate.google.com/translate_tts?tl=es&q="+text1;
       $("audio").attr('src',url).get(0).play();
     });
   }



  }).fail( function(error) {
    console.log(error);
    alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
  }).always( function() {
  });
}

setInterval(function(){
 load_viewatencions();
}, 2000);
