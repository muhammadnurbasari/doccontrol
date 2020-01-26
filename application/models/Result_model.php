<?php 

/**
 * 
 */
class Result_model extends CI_model
{
	function getData($table, $id='')
	{
		if ($id != '') {
			return $this->db->get_where($table, [$table.'_id' => $id])->row();
		} else {
			$this->db->order_by($table.'_id', 'DESC');
			return $this->db->get($table)->result_array();
		}
	}

	function get_by_name($table, $select, $select_value)
	{
		return $this->db->get_where($table, [$select => $select_value])->result_array();
	}

	function update_by_id($table, $id, $data)
	{
		$this->db->where($table.'_id', $id);
		return $this->db->update($table, $data);
	}

	function get_name_by_id($table, $id, $name)
	{
		$this->db->select($name);
		$this->db->where($table.'_id', $id);
		return $this->db->get($table)->row()->$name;
	}

	function get_max_by_id($table)
	{
		$this->db->select_max($table.'_id', 'id');
		return $this->db->get($table)->row()->id;
	}
}