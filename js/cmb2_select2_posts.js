(function($){

	'use strict';

	$( '.own-select2-posts-field' ).select2({
	
		allowClear         : true,
		minimumInputLength : 3,
		
			ajax: {
			  url      : cmb2_select2_posts_results.ajax_url,
			  dataType : 'json',
			  data	   : function ( term, page ) {
				  
			  	var post_type = $( this ).attr( 'data-type' );
				
				//console.log(term.term);
				
				return {
				  action	  : 'results',
				  list_search : term.term,
				  post_type	  : post_type
				};
			  },
			  
			  processResults: function ( data, params ) {
				return {
				  results : data,
				};
			  },
			  cache: true
			},
		
	});

})(jQuery);

