<?php
include ('classes/interface.class.php');
$myInterface = new interface_();
$myInterface->set_title("Facturier – Graphique");
$myInterface->get_header();
include ('include/onglets.php');
?>
<link type="text/css" rel="stylesheet" href="/plugins/rickshaw/rickshaw.min.css">
<style>
#container {
	margin-top: 166px;
}
#chart_container {
	padding-right:50px;
    position: relative;
}
#chart {
    margin-left: 40px;
}
#y_axis {
    position: absolute;
    top: 0;
    bottom: 0;
    width: 40px;
}
#legend {
	position: absolute;
	top: 230px;
	left: 60px;
}
</style>
<script src="/plugins/rickshaw/vendor/d3.min.js"></script>
<script src="/plugins/rickshaw/vendor/d3.layout.min.js"></script>
<script src="/plugins/rickshaw/rickshaw.min.js"></script>

<div id="container">
	<div id="chart_container">
	        <div id="y_axis"></div>
	        <div id="chart"></div>
	</div>
	<div id="legend"></div>
</div>
<script>
var graph;
$.getJSON('graphDatas.php', function(data){
	console.log(data);
	// data = data.responseText;
	graph = new Rickshaw.Graph( {
		element: document.getElementById("chart"),
		renderer: 'bar',
		height: 500,
	    series: [{
			name: "Sorties",
            color: "rgb(200,120,50)",
            data: data[0]
	    },{
			name: "Entrées",
            color: "rgb(230,180,30)",
            data: data[1]
	    }]
	});
	var x_axis = new Rickshaw.Graph.Axis.Time( { graph: graph } );

	var y_axis = new Rickshaw.Graph.Axis.Y( {
	        graph: graph,
	        orientation: 'left',
	        tickFormat: Rickshaw.Fixtures.Number.formatKMBT,
	        element: document.getElementById('y_axis'),
	});
	var legend = new Rickshaw.Graph.Legend( {
	        element: document.querySelector('#legend'),
	        graph: graph
	});
	
	graph.render();
	
});
// instantiate our graph!


</script>
<?php
$myInterface->get_footer();
?>