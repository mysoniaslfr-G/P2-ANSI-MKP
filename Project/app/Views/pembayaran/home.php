<?= $this->include('tamplate/header')?>
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <form action="<?=base_url('/pembayaran/show')?>" method="GET" class="form-inline">
                    <input type="text" name="nim" class="form-control" placeholder="Masukkan NIM..." required>
                    <button type="submit" class="btn btn-primary"> Cari Mahasiswa</button>
                </form>
            </div>
        </div>
    </div>


    
<?= $this->include('tamplate/footer')?>
