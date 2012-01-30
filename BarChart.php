<?php
require_once 'BaseChart.php';
/**
 * Bar chart widget
 *
 * @author Dmytro Zasyadko
 * @version 1.0
 */
class BarChart extends BaseChart
{

	/**
	 * @var array Chart data. Valid format is the following:
	 * array(
	 *	   array(10,20,30),
	 *	   array(30, 20, 50),
	 *	   array(20, 80, 10),
	 *	   array(15, 25, 35),
	 * )
	 */
	public $data;

	/**
	 * @var string Type of the chart. Can be either 'vertical' or 'horizontal'. Default is
	 * 'vertical'.
	 */
	public $chartType='vertical';

	/**
	 * @var boolean If chart bars should be stacked. Default is false.
	 */
	public $stacked=false;

	/**
	 * @var string Type of chart bars. Can be 'soft', 'round', 'sharp' or 'square'.
	 * Default is 'soft'.
	 */
	public $barType='soft';

	/**
	 * @var string Gutter width. Default is '20%'.
	 */
	public $gutterWidth='20%';

	/**
	 * @var array Default chart configuration.
	 */
	protected $_defaultOptions=array(
		'top'=>10,
		'left'=>10,
		'width'=>300,
		'height'=>220,
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
		$initScript.="var chart = r." . ($this->chartType=='vertical' ? 'barchart' : 'hbarchart');
		$initScript.="({$this->options['left']}, {$this->options['top']}, {$this->options['width']}, {$this->options['height']}, " . CJavaScript::encode($chartData) . ", {stacked: " . CJavaScript::encode($this->stacked) . ", type: " . CJavaScript::encode($this->barType) . ", gutterWidth:" . CJavaScript::encode($this->gutterWidth) . "});";
		$initScript.="chart.hover(charts.barOver, charts.barOut);";
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
		Yii::app()->clientScript->registerScriptFile($baseUrl . '/g.bar-min.js');
	}

	/**
	 * Transforms data passed to the widget to the format required by bar chart
	 * @return array chart data
	 */
	private function getChartData()
	{
		$result=array();
		foreach($this->data as $rowIndex=>$dataRow)
		{
			foreach($dataRow as $itemIndex=>$dataItem)
			{
				$result[$itemIndex][$rowIndex]=$dataItem;
			}
		}
		return $result;
	}
}
