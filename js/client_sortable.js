	// <![CDATA[
	Sortable.create('clients',{
		containment:['clients'],
		ghosting:false,
		tag:'tr',
		constraint:'vertical',
		onUpdate:function(){
			new Ajax.Request('requetes/order_change_clients.php?'+Sortable.serialize('clients'))
		} 
	});
	// ]]>