<?php // content="text/plain; charset=utf-8"
require_once ('jpgraph/jpgraph/src/jpgraph.php');
require_once ('jpgraph/jpgraph/src/jpgraph_bar.php');


//$datay=array($_GET["1"],$_GET["2"],$_GET["3"],$_GET["4"],$_GET["5"],$_GET["6"]);
$datay=[];
/*for($i=1;$i<=count($_GET);$i++)
{
	$var = $i+"";
	array_push($datay, $_GET[$var]);
}*/
$datax = [];
foreach ($_GET as $key => $value)
{
	array_push($datay,$value);
	array_push($datax,$key);
}
//array_push($datay,20,25);
//echo("somehtoing");
// Create the graph. These two calls are always required
$graph = new Graph(800,600);
$graph->SetScale('intlin');
 
// Add a drop shadow
$graph->SetShadow();

// Adjust the margin a bit to make more room for titles
$graph->SetMargin(40,30,20,40);
 
// Create a bar pot
$bplot = new BarPlot($datay);
$graph->xaxis->SetTickLabels($datax);
// Adjust fill color
$bplot->SetFillColor('orange');
$graph->Add($bplot);
 
// Setup the titles
$graph->title->Set('A basic bar graph');
$graph->xaxis->title->Set('User Id');
$graph->yaxis->title->Set('Number of Issues');
 
$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
 
// Display the graph
$graph->Stroke();
?>