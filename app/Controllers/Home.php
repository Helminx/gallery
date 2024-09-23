<?php

namespace App\Controllers;
use Codeigniter\Controller;
use App\Models\M_kue;

class Home extends BaseController
{
      public function dashboard()
    {
        if (session()->get('level')>0){
        echo view ('header');
        echo view ('menu');
        echo view('dashboard');
        echo view ('footer');
          } else{
              return redirect()->to('home/login');
           }
    }
     public function login()
    {
        echo view('header');
        echo view('login');
    }
   public function aksi_login()
    {
        $u=$this->request->getPost('username');
        $p=$this->request->getPost('password');

        $model = new M_kue();
        $where=array(
            'username'=> $u,
            'password' => $p
        );

        $model = new M_kue();
        $cek = $model->getWhere('users',$where);
        
        if ($cek>0){
         session()->set('id_user',$cek->id_user);
         session()->set('username',$cek->username);
         session()->set('level',$cek->level);
         return redirect()->to('home/dashboard');
     }else{
        return redirect()->to('home/login');
    }
}
public function logout()
{
    session()->destroy();
    return redirect()->to('home/login');
}

public function user()
    {
        if (session()->get('level')>0){
        $model = new M_kue();
        $data ['manda'] = $model ->tampil('users','id_user');
        $where=array('id_user'=>session()->get('id'));
        /*$data['jes'] = $model->tampilgambar('toko');*/
         echo view ('header');
        echo view ('menu');
        echo view ('footer');
        echo view('user', $data);
          } else{
              return redirect()->to('home/login');
           }
    }
public function tambah_user() {
          if (session()->get('level')>0){
        $model = new M_kue();
        $data['manda'] = $model->tampil('user', 'id_user');
        echo view('header');
        echo view('menu');
        echo view('tambah_user', $data);
        echo view('footer');
         } else{
              return redirect()->to('home/login');
           }
    }
 public function aksi_t_user() {
        $model = new M_adopsi();
        $a = $this->request->getPost('id_user');
        $b = $this->request->getPost('username');
        $c = $this->request->getPost('password');
        $d = $this->request->getPost('level');

        $isi = array(
            'id_user' => $a,
            'username' => $b,
            'password' => $c,
            'level' => $d

        );
        $model->tambah('user', $isi);

        return redirect()->to('home/user');
    }
 public function edit_user($id){
        if (session()->get('level')>0){
     $model = new M_kue();
     $where=array('id_user'=>$id);

     $data['satu']=$model->getWhere('user',$where);
     echo view ('header');
     echo view ('menu', $data);
     echo view ('e_user',$data);
     echo view ('footer');
           } else{
              return redirect()->to('home/login');
           }
 }

 public function aksi_e_user()
 {
    $model = new M_adopsi();
    $a = $this->request->getPost('username');
    $b = $this->request->getPost('password');
    $c = $this->request->getPost('level');
    $id = $this->request->getPost('id');

    $where=array('id_user'=>$id);

    $isi = array(
       'username' => $a,
       'password' => $b,
       'level' => $c

   );

    $model ->edit('user', $isi, $where);

    return redirect()->to('home/user');
}
public function hapus_user($id){
    $model = new M_adopsi();
    $where=array('id_user'=>$id);
    $model->hapus('user',$where);
    return redirect()->to('home/user');
}
  // Menampilkan halaman upload foto dan komentar
   /* public function index() {
        if (session()->get('level') > 0) {
            $model = new M_kue();
            $data['photos'] = $model->get_photos_with_comments();
            echo view('header');
            echo view('photo_view', $data);
        } else {
            return redirect()->to('home/login');
        }
    }*/

    // Proses upload foto
    /*public function upload() {
        if (session()->get('level') > 0) {
            $model = new M_kue();
            $this->load->library('form_validation');

            // Aturan validasi untuk file upload
            $this->form_validation->set_rules('title', 'Title', 'required');
        
            if ($this->form_validation->run() === TRUE && !empty($_FILES['photo']['name'])) {
                // Konfigurasi upload
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size'] = 2048;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('photo')) {
                    // Data foto
                    $file_data = $this->upload->data();
                    $data = [
                        'user_id' => session()->get('id'), // ID user
                        'file_path' => 'uploads/' . $file_data['file_name'],
                        'title' => $this->input->post('title'),
                        'description' => $this->input->post('description')
                    ];
                    $model->upload_photo($data);
                    return redirect()->to('photo/dashboard');
                } else {
                    // Jika gagal upload
                    $data['error'] = $this->upload->display_errors();
                    echo view('header');
                    echo view('photo_view', $data);
                }
            } else {
                $this->dashboard();
            }
        } else {
            return redirect()->to('home/login');
        }
    }*/
/*public function upload() {
    if (session()->get('level') > 0) {
        $model = new M_kue();

        // Validasi file upload
        $validation = $this->validate([
            'photo' => [
                'uploaded[photo]',
                'mime_in[photo,image/jpg,image/jpeg,image/png]',
                'max_size[photo,2048]'
            ]
        ]);

        if ($validation) {
            // Dapatkan file foto
            $photo = $this->request->getFile('photo');
            if ($photo->isValid() && !$photo->hasMoved()) {
                // Pindahkan file ke folder 'uploads'
                $newName = $photo->getRandomName();
                $photo->move(WRITEPATH . 'uploads', $newName);

                // Simpan data foto ke database
                $data = [
                    'user_id' => session()->get('id'),
                    'file_path' => 'uploads/' . $newName,
                    'description' => $this->request->getPost('description')
                ];
                $model->upload_photo($data);

                // Redirect ke halaman dashboard
                return redirect()->to('photo/dashboard');
            } else {
                // Jika gagal upload
                $data['error'] = $photo->getErrorString();
                echo view('header');
                echo view('photo_view', $data);
            }
        } else {
            $data['error'] = $this->validator->listErrors();
            echo view('header');
            echo view('photo_view', $data);
        }
    } else {
        return redirect()->to('home/login');
    }
}



    // Proses komentar pada foto
    public function comment() {
        if (session()->get('level') > 0) {
            $model = new M_kue();
            $comment_data = [
                'photo_id' => $this->input->post('photo_id'),
                'user_id' => session()->get('id'), // ID user yang berkomentar
                'comment' => $this->input->post('comment')
            ];
            $model->add_comment($comment_data);
            return redirect()->to('photo/dashboard');
        } else {
            return redirect()->to('home/login');
        }
    }
    
      public function photo_view() {
        if (session()->get('level') > 0) {
            $model = new M_kue();
            $data['photos'] = $model->get_photos_with_comments();
            echo view('header');
             echo view('menu');
            echo view('photo_view', $data);
        } else {
            return redirect()->to('home/login');
        }
    }*/

/*public function upload() {
    $file = $this->request->getFile('media_file');
    $description = $this->request->getPost('description');
    $mediaType = $file->getMimeType(); // Tentukan apakah ini foto, video, atau teks
    
    if ($file->isValid() && !$file->hasMoved()) {
        $file->move(WRITEPATH . 'uploads');
        $model = new M_kue();
        $model->saveMedia([
            'id_user' => session()->get('id_user'),  // Ganti dari user_id ke id_user
            'media_type' => $mediaType,
            'media_path' => $file->getName(),
            'description' => $description
        ]);
    }

    return redirect()->to('home/media');
}

public function like($media_id) {
    $model = new M_kue();
    $model->addLike($media_id, session()->get('id_user'));  // Ganti dari user_id ke id_user
    return redirect()->to('home/media');
}

public function comment($media_id) {
    $comment = $this->request->getPost('comment');
    $model = new M_kue();
    $model->addComment($media_id, session()->get('id_user'), $comment);  // Ganti dari user_id ke id_user
    return redirect()->to('home/media');
}
public function mediatampil() {
    $model = new M_kue();
    $data['media'] = $model->getAllMediaWithUser();
    echo view('header');
    echo view('menu');
    echo view('mediatampil', $data);  // View baru untuk menampilkan media
    echo view('footer');
}
public function media() {
    $model = new M_kue();
    $where=array('logo_id' => '1');
    $logo['menu'] = $model->getwhere('logo',$where);
    $data['media'] = $model->getAllMedia();
    echo view('header', $logo);
    echo view('menu', $logo);
    echo view('media', $data);
    echo view('footer');
}

}*/
public function media() {
    $model = new M_kue();
    $data['media'] = $model->getAllMedia();
    echo view('header');
    echo view('menu');
    echo view('media', $data);
    echo view('footer');
}
   public function upload() {
        $file = $this->request->getFile('media_file');
        $description = $this->request->getPost('description');
        $mimeType = $file->getMimeType(); // Tentukan mimeType file
    
        // Tentukan media_type berdasarkan mimeType
        if (strpos($mimeType, 'image') !== false) {
            $mediaType = 'photo';
        } elseif (strpos($mimeType, 'video') !== false) {
            $mediaType = 'video';
        } else {
            $mediaType = 'text'; // Jika bukan image atau video, default ke text
        }
    
        if ($file->isValid() && !$file->hasMoved()) {
            $file->move(ROOTPATH . 'public/images');
            $model = new M_kue();
            $model->saveMedia([
                'id_user' => session()->get('id_user'),  // Ambil id_user dari session
                'media_type' => $mediaType,
                'media_path' => $file->getName(),
                'description' => $description
            ]);
        }
    
        return redirect()->to('home/media');
    }
public function like($media_id) {
        $model = new M_kue();
        //print_r(session()->get('id'));
        $model->addLike($media_id, session()->get('id'));  // Ganti dari user_id ke id_user
        return redirect()->to('home/mediatampil#media-' . $media_id);
    }

    public function comment($media_id) {
        $comment = $this->request->getPost('comment');
        $model = new M_kue();
        $model->addComment($media_id, session()->get('id'), $comment);  // Ganti dari user_id ke id_user
    
        // Redirect with anchor to stay on the same post
        return redirect()->to('home/mediatampil#media-' . $media_id);
    }
        
    public function media_feed() {
        $mediaItems = $this->M_kue->getAllMedia(); // Anggap Anda sudah memiliki metode untuk mendapatkan semua media
        foreach ($mediaItems as &$media) {
            $media->like_count = $this->M_kue->getLikeCount($media->id);
        }
        
        $data['mediaItems'] = $mediaItems;
        return view('mediatampil', $data);
    }
    

public function mediatampil() {
    $model = new M_kue();
   /* $where=array('logo_id' => '1');*/
   /* $logo['menu'] = $model->getwhere('logo',$where);*/
    $data['media'] = $model->getAllMediaWithUser();
    echo view('header');
    echo view('menu');
    echo view('mediatampil', $data);  // View baru untuk menampilkan media
    echo view('footer');
}
}