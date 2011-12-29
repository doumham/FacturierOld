<?php
if(isset($_GET['annee']) && !empty($_GET['annee'])){
	$annee = $_GET['annee'];
} else {
	$annee="all";
}
include ('classes/interface.class.php');
$myInterface = new interface_();
$myInterface->set_title("Facturier – Graphique");
$myInterface->get_header();
include ('include/onglets.php');
?>
<link type="text/css" rel="stylesheet" href="/plugins/rickshaw/rickshaw.min.css">
<style>
#container { margin-top: 166px; position: relative; }
#chart_container { padding-right:150px; position: relative; }
#chart { margin-left: 40px; }
#y_axis { position: absolute; top: 0; bottom: 0; width: 40px; }
#legend { position: absolute; top: 50px; left: 60px; }

#container2 { margin-top: 166px; position: relative; }
#chart_container2 { padding-right:150px; position: relative; }
#chart2 { margin-left: 40px; }
#y_axis2 { position: absolute; top: 0; bottom: 0; width: 40px; }
#legend2 { position: absolute; top: 50px; left: 60px; }
</style>
<script src="/plugins/rickshaw/vendor/d3.min.js"></script>
<script src="/plugins/rickshaw/vendor/d3.layout.min.js"></script>
<script src="/plugins/rickshaw/rickshaw.min.js"></script>
<script src="/plugins/rickshaw/src/js/Rickshaw.Graph.HoverDetail.js"></script>

<div id="container">
	<div id="chart_container">
	        <div id="y_axis"></div>
	        <div id="chart"></div>
	</div>
	<div id="legend"></div>
</div>
<div id="container2">
	<div id="chart_container2">
	        <div id="y_axis2"></div>
	        <div id="chart2"></div>
	</div>
	<div id="legend2"></div>
</div>
<script>
var graph;
var graph2;
$.getJSON('graphDatas.php', function(data){
	// Premier graphique;
	graph = new Rickshaw.Graph( {
		element: document.getElementById("chart"),
		renderer: 'bar',
		height: 500,
	    series: [{
			name: "Net",
            color: "rgb(200,120,50)",
            data: data[0]
	    },{
			name: "Sorties",
            color: "rgb(230,180,30)",
            data: data[1]
	    }]
	});
	var x_axis = new Rickshaw.Graph.Axis.Time( { graph: graph } );
	var hover_detail = new Rickshaw.Graph.HoverDetail( { graph: graph } );
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

	// Deuxième graphique;
	graph2 = new Rickshaw.Graph( {
		element: document.getElementById("chart2"),
		renderer: 'line',
		height: 500,
	    series: [{
			name: "Entrées",
            color: "rgb(200,120,50)",
            data: data[2]
	    },{
			name: "Sorties",
            color: "rgb(230,180,30)",
            data: data[3]
		}]
	});
	var x_axis = new Rickshaw.Graph.Axis.Time( { graph: graph2 } );
	var hover_detail = new Rickshaw.Graph.HoverDetail( { graph: graph2 } );
	var y_axis = new Rickshaw.Graph.Axis.Y( {
	        graph: graph2,
	        orientation: 'left',
	        tickFormat: Rickshaw.Fixtures.Number.formatKMBT,
	        element: document.getElementById('y_axis2'),
	});
	var legend = new Rickshaw.Graph.Legend( {
	        element: document.querySelector('#legend2'),
	        graph: graph2
	});
	
	graph2.render();
	
});


</script>
<?php
$myInterface->get_footer();
?>