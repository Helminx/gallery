<main id="main" class="main">

    <div class="pagetitle">
      <h1 align="center">User</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= base_url('home/dashboard') ?>">Home</a></li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
            <!--   <h5 class="card-title">Datatables</h5>
              <p>Add lightweight datatables to your project with using the <a href="https://github.com/fiduswriter/Simple-DataTables" target="_blank">Simple DataTables</a> library. Just add <code>.datatable</code> class name to any table you wish to conver to a datatable</p> -->

              <!-- Table with stripped rows -->
              <a href="<?= base_url('home/tambah_user') ?>">
  <button class="btn btn-success">+ Tambah</button>
</a>
              <table class="table table-dark">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Username</th>
                    <th scope="col">Password</th>
                    <th scope="col">Level</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
      <?php

  $no=1;
  foreach($manda as $erwin){
  ?>  

  <tr>
    <td><?= $no++ ?></td>
    <td><?=$erwin->username?></td>
    <td><?= $erwin ->password?></td>
    <td><?= $erwin ->level?></td>
   
      <td>
      <a href="<?= base_url('home/edit_user/' . $erwin ->id_user) ?>">
     <button class=" btn btn-warning">Edit</button>
    </a>

    <a href="<?= base_url('home/hapus_user/' . $erwin ->id_user) ?>">
     <button class=" btn btn-danger">Hapus</button>
      </a>
    </td>

  </tr>
  <?php } ?>
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

  