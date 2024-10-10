// Mengirim Ajax
$.ajaxSetup({
	headers : {
		'csrf-token': $('meta[name="csrf-token"]').attr('content')
	}
});