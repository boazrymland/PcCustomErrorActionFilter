<?php
/**
 * class PcCustomErrorActionFilter
 */
class PcCustomErrorActionFilter extends CFilter {
	/**
	 * @var string
	 * The route for the method that should be run on errors - this is your "precious one", mate.
	 */
	public $errorActionRoute = "";

	/**
	 * @var string
	 */
	private $_originalActionError;

	protected function preFilter($filterChain) {
		// did the developer remember to set the method name? NO??? Bad boy!
		if (empty($this->errorActionRoute)) {
			throw new CException(__CLASS__ . " is used but \$actionMethodName was not set!");
		}

		// save first the original actionError attribute
		$this->_originalActionError = Yii::app()->errorHandler->errorAction;

		// tell yii about the new error action
		Yii::app()->errorHandler->errorAction = $this->errorActionRoute;

		return true;
	}

	/**
	 * After filter has run return errorHandler to be the original one
	 * @param CFilterChain $filterChain
	 */
	protected function postFilter($filterChain) {
		// restore the original actionError attribute.
		Yii::app()->errorHandler->errorAction = $this->_originalActionError;
	}
}
