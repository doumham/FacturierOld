togglePaid=function(numero,id,annee,ordre,paid){
	new Ajax.Request('requetes/toggle_paid.php?id='+id+'&annee='+annee+'&ordre='+ordre+'&paid='+paid,{
		onComplete: function() {
			if(paid==0){
				$('element_'+id).style.backgroundImage="url(images/fond_li.png)";
				$('paid_'+id).setAttribute('onclick',"togglePaid('"+numero+"','"+id+"','"+annee+"','"+ordre+"',1);return false;");
				$('paid_'+id).setAttribute('title',"Marquer comme impayée");
				$('icn_del_'+id).setAttribute('src',"images/icn-delete-off.png");
				$('del_paid_'+id).setAttribute('onclick',"effacer("+numero+","+id+",1);return false;");
			}else{
				$('element_'+id).style.backgroundImage="url(images/fond_li_unpaid.png)";
				$('paid_'+id).setAttribute('onclick',"togglePaid('"+numero+"','"+id+"','"+annee+"','"+ordre+"',0);return false;");
				$('paid_'+id).setAttribute('title',"Marquer comme payée");
				$('icn_del_'+id).setAttribute('src',"images/icn-delete.png");
				$('del_paid_'+id).setAttribute('onclick',"effacer("+numero+","+id+",0);return false;");
			}
		}
	});
}
effacer = function (nom, element, paid){
	if (paid==1) {
		window.alert('Impossible de supprimer une facture payée.');
	}else{
		if (window.confirm('Supprimer la facture n°'+nom+' ?')){
			window.location="requetes/delete_facture.php?id="+element;
		}else{
			return false;
		}
	}
}
effacer_depense = function (element){
	if (window.confirm('Supprimer cette facture ?')){
		window.location="requetes/delete_depense.php?id="+element;
	}else{
		return false;
	}
}
effacer_client = function (nom, element){
	if (window.confirm('Delete '+nom+' ?')){
		new Effect.Fade('element_'+element,{
			duration:.3
		});
		new Ajax.Request('requetes/delete_client.php?id='+element,{
			onFailure: function() {
				location.reload(true);
			}
		});
	}else{
		return false;
	}
}
