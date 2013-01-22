<?php

class Vote extends Eloquent {

	public static $timestamps = false;

	public static function IsVoteExist($voter_id, $user_id, $type) {
		return (static::where_voter_id_and_user_id_and_type($voter_id, $user_id, $type)
			->count() > 0);
	}
	public static function get_average_value($user_id, $type) {
		return static::where_user_id_and_type($user_id, $type)->avg('value');
	}

	public static function get_average_value_all($user_id) {
		return static::where_user_id($user_id)->avg('value');
	}

	public static function get_vote_count($user_id, $type) {
		return static::where_user_id_and_type($user_id, $type)->count();
	}
}