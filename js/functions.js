$(document).ready(function() {

	var dialogFormUrl;
	var type;
	var annee;
	var ordre;
	var elementsATraiter;

	$.jGrowl.defaults.closer = false;

	function initialize(section){
		initForms(section);
	}

	function reloadSection(section){
		if ($('#'+section).length) {
		$('#'+section).load('listing.php?type='+type+'&ordre='+ordre+'&annee='+annee+'&ajaxed=1',function(){
				initialize(section);
			});
		};
	}

	function initForms(section){
		if ($('#'+section).length) {
			$('#'+section+' form')
			.prepend('<input type="hidden" name="ajaxed" value="1" />')
			.ajaxForm({
				// resetForm: true,
				// sectionName: section,
				dataType: "json",
				beforeSubmit: ajaxShowRequest,
				success: ajaxShowResponse,
				error: javascriptError
			});
		};
	}

	function ajaxShowRequest(formData, jqForm, options){
		elementsATraiter = $('input[type="checkbox"]:checked').parent();
		var nombreElementsSelectionnes = elementsATraiter.size();
		if (nombreElementsSelectionnes > 0) {
			if (nombreElementsSelectionnes == 1) {
				var confirmation = confirm("Voulez-vous supprimer "+nombreElementsSelectionnes+" élément ?");
			}else{
				var confirmation = confirm("Voulez-vous supprimer "+nombreElementsSelectionnes+" éléments ?");
			}
			if (confirmation) {
				$('#'+options.sectionName+' input[type="submit"],input[type="button"]').attr('disabled','disabled');
				$('#'+options.sectionName+' input[type="submit"]').parent().append('<img id="signalLoading" style="position:absolute;margin:3px 0 0 5px;" src="../images_admin/icn-loading.gif" />');
			} else {
				return false;
			}
		} else {
			$.jGrowl('Aucun élément sélectionné.');
			return false;
		}
	}

	function ajaxShowResponse(data, statusText){
		reloadSection("Liste");
		$.jGrowl(data.msg);
	}

	function ajaxShowRequestFormDialog(formData, jqForm, options){
	}

	function ajaxShowResponseFormDialog(data, statusText){
		// alert('test');
		$.jGrowl(data.msg);
		reloadSection('Liste');
		$('#dialog').dialog('close');
	}

	function javascriptError(data, statusText){
		$.jGrowl("Erreur, veuillez recharger la page.");
		console.log(statusText);
		console.log(data);
	}


	function isTagSupported(tag){
		eltTag = document.getElementsByTagName(tag)[0];
	//	alert(tag+" :\n\n"+eltTag);	// Débug.
		if (eltTag == "[object HTMLUnknownElement]" || eltTag == null){
			return false;
		} else {
			return true;
		}
	}

	function makeAutocomplete(fieldId, table, champ) {
		if (!isTagSupported('datalist') && $("#"+fieldId).length) {
			$.getJSON('requetes/get_list.php', { table: table, champ: champ }, function(data) {
				$("#"+fieldId).autocomplete({
					source: data,
					minLength: 2
				});
			});
		};
	}
	
	type = $('#type').val();
	annee = $('#annee').val();
	ordre = $('#ordre').val();
	initialize("Liste");

	// $('form').prepend('<input type="hidden" name="ajaxed" value="1" />');
		
	// dialog : formulaire d'ajout/modification d’un élément
	$('body').prepend('<div id="dialog"></div>');
	$('#dialog').dialog({
		resizable: false,
		modal: true,
		autoOpen: false,
		close: function(event, ui) {
			//reloadSection('Liste');
		},
		open: function(event, ui){
			$(this).parent().hide();
			$(this).html("");
			$(this).load(dialogFormUrl, function(){
				$('#totalAmount').click(function(event) {
					$('#amount_paid').val($(this).html()).focus();
				});
				$(this).parent().show();
				if (type == 'sortantes') {
					makeAutocomplete('denomination', 'clients', 'denomination');
				}
				if (type == 'entrantes') {
					makeAutocomplete('objet', 'facturesEntrantes', 'objet');
					makeAutocomplete('denomination', 'facturesEntrantes', 'denomination');
				}
				$('input[autofocus="autofocus"]').focus();
				$('#dialog').dialog('option', 'width', 'auto');
				$('#dialog').dialog('option', 'position', 'center');
				$(this).children('form')
				.prepend('<input type="hidden" name="ajaxed" value="1" />')
				.ajaxForm({
					dataType: "json",
					beforeSubmit: ajaxShowRequestFormDialog,
					success: ajaxShowResponseFormDialog,
					error: javascriptError
				});
			});
		}
	});
	
	$('#boutonAjouterFactureSortante').live('click',function(){
		dialogFormUrl = "formFactures.php?type=sortantes&ajaxed=1";
		dialogTitle = $(this).attr('title');
		$('#dialog').dialog('option', 'title', dialogTitle);
		$('#dialog').dialog('open');
		return false;
	});
		
	$('#boutonAjouterFactureEntrante').live('click',function(){
		dialogFormUrl = "formFactures.php?type=entrantes&ajaxed=1";
		dialogTitle = $(this).attr('title');
		$('#dialog').dialog('option', 'title', dialogTitle);
		$('#dialog').dialog('open');
		return false;
	});
	
	$('#boutonAjouterClient').live('click',function(){
		dialogFormUrl = "formClient.php?ajaxed=1";
		dialogTitle = $(this).attr('title');
		$('#dialog').dialog('option', 'title', dialogTitle);
		$('#dialog').dialog('open');
		return false;
	});

	$('.popup').live('click',function(){
		dialogFormUrl = $(this).attr('href')+"&ajaxed=1";
		dialogTitle = $(this).attr('title');
		$('#dialog').dialog('option', 'title', dialogTitle);
		$('#dialog').dialog('open');
		return false;
	});

});
