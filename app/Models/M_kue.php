<?php

namespace App\Models;
use CodeIgniter\Model;


class M_kue extends Model{
  public function tampil_data(){
    return $this->db->get('menu');
    
  }

  public function update_user($id_user, $data) {
        $this->db->where('id_user', $id_user);
        return $this->db->update('user', $data); // Assuming your user table is named 'users'
    }
public function edituser($table, $data, $where)
    {
        return $this->db->table($table)
                        ->where($where)
                        ->update($data);
    }
    
   public function tampil($org)
{
    $query = $this->db->table($org)->get();
    if ($query === false) {
        log_message('error', 'Query failed for table: ' . $org);
        return false; // Or handle the error appropriately
    }
    return $query->getResult();
}

    public function tambah($tabel,$isi){
   return $this->db->table($tabel)
                   ->insert($isi);
}
public function joinWhere($tabel,$tabel2, $on,$where){
   return $this->db->table($tabel , $where)
                   ->join($tabel2, $on,'left')
                   ->get()
                   ->getRow();
}
public function join($tabel,$tabel2, $on){
   return $this->db->table($tabel)
                   ->join($tabel2, $on,'left')
                   // ->orderby($id,'desc')
                   ->get()
                   ->getResult();
                    // return $this->db->query('Select * from brg_msk join barang on brg_msk.id_brg=barang.id_brg')
                    // ->getResult();
}
public function join1($tabel,$tabel2, $on){
   return $this->db->table($tabel)
                   ->join($tabel2, $on,'left')
                   // ->orderby($id,'desc')
                   ->get()
                   ->getResult();
                    // return $this->db->query('Select * from brg_msk join barang on brg_msk.id_brg=barang.id_brg')
                    // ->getResult();
}
    public function edit($tabel,$isi,$where){
   return $this->db->table($tabel)->update($isi,$where);
           
}
public function editkue($table, $data, $where)
    {
        return $this->db->table($table)->update($data, $where);
    }
    public function hapus($tabel,$where){
     return $this->db->table($tabel)
                     ->delete($where);
             
            
}
public function hapuskue($table, $where)
    {
        return $this->db->table($table)->delete($where);
    }
public function hapus1($table, $where)
{
    return $this->db->table($table)->where($where)->delete();
}

//     public function getWhere($tabel, $where) {
//     $result = $this->db->table($tabel)
//                        ->getWhere($where);

//     if ($result === false) {
//         // Handle the error, you can return null, an empty object, or throw an exception
//         return null; // or you can handle it differently
//     }

//     return $result->getRow();
// }
/*public function getWhere($tabel,$where){
    return $this->db->table($tabel)
             ->getWhere($where)
             ->getRow();
             
}*/

public function getWhere($tabel, $where) {
    $result = $this->db->table($tabel)
                       ->getWhere($where);
    
    if ($result !== false) {
        return $result->getRow();
    } else {
        return null;
    }
}

public function getWherecon($table, $conditions)
{
    return $this->db->table($table)->where($conditions)->get()->getResult();
}
             

public function upload1($file)
{
    $targetPath = ROOTPATH . 'public/images/logo.png';
    
    // Hapus file lama jika ada
    if (file_exists($targetPath)) {
        unlink($targetPath);
    }

    // Simpan file baru
    $file->move(ROOTPATH . 'public/images', 'logo.png');
    
    return 'logo.png'; // Mengembalikan nama file baru
}
/*public function tambah1($table, $data) {
    $db = \Config\Database::connect();
    $builder = $db->table($table);
    return $builder->insert($data);
}*/

 public function tambah1($table, $data) {
        return $this->db->table($table)->insert($data);
    }

public function editpw($tabel, $isi, $where){
    return $this->db->table($tabel)
    ->update($isi, $where);
 }
public function upload($photo){
$imageName = $photo->getName();
$photo->move(ROOTPATH.'public/img',$imageName);

}
public function cari($table, $awal, $akhir, $field,){
return $this->db->table($tabel)
                ->join($tabel2,$on,'left')
                ->getWhere($field." between '$awal' and '$akhir'")
                ->getResult();
}
public function joinnelson($tabel, $tabel2, $tabel3,$tabel4, $on, $on2,$on3, $id){
 return $this->db->table($tabel)
 ->join($tabel2, $on,'left')
 ->join($tabel3, $on2,'left')
 ->join($tabel4, $on3,'left')
 ->orderby($id,'desc')
 ->get()
 ->getResult();

}

public function joinhistory($tabel, $tabel2, $tabel3,$tabel4, $on, $on2,$on3, $id,$where){
 return $this->db->table($tabel)
 ->join($tabel2, $on,'left')
 ->join($tabel3, $on2,'left')
 ->join($tabel4, $on3,'left')
 ->orderby($id,'desc')
 ->getWhere($where)
 ->getResult();


}

public function jointigawhere($tabel, $tabel2, $tabel3, $on, $on2, $id, $where) {
    $builder = $this->db->table($tabel)
        ->join($tabel2, $on, 'left')
        ->join($tabel3, $on2, 'left')
        ->orderby($id, 'desc')
        ->getWhere($where);

    if ($builder === false) {
        $error = $this->db->error(); // Get database error
        log_message('error', 'Database error: ' . print_r($error, true));
        return [];
    }

    return $builder->getResult();
}

public function uploadgambar($file, $storeId)
{
    // Generate a unique file name based on store ID and timestamp
    $newFileName = $storeId . '_' . time() . '.' . $file->getClientExtension();
    $targetPath = ROOTPATH . 'public/images/' . $newFileName;

    // Fetch the old file name from the database
    $query = $this->db->table('toko')->select('logo')->where('id_toko', $storeId)->get();
    $oldFile = $query->getRow();

    // Check if a record was found and if the old file exists
    if ($oldFile && isset($oldFile->logo) && file_exists(ROOTPATH . 'public/images/' . $oldFile->logo)) {
        unlink(ROOTPATH . 'public/images/' . $oldFile->logo);
    }

    // Save the new file
    $file->move(ROOTPATH . 'public/images', $newFileName);
    
    return $newFileName; // Return the new file name
}



public function get_all_kue() {
    $this->db->select('id_menu, nama_kue');
    $this->db->from('menu');
    $query = $this->db->get();
    return $query->result();
}



public function editgambar($table, $data, $where)
{
    return $this->db->table($table)->update($data, $where);
}
public function tampilgambar($table)
{
    $query = $this->db->table($table)->get();
    if ($query === false) {
        // Handle the error, e.g., log it, throw an exception, etc.
        return false;
    }
    return $query->getResult(); // Mengambil semua data dari tabel
}


public function getLaporanByDate($start_date, $end_date)
{
    return $this->db->table('transaksi')
    ->where('tgl_transaksi >=', $start_date)
    ->where('tgl_transaksi <=', $end_date)
    ->get()
    ->getResult();
}

public function getLaporanByDateForExcel($start_date, $end_date)
{
    $query = $this->db->table('transaksi')
    ->where('tgl_transaksi >=', $start_date)
    ->where('tgl_transaksi <=', $end_date)
    ->get();

    return $query->getResultArray();
}

public function getTransaksiById($id_transaksi)
{
    return $this->db->table('transaksi')
                    ->join('menu', 'transaksi.id_menu = menu.id_menu')
                    ->join('user', 'transaksi.id_user = user.id_user')
                    ->where('transaksi.id_transaksi', $id_transaksi)
                    ->get()
                    ->getRow();
}

public function updateTransaksi($id_transaksi, $data)
{
    return $this->db->table('transaksi')
                    ->where('id_transaksi', $id_transaksi)
                    ->update($data);
}



public function tampil2($table, $orderBy)
{
    return $this->db->table($table)->orderBy($orderBy)->get()->getResultArray();  // Keep it as an array
}

/*// Menyimpan data foto yang diunggah
    public function upload_photo($data) {
        $this->db->insert('photos', $data);
        return $this->db->insert_id(); // Mengembalikan ID foto yang baru diunggah
    }

    // Menyimpan komentar
    public function add_comment($data) {
        $this->db->insert('comments', $data);
    }

    // Mengambil semua foto dengan komentar yang terkait
    public function get_photos_with_comments() {
        $this->db->select('photos.*, comments.comment, users.username');
        $this->db->from('photos');
        $this->db->join('comments', 'comments.photo_id = photos.id', 'left');
        $this->db->join('users', 'comments.user_id = users.id', 'left');
        $query = $this->db->get();
        return $query->result();
    }*/
 /* public function get_photos_with_comments() {
    // Memulai query builder dengan tabel 'photos'
    $builder = $this->db->table('photos'); 

    // Menentukan kolom yang ingin diambil
    $builder->select('photos.*, comments.comment, users.username');

    // Melakukan join dengan tabel 'comments' dan 'users'
    $builder->join('comments', 'comments.photo_id = photos.id', 'left');
    $builder->join('users', 'comments.user_id = users.id', 'left');

    // Eksekusi query
    $query = $builder->get();

    // Cek apakah query berhasil
    if ($query === false) {
        // Tampilkan error
        log_message('error', $this->db->error()['message']); // Untuk mencatat error SQL
        return false;
    }

    // Mengembalikan hasil query
    return $query->getResult(); 
}*/

// Menyimpan data foto yang diunggah
/*public function upload_photo($data) {
    // Insert data ke tabel 'photos'
    $this->db->table('photos')->insert($data);
    
    // Mengembalikan ID foto yang baru diunggah
    return $this->db->insertID(); 
}

// Menyimpan komentar
public function add_comment($data) {
    // Insert data ke tabel 'comments'
    $this->db->table('comments')->insert($data);
}

// Mengambil semua foto dengan komentar yang terkait
public function get_photos_with_comments() {
    // Inisialisasi query builder untuk tabel 'photos'
    $builder = $this->db->table('photos');

    // Memilih kolom yang diperlukan dari 'photos', 'comments', dan 'users'
    $builder->select('photos.*, comments.comment, users.username');

    // Join tabel 'comments' dengan tabel 'photos' berdasarkan 'photo_id'
    $builder->join('comments', 'comments.photo_id = photos.id', 'left');

    // Join tabel 'users' dengan tabel 'comments' berdasarkan 'user_id'
    $builder->join('users', 'comments.user_id = users.id', 'left');

    // Eksekusi query
    $query = $builder->get();

    // Jika query gagal, return false
    if (!$query) {
        log_message('error', $this->db->error()['message']);
        return false;
    }

    // Mengembalikan hasil query sebagai array objek
    return $query->getResult();
}
   public function getAllMedia() {
    $builder = $this->db->table('media')
        ->select('media.*, users.username')
        ->join('users', 'users.id_user = media.id_user')
        ->orderBy('created_at', 'DESC');
    
    $query = $builder->get();

    if (!$query) {
        // Retrieve the error message
        $error = $this->db->error();
        log_message('error', 'Database error in getAllMedia: ' . $error['message']);
        // Optionally, you can throw an exception or handle the error as needed
        return false;
    }

    return $query->getResult();
}

public function getAllMediaWithUser() {
        return $this->db->table('media')
            ->select('media.*, users.nama_lengkap')
            ->join('users', 'users.id_user = media.id_user')
            ->get()
            ->getResult();
    }
 public function addComment($media_id, $id_user, $comment_text) {
        return $this->db->table('comments')->insert([
            'media_id' => $media_id,
            'id_user' => $id_user,
            'comment_text' => $comment_text
        ]);
    }
  public function addLike($media_id, $id_user) {
        return $this->db->table('likes')->insert([
            'media_id' => $media_id,
            'id_user' => $id_user
        ]);
    }
}*/
public function getAllMedia() {
        return $this->db->table('media')
            ->select('media.*, users.username')
            ->join('users', 'users.id_user = media.id_user')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResult();
    }

    public function saveMedia($data) {
        return $this->db->table('media')->insert($data);
    }

    public function addLike($media_id, $id_user) {
        return $this->db->table('likes')->insert([
            'media_id' => $media_id,
            'id_user' => $id_user
        ]);
    }
// Example of how to fetch media items with like counts
public function getMediaWithLikes() {
    $builder = $this->db->table('media');
    $builder->select('media.*, COUNT(likes.id) AS like_count');
    $builder->join('likes', 'likes.media_id = media.id', 'left');
    $builder->groupBy('media.id');
    $query = $builder->get();
    return $query->getResult();
}

    public function addComment($media_id, $id_user, $comment_text) {
        return $this->db->table('comments')->insert([
            'media_id' => $media_id,
            'id_user' => $id_user,
            'comment_text' => $comment_text,
            'created_at' => date('Y-m-d H:i:s')  // Menyimpan waktu pembuatan
        ]);
    }
    
    public function getAllMediaWithUser() {
        return $this->db->table('media')
            ->select('media.*, users.username')
            ->join('users', 'users.id_user = media.id_user')
            ->get()
            ->getResult();
    }
    
    public function get_media_with_comments()
    {
        $media = $this->findAll();  // Mengambil semua item media
    
        foreach ($media as &$item) {
            $item['comments'] = $this->db->table('comments')
                                         ->where('media_id', $item['id'])
                                         ->get()->getResultArray();
        }
    
        return $media;
    }
    
    
}