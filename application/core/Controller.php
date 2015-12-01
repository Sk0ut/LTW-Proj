<?php

class Controller
{
	protected function model($model, $args = [])
	{
		if (file_exists("../application/models/" . $model . ".php"))
		{
			require_once "../application/models/" . $model . ".php";
		}
		
		return (new ReflectionClass($model))->newInstanceArgs($args);
	}
	
	protected function view($view, $data = [])
	{
		if (file_exists("../application/views/" + $view . ".php"))
		{
			require_once "../application/views/" + $view . ".php";
		}
	}
}