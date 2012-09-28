<?php
/**
 * class PcCustomErrorActionFilter
 *
 * @license:
 * Copyright (c) 2012, Boaz Rymland
 * All rights reserved.
 * Redistribution and use in source and binary forms, with or without modification, are permitted provided that the
 * following conditions are met:
 * - Redistributions of source code must retain the above copyright notice, this list of conditions and the following
 *      disclaimer.
 * - Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following
 *      disclaimer in the documentation and/or other materials provided with the distribution.
 * - The names of the contributors may not be used to endorse or promote products derived from this software without
 *      specific prior written permission.
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 * EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
 * HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR
 * TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
 * EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
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
