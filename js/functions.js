var urlFormDialog;
var laSection;

function ajaxShowRequestFormDialog(formData, jqForm, options){
}

function ajaxShowResponseFormDialog(data, statusText){
	$('#dialog').dialog('close');
}

function javascriptError(data, statusText){
	$.jGrowl("Erreur Javascript, veuillez recharger la page.");
	console.log(statusText);
	console.log(data);
}

$(document).ready(function() {

	// $('form').prepend('<input type="hidden" name="ajaxed" value="1" />');
	
	// dialog : formulaire d'ajout/modification d’un élément
	$('body').prepend('<div id="dialog"></div>');
	$('#dialog').dialog({
		title:'Ajouter ou modifier un élément',
		width:500,
		height:515,
		// hide: 'slide',
		modal: true,
		autoOpen: false,
		close: function(event, ui) {
			//reloadSection('Pages');
		},
		open: function(event, ui){
			$(this).load(urlFormDialog, function(){
				if(laSection != "Pages"){
					$(this).children('form').wrap('<div id="'+laSection+'"></div>');
					initialize(laSection);
				}
				$(this).children('form')
				.prepend('<input type="hidden" name="ajaxed" value="1" />')
				.ajaxForm({
					clearForm: true,
					beforeSubmit: ajaxShowRequestFormDialog,
					success: ajaxShowResponseFormDialog,
					error: javascriptError
				});
			});
		}
	});
	
	$('#boutonAjouterFactureSortante').live('click',function(){
		laSection = "Pages";
		urlFormDialog = "formFacturesSortantes.php?ajaxed=1";
		$('#dialog').data('title.dialog', 'Ajouter une facture Sortante'); 
		$('#dialog').dialog('open');
		return false;
	});

	$('#boutonAjouterFactureEntrante').live('click',function(){
		laSection = "Pages";
		urlFormDialog = "formFacturesEntrantes.php?ajaxed=1";
		$('#dialog').data('title.dialog', 'Ajouter une facture Entrante'); 
		$('#dialog').dialog('open');
		return false;
	});
	
	$('.boutonModifier').live('click',function(){
		laSection = "Pages";
		urlFormDialog = $(this).attr('href')+"&ajaxed=1";
		$('#dialog').data('title.dialog', 'Modifier la facture'); 
		$('#dialog').dialog('open');
		return false;
	});

});
