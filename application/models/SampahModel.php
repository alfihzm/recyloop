<?php

class SampahModel extends CI_Model
{
    public function getSampah()
    {
        $query = $this->db->get('sampah');
        return $query->result_array();
    }

    public function tambahSampah($data)
    {
        return $this->db->insert('sampah', $data);
    }

    public function editSampah($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('sampah', $data);
    }

    public function getSampahById($id)
    {
        $query = $this->db->get_where('sampah', ['id' => $id]);
        return $query->row_array();
    }
}