<?= $this->include('tamplate/header') ?>

<div class="container-fluid">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <p>Jumlah Mahasiswa</p>
          <h3><?= hitung('mahasiswa'); ?></h3>
          
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->

    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-success">
        <div class="inner">
           <p>Jumlah Jurusan</p>
          <h3><?= hitung('jurusan'); ?></h3>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>

      </div>
    </div>
    <!-- ./col -->

    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-warning">
        <div class="inner">
             <p>Jumlah SPP</p>
          <h3><?= hitung('spp'); ?></h3>
       
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
       
      </div>
    </div>
    <!-- ./col -->

    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-danger">
        <div class="inner">
           <p>Jumlah Petugas</p>
          <h3><?= hitung('petugas'); ?></h3>
         
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
      
      </div>
    </div>
    <!-- ./col -->
  </div>
  <!-- /.row -->
</div>

<?= $this->include('tamplate/footer') ?>
