<?php

class Basemodel extends Eloquent
{
	public static function validate($input) {
		return Validator::make($input, static::$rules);
	}
}