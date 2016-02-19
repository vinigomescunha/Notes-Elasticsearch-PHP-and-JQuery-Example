
/**
verify is not a number if function not exists
*/
NaNVerify = function( n ) {
	return (typeof n == 'number' && n != 0 && !n);
};

/**
get hash and split to params page -> pagination
*/
chkParams = function() {
	hp = document.location.hash.replace("#", ""), 
	hps = nps = [];
	hps = hp.split(";");
	if( hp.length > 0)
		for(var i in hps ) {
			nps=hps[i].split("=");
			params[nps[0]] = nps[1];
		}
	if( typeof params['page'] == 'undefined') params['page'] = 0;
	params['from'] = parseInt( params['size'] * params["page"] );
	return params;
};

/**
populate container id 
*/
domContainer = function( l ) {
	
	$('#container').html('');
	$('#pagination').html('');
	if( l.hits.hits.length == 0 && params['page'] > 0  ) {
		switchList(parseInt(params["page"]-1));
	} else if( l.hits.hits.length == 0 && params['page'] == 0  ) {
		$('#container').html('<div class="large-12 text-center"><h2>No Results</h2><h3>Nothing found</h3></div>');
	}
	c=0;
	/* append items to container */
	$.each(l.hits.hits, function( t, v ) {
		source={};
		for( var i in v._source )
			source[i] = v._source[i]; 
		$('#container').append('<div class="large-4 medium-4 columns">\
						<p><a class="echo" target-id=' + v._id + ' href="javascript:void(0)"> ' + source['title'] + ' </a>\
						<br />\
						' + source['text'] + '</p>\
					</div>');
	});

	/* append pagination */
	if( l.hits.total > params['size'])
		for(var v=0; v < l.hits.total; v += params['size']  ) { 
			$('#pagination').append('<li' + (params['page'] == c ? ' class=\'current\' ' : '') + '>\
							<a href="javascript:switchList(' + c + ')">' + (c+1) + '</a>\
						</li>');
			c++;
	}
};

/**
modify hash page and list data page based(hash)
*/
switchList = function( c ) {

	window.location.hash = '#page=' + c;
	list();
}

/* search json to container */
search = function(term ) {
	url = 'call.php?action=search&q[' + term.id + ']=' + term.name + '&from=' + params['from']+ '&size=' + params['size'];
	$.getJSON(url).done( function( d ) { domContainer(d); });
};

/**
get via jquery ajax  and display data with domContainer Function
*/
list = function() {

	chkParams();
	url = defHost + '/' + defIndex + '/_search?size=' + params['size'] + '&from=' + params['from'] + '&sort=date:desc';
	$.ajax({ url: url, dataType: 'jsonp', type: 'GET', crossDomain: true, success: function( data ) { domContainer(data); }	});
};

/*---------------------------events------------------------------------------*/
/**
submit form ajax
*/
$('#send').on('submit', function( e ) {

	e.preventDefault();
	var i = $(this).find(':input[type="text"], textarea'), data={};
	data.fields = {};
	$.each(i, function( k, v ) { data['fields'][$(v).attr('id')]  = $(v).val(); });
	url = "call.php?action=index", data['fields']['date'] = new Date().getTime();
	$.post( url, data ).always(function( d ) { 
		text =  "Look the result <a  target='_blank' href='" + defHost + "/" + defIndex + "/" + defType + "/" + d._id + "'>here</a> !";
		swal({title: "Insert!", text: text, type: "success", html: true });
		setTimeout(function() { list(); }, 2000);
	});
	$(this).get(0).reset();
} );

/**
on click to display each item
*/
$(document).on('click', '.echo' , function( e ) {

	var id = $(e.target).attr('target-id'),
	url = "call.php?action=get&id=" + id ;
	$.post( url ).always(function( d ) { 
		date = new Date(parseInt(d._source.date)).toLocaleString();
		html = "<div class=\"callout large\">\
				<h2>" + d._source.title + "</h2>\
				<h3>" + d._source.text + "</h3>\
				<p><span class=\"float-left\">" + date + "</p>\
				<a target-id=" + d._id + " class='xdelete float-right'>delete</a>\
			</div>";
		swal({title:'', text:html, showConfirmButton:false, showCancelButton: true, cancelButtonText:"Close", html:true});		
		setTimeout( function() { list(); }, 2000);	
	});
});

/**
delete record
*/
$(document).on('click', '.xdelete' , function( e ) {

	var id = $(e.target).attr('target-id'),
	url = "call.php?action=delete&id=" + id ;
	$.post( url ).always(function( d ) { 
		swal({title:'Delete!', text:"The record was deleted successfully", html:true});		
		setTimeout( function() { list(); }, 2000);	
	});
});

/**
search results
*/
$(document).on('submit', '#search' , 
	function( e ) {
		var val = $(e.target).find('#search').val();
		if( val == "" ) {
			list(); 
			return false;
		}
		search({id:"title", name: val});
	}
);
/* -----------------------pre params------------------------------*/
chkParams();
list();

