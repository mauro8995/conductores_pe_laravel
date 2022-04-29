var codigoproceso        = 6;
var estatusproceso       = 1;
var table = $('#driver').DataTable();
var rolExterno;
alert(999);
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });




  $('#submit-file').on("click",function(e){
  	e.preventDefault();
  	$('#files').parse({
  		config: {
  			delimiter: ",",
  			complete: displayHTMLTable,
  		},
  		before: function(file, inputElem)
  		{
  			//console.log("Parsing file...", file);
  		},
  		error: function(err, file)
  		{
  			//console.log("ERROR:", err, file);
  		},
  		complete: function()
  		{
  			//console.log("Done with all files");
  		}
  	});
  });



  function displayHTMLTable(results){

  	var data = results.data;

  	console.log(data);

    $.ajax({
      url: "/list/import/data/office",
      type:"post",
      data:{data:data},
      beforeSend: function () {
      },
    }).done( function(d) {
      console.log(d);
    }).fail( function() {   alert("Ocurrio un error en la operación");   }).always( function() {  });
  }


//GET ARRAY FORM
$.fn.serializeObject = function(){
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};
