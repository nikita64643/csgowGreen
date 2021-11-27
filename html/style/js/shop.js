$(document).ready(function($) {	
     console.log('afdasd');
	window.allItems;
	window.realList= {};
    window.realListObj = {};
	window.itemsHolder = $('.store-items');
	allItems = itemsHolder.children('.short');
	
    $('#navbar-sort div a').on('click', function(e) {
		
        e.preventDefault();
        $('#navbar-sort div').removeClass('active');
        $(this).parent().toggleClass('active');

        $(this).attr('data-type') == "desc" ? desc = -1 : desc = 1;

        allItems.sort(function(a, b) {
            var an = a.getAttribute('data-price'), bn = b.getAttribute('data-price');
            return (parseInt(an) - parseInt(bn)) * desc;
        });

        allItems.detach().appendTo(itemsHolder);
    });
     $("input#searchInput").on("keyup", function(e) {
		// Set Timeout
		clearTimeout($.data(this, 'timer'));

		// Set Search String
		var search_string = $(this).val();
        var len = $('#lenth').size();
		
		// Do Search
		if (search_string == '') {
			$("div#shopstory").fadeOut();
			shop();
		}else{
			$("div#shopstory").fadeIn();
			$(this).data('timer', setTimeout(search, 100));
		};
	});
	$("input#priceFrom").on("keyup", function(e) {
       searchprice() ;
	});	
    $("input#priceTo").on("keyup", function(e) {
       searchprice() ;
	});	
})
function shop(){
			$.ajax({
				type: "GET",
				url: "/sys/api.php?shop",
				cache: false,
				success: function(html){
					$("div#items-list").html(html);
				}
			});
}
function buyitem(id){
	    $.ajax({
		url: "/sys/api.php",
        data: {
           act:"buymarket",		
           buy: id, 
        },
		type     : 'POST',
        success  : function(data)
        {
			shop();
			$.noty.closeAll();
            var n = noty({timeout: '2000',theme: 'successnoty',layout: 'center',text: data});
			setTimeout(function() {  window.location.href = "/shop/" },1000);
        }
	})
}
function shopitems(id) {
    $.ajax({
        type: "GET",
        url: "/sys/api.php?itemid=" + id,
        success: function(msg) {
            $("#shopf").html(msg);
        }
    });
}
function cart() {
        $.ajax({
            type: "GET",
            url: "/sys/api.php?cart",
            success: function(html) {
                $('#cartf').html(html);

            }
        });
    
    return false;
};

function search() {
		var query_value = $('input#searchInput').val();
		if(query_value !== ''){
			$.ajax({
				type: "POST",
				url: "/sys/api.php",
				data: { 
				   act:  "namesearch",
				   query: query_value 
				},
				cache: false,
				success: function(html){
					$("div#items-list").html(html);
						mdload();
				}
			});
		}return false;    
}
function searchprice() {
   var from100 = parseInt($('#priceFrom').val()) || 0;
    var to = parseInt($('#priceTo').val()) || 10e10;
			$.ajax({
				type: "POST",
				url: "/sys/api.php",
				data: { 
				   act : "shopsearch",
                   fromf: from1, 
                   to: to, 
                },
				success: function(html){
					$("div#items-list").html(html);
					mdload();
				}
			}); 
}