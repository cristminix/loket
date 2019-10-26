<?php

class M_setting_loket extends CI_Model{
	public function get_loket_id($jp_id)
	{
		$row = $this->db->where(['jp_id'=>$jp_id])
						->order_by('id','desc')
						->select('loket_id')
						->get('m_setting_loket');
		if($row->num_rows() > 0){
			return $row->row()->$loket_id;
		}
		return 0;
	}
}