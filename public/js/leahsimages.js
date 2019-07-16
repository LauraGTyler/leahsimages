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

function imagesclick(){
    if($(this).closest('ul').hasClass('clickable')){
	img=$.parseJSON($(this).find('span.imageatts').text());
	form = $('#imageDescModal').find('form');
	form.append('<input type="hidden" name="imageid" value="'+img.id+'" class="specatt">');
	if(img.notes==null || img.notes==''){
	    img.notes='';
	    $('#imagenotes').summernote('reset');
	}else{
	    $('#imagenotes').summernote('reset');
	    $('#imagenotes').summernote('pasteHTML', img.notes);
	}
	$('#caption').val(img.caption);
	$('#imageDescModal .modal-header').append('<img src="'+img.thumbpath+'/thumb_'+img.imagename+'" class="specatt">');
	$('#imageDescModal').modal('show');
	
    }
}

$(document).ready(function(){

	$('#summernote').summernote({
	    height: 300,
	});
    
    $('#imagenotes').summernote({
	  height:300,
	});

    $('#savefolderatts').on('click',function(){
	data=$('form#folderatts').serialize();
	$.ajax({
                url: '/ajax/savefolderatts',
                 data: data,
                success: function(result){
        	    var res = $.parseJSON(result);
                    if (res.success){
        		console.log('Saved folderatts');
        	    }
                }});
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
	$('#savefolderorder').removeClass('hidden');
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
   
    $('#images li').on('click', imagesclick);
    
    imageDescModalhtml =$('#imageDescModal').html();

    $('#imageDescModal').on('hidden.bs.modal', function (e) {
	$('#imagenotes').summernote('reset');

	$('#imageDescModal .specatt').remove();
    });
	
   $('#saveimgatts').on('click',function(){
	data=$('form#imgatts').serialize();
	$.ajax({
                url: '/ajax/saveimageatts',
                 data: data,
                success: function(result){
        	    var res = $.parseJSON(result);
                    if (res.success){
			$('#imageli'+res.imageid).replaceWith(res.imageli);
			$('#imageli'+res.imageid).on('click', imagesclick);
        		console.log('Saved imgatts and updated page');
        	    }
		    $('#imageDescModal').modal('hide');
                }});
   });
    $('#imgrotate').on('click',function(){
	angle=parseInt($('#imgangle').val());
	angle += 90;
	$('#imgrotate').next('img').rotate(angle);
	$('#imgangle').val(angle);
    });



    $( "#images" ).sortable({
	update: function( event, ui ) {
	    order=[];
	    $( this ).find('li').each(function( index, value ) {
		//get the id we are sorting
		img=$.parseJSON($(value).find('span.imageatts').text());
		order[index]= img.id;
	    });
	    // console.log(order);
	    //ajax call with order here..
	   $.ajax({
                url: '/ajax/imageorder',
	        data: 'order='+JSON.stringify(order),
                success: function(result){
        	    var res = $.parseJSON(result);
                    if (res.success){
        		console.log('images reordered');
        	    }
		    }});

	    
	}});
    $( "#images" ).sortable("disable");
    
    $('#reorderimages').on('click', function(){
	$(this).hide();
	$('#saveimageorder').html("Save image order");
	$('#saveimageorder').removeClass('hidden');
	$('#saveimageorder').show(); 
	$('#images').addClass('sortable');
	$('#images').removeClass('clickable');
	    
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

