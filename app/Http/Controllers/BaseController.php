<?php

class BaseController extends Controller
{
    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if (! is_null($this->layout)) {
            $this->layout = ($this->layout);
        }
    }

    protected function post_to_array($array)
    {
        $data = [];
        foreach ($array as $value) {
            $data[$value] = \Illuminate\Support\Facades\Request::get($value);
        }

        return $data;
    }
}
