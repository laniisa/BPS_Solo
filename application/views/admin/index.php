
<style>
    .info-box{
        background-color: #454d55;
        box-shadow: 0px 0px 30px rgba(127, 137, 161, 0.25);
        color: white;
        border-radius: 10px;
        padding: 15px;
    }
</style>
    
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color: #454d55;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="color: white;">DISPOSISI | Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active"><a href="<?= site_url('admin') ?>">Dashboard</a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
 
    <div class="col-12">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                    <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-user-friends"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Jumlah Surat</span>
                            <span class="info-box-number">
                            <?= $jumlah_surat ?> <small>surat</small>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        
                        <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-cheese"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Jumlah User</span>
                            <span class="info-box-number">
                            <?= $total_users; ?>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        
                        <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-glass-martini-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Jumlah Berkas</span>
                            <span class="info-box-number">
                            <?= $total_berkas; ?>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            </div>
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
          </div>
          <!-- /.col -->
        <!-- /.row -->

    <!-- /.content -->
  </div>
 