<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	protected function post_to_array($array){
		$data = array();
		foreach ($array as $value) {
			$data[$value] = Input::get($value);
		}
		return $data;
	}

}
