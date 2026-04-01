<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Galery_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function count_aktivitas_user($idUser = 0)
    {
        $this->db->from('aktivitas');
        $this->db->where('filename IS NOT NULL', null, false);

        if ($idUser > 0) {
            $this->db->where('id_user', $idUser);
        }

        return $this->db->count_all_results();
    }

    public function get_photos($perPage, $start, $idUser = 0)
    {
        $this->db->select("
            A.id_aktivitas AS id,
            B.nama AS title,
            A.nama_aktivitas,
            A.keterangan AS description,
            CONCAT('http://10.10.10.223/mobileapp/uploads/', A.filename) AS filename,
            A.waktu_aktivitas,
            C.nama_kegiatan,
            D.nama_subkegiatan,
            E.nama_unit
        ", false);

        $this->db->from('aktivitas A');
        $this->db->join('users B', 'A.id_user = B.id', 'left');
        $this->db->join('kegiatan C', 'A.id_kegiatan = C.id_kegiatan', 'left');
        $this->db->join('subkegiatan D', 'A.id_sub = D.id_sub', 'left');
        $this->db->join('units E', 'B.id_unit = E.id', 'left');

        $this->db->where('A.filename IS NOT NULL', null, false);

        if ($idUser > 0) {
            $this->db->where('A.id_user', $idUser);
        }

        $this->db->order_by('A.created_at', 'DESC');
        $this->db->order_by('A.id_aktivitas', 'DESC');
        $this->db->limit($perPage, $start);

        return $this->db->get()->result_array();
    }
}
