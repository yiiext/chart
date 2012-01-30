<?php
require_once 'BaseChart.php';
/**
 * Pie chart widget
 *
 * @author Dmytro Zasyadko
 * @version 1.0
 */
class PieChart extends BaseChart
{

	/**
	 * @var array Chart data. Valid format is the following:
	 *
	 * array(
	 *	   array('legend'=>'Param1', 'value'=>10, 'href'=>'http://google.com'),
	 *	   array('legend'=>'Param2', 'value'=>20, 'href'=>''),
	 *	   array('legend'=>'Param3', 'value'=>30, 'href'=>null),
	 *	   array('legend'=>'Param4', 'value'=>40, 'href'=>null),
	 * )
	 */
	public $data;

	/**
	 * @var string Legend position. Can be 'east', 'west', 'north' or 'south'.
	 * Default is 'west'.
	 */
	public $legendPosition='west';

	/**
	 * @var array Default chart configuration.
	 */
	protected $_defaultOptions=array(
		'centerTop'=>100,
		'centerLeft'=>100,
		'radius'=>100
	);

	/**
	 * Initializes the widget.
	 * This method is called by {@link CBaseController::createWidget}
	 * and {@link CBaseController::beginWidget} after the widget's
	 * properties have been initialized.
	 */
	public function init()
	{
		parent::init();
		usort($this->data,array($this,"compare"));
		$this->_defaultHtmlOptions=array(
			'id'=>$this->getId(),
		);
	}

	/**
	 * Creates initial script for the chart
	 * @return string
	 */
	protected function createInitScript()
	{
		parent::createInitScript();

		$chartData=$this->getChartData();

		$initScript="var r = Raphael('" . $this->getId() . "');";
		if(is_array($this->label) && isset($this->label['text']))
		{
			$initScript.="charts.drawLabel(r, " . CJavaScript::encode($this->label['left']) . ", " . CJavaScript::encode($this->label['top']) . ", " . CJavaScript::encode($this->label['text']) . ", " . CJavaScript::encode($this->label['font']) . ");";
		}
		$initScript.="var chart = r.piechart({$this->options['centerLeft']}, {$this->options['centerTop']}, {$this->options['radius']}," . CJavaScript::encode($chartData['values']) . ", { legend: " . CJavaScript::encode($chartData['legends']) . ", legendpos: '$this->legendPosition', href: " . CJavaScript::encode($chartData['hrefs']) . "});";
		$initScript.="chart.hover(charts.pieOver, charts.pieOut);";
                $initScript.=$this->getHandlersInit();
		return $initScript;
	}

	/**
	 * Publishes and registers all necessary script files.
	 */
	protected function registerScripts()
	{
		parent::registerScripts();
		$basePath=dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
		$baseUrl=Yii::app()->getAssetManager()->publish($basePath,false,1,YII_DEBUG);
		Yii::app()->clientScript->registerScriptFile($baseUrl . '/g.pie-min.js');
	}

	/**
	 * Transforms data passed to the widget to the format required by pie chart
	 * @return array chart data
	 */
	private function getChartData()
	{
		$result=array('legends'=>array(),'values'=>array(),'hrefs'=>array());
		foreach($this->data as $dataRow)
		{
			$result['legends'][]=$dataRow['legend'];
			$result['values'][]=$dataRow['value'];
			$result['hrefs'][]=$dataRow['href'];
		}
		return $result;
	}

	/**
	 * Used by usort for sorting data arrays by value
	 * @static
	 *
	 * @param $a array data 1
	 * @param $b array data 2
	 *
	 * @return int -1 if data 1 < data 2, 0 if data 1 == data 2, 1 if data 1 > data 2
	 */
	static private function compare($a,$b)
	{
		if($a['value']==$b['value'])
		{
			return 0;
		}
		return ($a['value']>$b['value']) ? -1 : 1;
	}
}
