$(document).ready(function(){
	$('#myTable').DataTable({
		"oLanguage": {
			"sSearch": "Cari : ",
			"sLengthMenu": " _MENU_",
		}});


	
	var table = $('#myTable2').DataTable({
		"columnDefs": [
			{ "visible": false, "targets": 2 }
		],
		"order": [[ 2, 'asc' ]],
		"displayLength": 25,
		"oLanguage": {
			"sSearch": "Cari : "
		},
		"drawCallback": function ( settings ) {
			var api = this.api();
			var rows = api.rows( {page:'current'} ).nodes();
			var last=null;
 
			api.column(2, {page:'current'} ).data().each( function ( group, i ) {
				if ( last !== group ) {
					$(rows).eq( i ).before(
						'<tr class="group"><td colspan="7">'+group+'</td></tr>'
					);
 
					last = group;
				}
			} );
		}
	} );
 
	// Order by the grouping
	$('#myTable2 tbody').on( 'click', 'tr.group', function () {
		var currentOrder = table.order()[0];
		if ( currentOrder[0] === 2 && currentOrder[1] === 'asc' ) {
			table.order( [ 2, 'desc' ] ).draw();
		}
		else {
			table.order( [ 2, 'asc' ] ).draw();
		}
	});

	var table = $('#myTable3').DataTable({
		"columnDefs": [
			{ "visible": false, "targets": 2 }
		],
		"order": [[ 2, 'asc' ]],
		"displayLength": 25,
		"oLanguage": {
			"sSearch": "Cari : "
		},
		"drawCallback": function ( settings ) {
			var api = this.api();
			var rows = api.rows( {page:'current'} ).nodes();
			var last=null;
 
			api.column(2, {page:'current'} ).data().each( function ( group, i ) {
				if ( last !== group ) {
					$(rows).eq( i ).before(
						'<tr class="group"><td colspan="9">'+group+'</td></tr>'
					);
 
					last = group;
				}
			} );
		}
	} );
 
	// Order by the grouping
	$('#myTable3 tbody').on( 'click', 'tr.group', function () {
		var currentOrder = table.order()[0];
		if ( currentOrder[0] === 2 && currentOrder[1] === 'asc' ) {
			table.order( [ 2, 'desc' ] ).draw();
		}
		else {
			table.order( [ 2, 'asc' ] ).draw();
		}
	});
	
});