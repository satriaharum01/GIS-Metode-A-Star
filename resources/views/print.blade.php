@extends('layouts.print')
@section('title', $title)
@section('content')
        <div class="container">
            <br/> 
            <div class="pull-left">
              {{$status}}
            </div>
            <div class="pull-right"> 
            <button type="button" class="btn btn-success btn-md" onclick="printDiv('printableArea')">
                <i class="fa fa-print"> </i> Print File
            </button>
            </div>
        </div>
        <br/>
        <div id="printableArea">
            <page size="A4">
  <section class="content">
  <center><h2><b>
      <?php 
      if($neraca == "kebutuhan"){
        echo "DATA KEBUTUHAN ";
      }else{
        echo "DATA KETERSEDIAAN ";
      }
      ?>
      <br>{{$cat}} Tahun {{$tahun}} </b></h2></center>
  <div class="row">
      <!--<hr class="hr1">
      <hr class="hr2"> -->
	    <div class="col-md-12">
	        <div class="box-primary">
				<!-- /.box-header -->
				<div class="box-body">
                    <table class="table table-bordered table-striped table" width="100%">
                        <thead>
                            <tr>
                            <th width="7%" style="text-align:center; vertical-align: middle;">No</th>
                            <th width="25%" style="text-align:center; vertical-align: middle;">Bulan</th>
                            <th style="text-align:center; vertical-align: middle;">Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $p)
                        <tr>
                          <td style="text-align:center; vertical-align: middle;">{{$no++}}</td>
                          <td style="text-align:center; vertical-align: middle;">{{$p->bulan}}</td>
                          <td style="text-align:center; vertical-align: middle;">{{$p->nilai}}</td>
                        </tr>
                        @endforeach
                        </tbody>
            </table>
			    </div>
			    </div>
               
    	</div>
    </div>
</section>
            </page>
        </div>
  </body>
  <script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
  </script>
</html>
@endsection