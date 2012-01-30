<?php
/**
 * Base for all chart widgets.
 *
 * @author Dmytro Zasyadko
 * @version 1.0
 */
class BaseChart extends CWidget
{
	/**
	 * @var array Main chart configuration (it's different for different charts).
	 */
	public $options=array();

	/**
	 * @var array Set of JavaScript event handlers for chart
	 */
	public $eventHandlers=array();

	/**
	 * @var array Additional HTML options to be rendered in the input tag.
	 */
	public $htmlOptions=array();

	/**
	 * @var array Labels config for chart.
	 *
	 * Correct format is:
	 *
	 * array(
	 *	   'left'=>160,
	 *	   'top'=>10,
	 *	   'text'=>'Simple Pie Chart',
	 *	   'font'=>'12px sans-serif',
	 * )
	 *
	 * 'left' and 'top' attributes could be 'auto'.
	 */
	public $label=array();

	/**
	 * Initializes the widget.
	 * This method is called by {@link CBaseController::createWidget}
	 * and {@link CBaseController::beginWidget} after the widget's
	 * properties have been initialized.
	 */
	public function init()
	{
		parent::init();
		$this->registerScripts();
		$this->label=array_merge(array(
			'left'=>'auto',
			'top'=>'auto',
			'font'=>'12px sans-serif',
		),$this->label);
	}

	/**
	 * @var array Default HTML options to be rendered in the input tag.
	 */
	protected $_defaultHtmlOptions=array();

	/**
	 * @var array Default chart configuration.
	 */
	protected $_defaultOptions=array();

	/**
	 * Renders the widget.
	 */
	public function run()
	{
		$this->htmlOptions=CMap::mergeArray($this->_defaultHtmlOptions,$this->htmlOptions);
		$this->options=CMap::mergeArray($this->_defaultOptions,$this->options);
		echo CHtml::openTag('div',$this->htmlOptions);
		echo CHtml::closeTag('div');

		Yii::app()->clientScript->registerScript(__CLASS__.'#'.$this->getId(),$this->createInitScript());
	}

	/**
	 * Publishes and registers all necessary script files.
	 */
	protected function registerScripts()
	{
		$basePath=dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
		$baseUrl=Yii::app()->getAssetManager()->publish($basePath,false,1,YII_DEBUG);

		$cs=Yii::app()->clientScript;
		$cs->registerCoreScript('jquery');
		$cs->registerScriptFile($baseUrl.'/raphael-min.js');
		$cs->registerScriptFile($baseUrl.'/g.raphael-min.js');
		$cs->registerScriptFile($baseUrl.'/charts.js');
	}

	/**
	 * Base function for creating initial JavaScript.
	 * @return string
	 */
	protected function createInitScript()
	{
	}

	/**
	 * Create and return string of JavaScript code for binding events to chart
	 *
	 * @param string $chartVarName Name of JavaScript variable that contain link to the chart. Default is 'chart'.
	 * @return string
	 */
	protected function getHandlersInit($chartVarName='chart')
	{
		$result=null;
		if(count($this->eventHandlers)>0)
		{
			$result=$chartVarName;
			foreach($this->eventHandlers as $handlerName=>$handlerFunction)
			{
				$result.='.' . $handlerName . '(' . (is_array($handlerFunction) ? implode(',',$handlerFunction) : $handlerFunction) . ')';
			}
			$result.=';';
		}
		return $result;
	}
}