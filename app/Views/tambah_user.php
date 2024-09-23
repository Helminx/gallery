<main id="main" class="main">

    <div class="pagetitle">
    
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Tambah user</h5>

              <!-- General Form Elements -->
              <form action="<?= base_url('home/aksi_t_user') ?>" method="POST"> 
              <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label"> ID User</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="id_user">
                  </div>
                </div>
                 <div class="row mb-3">
                  <label for="inputEmail" class="col-sm-2 col-form-label">Username</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="username">
                  </div>
                </div>
                 <div class="row mb-3">
                  <label for="inputEmail" class="col-sm-2 col-form-label">Password</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="password">
                  </div>
                </div>
                 <div class="row mb-3">
                  <label for="inputEmail" class="col-sm-2 col-form-label">Level</label>
                  <div class="col-sm-10">
                  <select  type="select" class="form-control" name="level" id="level" placeholder="Enter level" name="level" >
                   <option value="volvo">Pilih status</option>
                   <option value="1">1</option>
                   <option value="2">2</option>
                 </select> 
                 
                  </div>
                </div>
                
                    <button type="submit" class="btn btn-primary">Submit Form</button>
                  </div>
                </div>

              </form><!-- End General Form Elements -->

         