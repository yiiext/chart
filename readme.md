Chart
=====

This extension provides a set of charting widgets based
on [gRaphaël](http://g.raphaeljs.com/).

Installing and configuring
--------------------------

Extract files to your application extension directory.

Using Pie Chart
---------------

You can use the folowing code in order to use this type of widget:

~~~
$this->widget('ext.chart.PieChart', array(
	'data'=>$data, //Chart data
	'legendPosition'=>'west', // Legend block position. Can be 'east', 'west', 'north' or 'south'. Default is 'west'.
	// Settings for the pie chart
	'options'=>array(
		'centerTop'=>130, // Distance from widget's left side to the center of pie chart
		'centerLeft'=>130, // Distance from widget's top side to the center of pie chart
		'radius'=>100 // Radius of the chart
	),
	// Set of JavaScript event handlers for the chart. Array indexes have to be a valid event name.
	// Value can be either a string with callback function or array of strings of the same content.
	'eventHandlers'=>array(
		'click'=>'function(){alert($(this).attr("id"));}',
		'hover'=>array(
			'function(){alert("In!");}',
			'function(){alert("Out!");}'
		),
	),
	// Settings for chart label. Params 'left' and 'top' could be 'auto'.
	// In this case label would be centered in corresponding direction
	'label'=>array(
		'left'=>'auto', // Distance from the widget's left side to the middle of the label text
		'top'=>10,// Distance from the widget's top side to the middle of the label text
		'text'=>'Simple Pie Chart', // Label text
		'font'=>'10px sans-serif', // Label font settings, default is '12px sans-serif'
	),
	// HTML options for the widget container
	'htmlOptions'=>array(
		'style'=>'width: 300px; height:240px;'
	),
));
~~~

Data for this type of widget have to be in following format:

~~~
array(
	array(
		'legend'=>'Param1', // Legend for the current item
		'value'=>10, // Item's value
		'href'=>'http://google.com', // Link assigned to the current item
	),
	...
);
~~~


Using Bar Chart
---------------

You can use the folowing code in order to use this type of widget:

~~~
$this->widget('ext.chart.BarChart', array(
	'data'=>$data, // Chart data
	'stacked'=>true, // If chart bars should be stacked. Default is false.
	'barType'=>'soft', // Type of chart bars. Can be 'soft', 'round', 'sharp' or 'square'. Default is 'soft'.
	'chartType'=>'horizontal', // Type of the chart. Can be either 'vertical' or 'horizontal'. Default is 'vertical'.
	//Settings for the chart's label. Params are 'left' and 'top'. Could be 'auto'.
	// In this case label would be centered in corresponding direction.
	'label'=>array(
		'left'=>'auto', // Distance from the widget's left side to the middle of the label text.
		'top'=>10, // Distance from the widget's top side to the middle of the label text.
		'text'=>'Sinmple Pie Chart', // Label text
		'font'=>'10px sans-serif', // Label font settings, default is '12px sans-serif'
	),
	// Settings for bar chart
	'options'=>array(
		'top'=>10, // Distance from the widget's left side to the left side of the bar chart.
		'left'=>10, // Distance from the widget's top side to the top side of the bar chart.
		'width'=>300, // Width of the bar chart
		'height'=>220, // Height of the bar chart
	),
	// Set of the JavaScript event handlers for the chart. Array indexe has to be a valid event name.
	// Value can be either a string or an array. String is for event that needs one callback function.
	// array is for event that needs multiple handlers.
	'eventHandlers'=>array(
		'click'=>'function(){alert($(this).attr("id"));}',
		'hover'=>array(
			'function(){alert("In!");}',
			'function(){alert("Out!");}'
		),
	),
	// HTML options for the widget container
	'htmlOptions'=>array(
		'style'=>'width: 300px; height:240px;'
	),
));
~~~

Data for this type of widget have to be in following format:

~~~
array(
	array(10, 20, 30),
	array(30, 20, 50),
	array(20, 80, 10),
	array(15, 25, 35),
)
~~~

Each subarray is a set of values for one chart item and can contain any number of items.

Credits
-------

This extension is brought to you by [CleverTech](http://clevertech.biz/).