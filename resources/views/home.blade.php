@extends('layouts.header')
@section('title', 'Data Users')
@section('content')
<section class="content-header">
    <h1>
      <i class="fa fa-line-chart" style="color:black"> </i> Data Users
    </h1>
  </section>
  <section class="content">
  <div class="row">
	    <div class="col-md-12">
	        <div class="box box-primary">
                <div class="box-header with-border">
                <b style="color:green"><i class="fa fa-calendar"></i>&nbsp; Daftar Data User</b>
                     <button type="button" class="btn btn-primary" style="float: right;" data-toggle="modal" data-target="#add_modal"><i class="fa fa-plus"></i> Tambah Data 
              </button>
              <!--
              <button type="button" class="btn btn-danger btn-print" style="margin-right: 2%;float: right;"><i class="fa fa-print"></i> Cetak Data 
              </button>-->
				 </div>
				<!-- /.box-header -->
				<div class="box-body">
                    <table id="example1" class="table table-bordered table-striped table" width="100%">
                        <thead>
                            <tr>
                                <th width="7%" style="text-align:center; vertical-align: middle;">No</th>
                                <th width="20%" style="text-align:center; vertical-align: middle;">Nama User</th>
                                <th width="25%" style="text-align:center; vertical-align: middle;">Email</th>
                                <th width="15%" style="text-align:center; vertical-align: middle;">Level</th>
                                <th width="15%" style="text-align:center; vertical-align: middle;">Tanggal Dibuat</th>
                                <th style="text-align:center; vertical-align: middle;">Aksi</th>
                               </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $p)
                        <tr>
                            <td style="text-align:center; vertical-align: middle;">{{$no++}}</td>
                            <td style="text-align:center; vertical-align: middle;">{{$p->name}}</td>
                            <td style="text-align:center; vertical-align: middle;">{{$p->email}}</td>
                            <td style="text-align:center; vertical-align: middle;">{{$p->level}}</td>
                            <td style="text-align:center; vertical-align: middle;">{{$p->created_at}}</td>
                        
                            <td><center>
                                <button class="btn btn-warning" data-toggle="modal" data-target="#compose{{$p->id}}"><i class="fa fa-edit"> Edit</i></button>
                                @csrf
                                <a class="btn btn-danger" href="{{ route('users.destroy', ['id' => $p->id]) }}"
                                onclick="Confirmation({{$p->id}})">
                                <i class="fa fa-trash"></i> Hapus</a>
                                </center>
                                <form id="delete-form-{{ $p->id }}" action="{{ route('users.destroy', ['id' => $p->id]) }}"
                                    method="GET" style="display: none;">
                                    @csrf
                                </form>
                            </td> 
                        </tr>
                            <!-- ============ MODAL EDIT DATA =============== -->

                                    <div class="modal fade" id="compose{{$p->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">   
                                            <span aria-hidden="true">&times;</span> 
                                            </button>
                                            <center><b>
                                            <h4 class="modal-title" id="exampleModalLabel">Edit Data Users</h4> </b></center>    
                                        </div>
                                        <form action="/users/update/{{$p->id}}" method="post" id="compose-form" class="swal-form">
                                        <input name="_method" type="hidden" value="patch">
                                        @csrf
                                        <div class="modal-body"> 
                                            <div class="form-group">
                                                <label>User ID</label>
                                                <input disabled type="number" class="form-control" value="{{$p->id}}" name="id">
                                            </div>
                                            <div class="form-group">
                                                <label>Nama User</label>
                                                <input required type="text" class="form-control" value="{{$p->name}}" name="nama">
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input required type="email" class="form-control" value="{{$p->email}}" name="email">
                                            </div>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" minlength="8" class="form-control" placeholder="Kosongkan Jika Tidak Diubah" name="password">
                                            </div>
                                            <div class="form-group">
                                                <label>Level</label>
                                                <select name="level" class="form-control">
                                                    <option value="Admin" <?php if($p->level == "Admin"){echo 'selected';}?>  >Admin</option>
                                                    <option value="User"  <?php if($p->level == "User"){echo 'selected';}?>  >User</option>
                                                </select>
                                            </div>
                                            <button type="reset" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary btn-simpan">Simpan</button>
                                            </form>
                                        </div>
                                        
                                        </div>
                                    </div>
                                    </div>
                            <!--- END MODAL EDIT DATA --->
                        @endforeach
                        </tbody>
                   </table>
			    </div>
			    </div>
    	</div>
    </div>
</section>
                                    <!--- END MODAL TAMBAH DATA --->

                                    <div class="modal fade" id="add_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">   
                                            <span aria-hidden="true">&times;</span> 
                                            </button>
                                            <center><b>
                                            <h4 class="modal-title" id="exampleModalLabel">Edit Data Users</h4> </b></center>    
                                        </div>
                                        <form action="/users/store" method="post" id="compose-form" class="swal-form">
                                        @csrf
                                        <div class="modal-body"> 
                                            <div class="form-group">
                                                <label>Nama User</label>
                                                <input required type="text" class="form-control" value="" name="nama">
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input required type="email" class="form-control" value="" name="email">
                                            </div>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input required type="password" minlength="8" class="form-control" name="password">
                                            </div>
                                            <div class="form-group">
                                                <label>Level</label>
                                                <select name="level" class="form-control">
                                                    <option value="Admin">Admin</option>
                                                    <option value="User">User</option>
                                                </select>
                                            </div>
                                            <button type="reset" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary btn-simpan">Simpan</button>
                                            </form>
                                        </div>
                                        
                                        </div>
                                    </div>
                                    </div>
                            <!--- END MODAL TAMBAH DATA --->
                            
@endsection

@section('custom_script')
<script>
    function Confirmation(x){
        event.preventDefault()
            Swal.fire({
                title: 'Hapus Data ?',
                text: "Data yang dihapus tidak dapat dikembalikan !",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'Tidak'
                }).then((result) => {
                if (result.value) {
                    Swal.fire(
                    'Data Dihapus!',
                    '',
                    'success'
                    );
                    document.getElementById('delete-form-'+x).submit();
                }              
                });
                                
    }
    //Event By Form Submit
    $(".swal-form").on("submit",function(){
        Swal.fire(
            'Data Disimpan!',
            '',
            'success'
            )
    });
    
</script>

@endsection