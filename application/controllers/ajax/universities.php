
<?php

class Ajax_Universities_Controller extends Base_Controller {

	public $restful = true;

	public function get_index()
    {

    }

    public function get_faculties_index($id) {
		if($id == 'none') {
			return json_encode(array('err' => true));
		}

		$f = University::find($id)->faculties;
		return eloquent_to_json($f);
    }

	public function post_index()
    {

    }

	public function get_show()
    {

    }

	public function get_edit()
    {

    }

	public function get_new()
    {

    }

	public function put_update()
    {

    }

	public function delete_destroy()
    {

    }

}