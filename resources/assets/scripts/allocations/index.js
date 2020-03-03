$(document).ready(function () {
	if ( $('.show-allocation').length ) {
		$('.destroy-allocation').click(clickOnDestroyAllocation);
	}
});

function clickOnDestroyAllocation() {
	var self = $(this);
	$('#destroy-allocation-form').attr('action', self.attr('id'));
	$('#destroy-allocation').modal('toggle');
}

function printAllocation() 
{
	window.print('printAllocations');
}

$(".export-calendar").on('click', function() {
	iziToast.show({
		id: 'haduken',
		message: "Aguardando sincronização!",
		position: 'bottomRight',
		transitionIn: 'flipInX',
		transitionOut: 'flipOutX',
		progressBarColor: 'linear-gradient(to bottom, #24A830 0%, #fff 150%)',
		layout: 2,
		maxWidth: 500,
		timeout: 9990
	});
	$.ajax( "allocations/gcalendar" )
	.done(function(data) {
		iziToast.show({
			id: 'haduken',
			message: "Sincronização concluída com sucesso :D",
			position: 'bottomRight',
			transitionIn: 'flipInX',
			transitionOut: 'flipOutX',
			progressBarColor: 'linear-gradient(to bottom, #24A830 0%, #fff 150%)',
			layout: 2,
			maxWidth: 500,
			timeout: 9990
		});
	})
	.fail(function(data) {
		
		window.open(data.responseJSON.authUrl, "_self");
	});
});