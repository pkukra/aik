<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aktivitas_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_aktivitas_by_user($id_user, $id_kegiatan)
{
    $today = date('j');

    // bulan sekarang
    $start_now = date('Y-m-01 00:00:00');
    $end_now   = date('Y-m-t 23:59:59');

    // bulan lalu
    $start_last = date('Y-m-01 00:00:00', strtotime('-1 month'));
    $end_last   = date('Y-m-t 23:59:59', strtotime('-1 month'));

    $this->db
        ->select('aktivitas.*, kegiatan.nama_kegiatan, kegiatan.icon, subkegiatan.*')
        ->from('aktivitas')
        ->join('kegiatan', 'kegiatan.id_kegiatan = aktivitas.id_kegiatan', 'left')
        ->join('subkegiatan', 'subkegiatan.id_sub = aktivitas.id_sub', 'left')
        ->where('aktivitas.id_user', $id_user)
        ->where('aktivitas.id_kegiatan', $id_kegiatan);

    // Jika tanggal 1–3
    if ($today <= 3) {

        $this->db->group_start()
            ->where("aktivitas.waktu_aktivitas BETWEEN '$start_now' AND '$end_now'")
            ->or_where("aktivitas.waktu_aktivitas BETWEEN '$start_last' AND '$end_last'")
        ->group_end();

    } else {

        $this->db->where("aktivitas.waktu_aktivitas BETWEEN '$start_now' AND '$end_now'");

    }

    return $this->db
        ->order_by('aktivitas.waktu_aktivitas', 'DESC')
        ->get()
        ->result();
}


    public function get_icon() {
        return $this->db->order_by('id_icon', 'asc')->get('fa_icon')->result();
    }
    public function get_by_id($id) {
        return $this->db->get_where('aktivitas', ['id_aktivitas' => $id])->row();
    }

    public function insert($data) {
        return $this->db->insert('aktivitas', $data);
    }

    public function update($id, $data) {
        return $this->db->where('id_aktivitas', $id)->update('aktivitas', $data);
    }

    public function delete($id) {
        return $this->db->where('id_aktivitas', $id)->delete('aktivitas');
    }
    public function log_delete($data)
    {
        return $this->db->insert('log_delete_aktivitas', $data);
    }
    
    public function count_aktivitas($id_kegiatan, $id_user)
    {
        $bulan = date('m');  
        $tahun = date('Y');   
        return $this->db
            ->where('id_kegiatan', $id_kegiatan)
            ->where('id_user', $id_user)
            ->where('MONTH(waktu_aktivitas)', $bulan)
            ->where('YEAR(waktu_aktivitas)', $tahun)
            ->count_all_results('aktivitas');
    }
    
    public function count_aktivitas_5_tahun_terakhir($id_user)
    {
        $tahun_akhir = date('Y');
        $tahun_awal  = $tahun_akhir - 4; // total 5 tahun termasuk tahun ini

        $awal  = $tahun_awal . '-01-01 00:00:00';
        $akhir = $tahun_akhir . '-12-31 23:59:59';

        return $this->db
            ->select('YEAR(aktivitas.waktu_aktivitas) AS tahun, SUM(kegiatan.poin) AS total_poin')
            ->from('aktivitas')
            ->join('kegiatan', 'kegiatan.id_kegiatan = aktivitas.id_kegiatan')
            ->where('aktivitas.id_user', $id_user)
            ->where('aktivitas.waktu_aktivitas >=', $awal)
            ->where('aktivitas.waktu_aktivitas <=', $akhir)
            ->group_by('YEAR(aktivitas.waktu_aktivitas)')
            ->order_by('tahun', 'ASC')
            ->get()
            ->result();
    }

    public function count_aktivitas_user($id_user,$bulan,$tahun)
    { 
        return $this->db
            ->select('*')
            ->from('aktivitas')
            ->join('kegiatan', 'kegiatan.id_kegiatan = aktivitas.id_kegiatan', 'left')
            ->where('id_user', $id_user)
            ->where('MONTH(waktu_aktivitas)', $bulan)
            ->where('YEAR(waktu_aktivitas)', $tahun)
            ->get()
            ->result();
    }

    public function aktivitas_user_bybulantahun($id_user, $blntahun)
    {
        $awal  = date('Y-m-01 00:00:00', strtotime('01-' . $blntahun));
        $akhir = date('Y-m-t 23:59:59', strtotime('01-' . $blntahun));

        return $this->db
            ->select('aktivitas.waktu_aktivitas')
            ->from('aktivitas')
            ->join('kegiatan', 'kegiatan.id_kegiatan = aktivitas.id_kegiatan')
            ->where('aktivitas.id_user', $id_user)
            ->where('aktivitas.waktu_aktivitas >=', $awal)
            ->where('aktivitas.waktu_aktivitas <=', $akhir)
            ->group_by('DATE(aktivitas.waktu_aktivitas)')
            ->order_by('aktivitas.waktu_aktivitas', 'DESC')
            ->get()
            ->result();
    }


    public function count_aktivitas_12_bulan($id_user, $bulan_awal, $bulan_akhir)
    {
        return $this->db
            ->select("DATE_FORMAT(waktu_aktivitas,'%Y-%m') AS bulan, SUM(poin) AS total_poin")
            ->from('aktivitas')
            ->join('kegiatan', 'kegiatan.id_kegiatan = aktivitas.id_kegiatan')
            ->where('aktivitas.id_user', $id_user)
            ->where("DATE_FORMAT(waktu_aktivitas,'%Y-%m') >=", $bulan_awal)
            ->where("DATE_FORMAT(waktu_aktivitas,'%Y-%m') <=", $bulan_akhir)
            ->group_by("DATE_FORMAT(waktu_aktivitas,'%Y-%m')")
            ->order_by("bulan", "ASC")
            ->get()
            ->result();
    }


    public function get_by_date($id_user,$day) {
        $awal  = $day . ' 00:00:00';
        $akhir = $day . ' 23:59:59';


        return $this->db
            ->select('*')
            ->from('aktivitas')
            ->join('kegiatan', 'kegiatan.id_kegiatan = aktivitas.id_kegiatan')
            ->join('subkegiatan', 'subkegiatan.id_sub = aktivitas.id_sub','left')
            ->where('aktivitas.id_user', $id_user)
            ->where('aktivitas.waktu_aktivitas >=', $awal)
            ->where('aktivitas.waktu_aktivitas <=', $akhir)
            ->order_by('aktivitas.waktu_aktivitas', 'ASC')
            ->get()
            ->result();
    }

    public function cek_aktivitas($d,$tanggal) {
        return $this->db
            ->select('id_aktivitas')
            ->from('aktivitas')
            ->where('id_kegiatan', $d['id_kegiatan'])
            ->where('id_sub', $d['id_sub'])
            ->like('waktu_aktivitas', $tanggal)
            ->where('id_user', $d['id_user'])
            ->limit(1)
            ->get()
            ->row();
    }
    
}
