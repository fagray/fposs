// document.cookie = "opIndex = false; expires=Thu, 01 Jan 1970 00:00:00 UTC";
// var inv = getCookie("opInventory");
//
//
$(document).ready(function(){

	//alert( document.cookie('checked'));
	
	var uri  = window.location.pathname;
	// alert(uri);
	//determine the current uri
	switch(uri){

		case '/inventory' : 

		if(getCookie("opInventory") != 'true' ){


			inventory();
			
		}

		break;

		case '/' : 

			if( getCookie("opIndex") != 'true' ){

				index();

			}
	
		break;
	}


});

function index(){
		
			$('#PModal').click();

			//retrieve the best sellers for yesterdays production

			$.getJSON('/ai/production/best-sellers/yesterday',function(data){

			$.each(data,function(key,val){

				$('div#items-container').append('<strong>' + val.name + '</strong> with a total sales of Php ' + val.amount + '<hr/>');
				console.log(val.name  + ' ' + val.amount);
				});
			});

			//check if the user do not want to have a popup on the index page
			$('button.close').click(function(){

				if ( $('#cb_index' ).prop( "checked" ) ) {

					//alert("i am checked!!");
					//store the choice to a cookie variable
					setCookie("opIndex","true",1);

				}
			

			});


}//end of index function

function inventory(){

	//toggle the modal
	$('#IModal').click();

	$('#btnInventoryModal').click(function(){

				if ( $('#cb_inv' ).prop( "checked" ) ) {

					alert("i am checked!!");
					//store the choice to a cookie variable
				
					setCookie("opInventory","true",1);

				}
			

			});
	
	
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }


    return "";
}

