//funtion selectFolder is not necessary and show info about a multifile upload
function selectFolder(e) {
    var s='';
   for (var i = 0; i < e.target.files.length; i++) {
      s += e.target.files[i].name + '\n';
      s += e.target.files[i].size + ' Bytes\n';
      s += e.target.files[i].type;
      
   }
    alert(s);
}


$(document).ready(function(){
    //summernote
    $(document).ready(function() {
      $('#summernote').summernote();
    });

    
    //gallery stuff
    $('#caroselleft').on('click',function(){
	$('#myGallery').carousel("prev");
    });
    $('#caroselright').on('click',function(){
	$('#myGallery').carousel("next");
    });
    	$('.caroselimage').on('click',function(){
	    srcatt=$(this).attr('src');
	   // newsrc=srcatt.replace('thumb','large');
	    idatt=$(this).attr('id');
	    id=idatt.substr(5);
	    title=$('#leasimagestitle').text();
	    title=title.substr(13);
	    $('#directoryimage').html('<div class="center"><img src="'+srcatt+'" alt="'+title+'" title="'+title+'" /></div>');
	    $('#addimagediv a').text('Change associated folder image');
	    $(this).closest('div.modal').modal('hide');
	    
	     $.ajax({
                url: '/ajax/savedirectoryimage',
                 data: 'imageid='+id,
                success: function(result){
        	    var res = $.parseJSON(result);
                    if (res.success){
        		console.log('Directory image replaced');
        	    }
                }});
	});

    //folders
    
    $('#folders.clickable li').on('click', function(){
	link =$(this).find('a').attr('href');
	window.location.replace(link);
    });
	
    $( "#folders" ).sortable({
	update: function( event, ui ) {
	    order=[];
	    $( this ).find('li').each(function( index, value ) {
		hr = $(value).find('a').attr('href');
		order[index]= hr.substr(8);
	    });
	    console.log(order);
	    //ajax call with order here..
	    	     $.ajax({
                url: '/ajax/folderorder',
	        data: 'order='+JSON.stringify(order),
                success: function(result){
        	    var res = $.parseJSON(result);
                    if (res.success){
        		console.log('folders reordered');
        	    }
                }});
	    
	}});
    $( "#folders" ).sortable("disable");
    
    $('#reorderfolders').on('click', function(){
	$(this).hide();
	$('#savefolderorder').html("Save folder order");
	$('#savefolderorder').show(); 
	$('#folders').addClass('sortable');
	$('#folders').removeClass('clickable')
	$( "#folders" ).sortable("enable");
				
    });
    $('#savefolderorder').on('click', function(){
	$('#savefolderorder').hide();
	$('#reorderfolders').show();
	$( "#folders" ).sortable("disable");
	$('#folders').removeClass('sortable');
	$('#folders').addClass('clickable');
    });

    //images
   
    $('#images.clickable li').on('click', function(){
	img=$.parseJSON($(this).find('span.imageatts').text());
	form = $('#imageDescModal').find('form');
	form.append('<input type="hidden" name="imageid" value="'+img.id+'" class="specatt">');
	$('#imageDescModal .modal-header').append('<img src="'+img.thumbpath+'/thumb_'+img.imagename+'" class="specatt">');
	
      $('#imageDescModal').modal('show');
    });
    imageDescModalhtml =$('#imageDescModal').html();

    $('#imageDescModal').on('hidden.bs.modal', function (e) {
	$('#imageDescModal .specatt').remove();
    });
	




    $( "#images" ).sortable({
	update: function( event, ui ) {
	    order=[];
	    $( this ).find('li').each(function( index, value ) {
		//get the id we are sorting
	    });
	    //ajax call with order
	    
	}});
    $( "#images" ).sortable("disable");
    
    $('#reorderimages').on('click', function(){
	$(this).hide();
	$('#saveimageorder').html("Save image order");
	$('#saveimageorder').show(); 
	$('#images').addClass('sortable');
	$('#images').removeClass('clickable')
	$( "#images" ).sortable("enable");
				
    });
    $('#saveimageorder').on('click', function(){
	$('#saveimageorder').hide();
	$('#reorderimages').show();
	$( "#images" ).sortable("disable");
	$('#images').removeClass('sortable');
	$('#images').addClass('clickable');
    });

    
});

