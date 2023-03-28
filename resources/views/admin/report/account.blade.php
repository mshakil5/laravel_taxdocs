@extends('admin.layouts.admin')
@section('content')
<style>
    table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
    }
    th, td {
        text-align: left;
        padding: 8px;
    }
    tr:nth-child(even){background-color: #f2f2f2}

    .popup{
    width: 240px;
    margin: auto;
    text-align: center
    }
    .popup img{
        width: 100px;
        height: 100px;
        cursor: pointer
    }
    .show{
        z-index: 999;
        display: none;
    }
    .show .overlay{
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,.66);
        position: absolute;
        top: 0;
        left: 0;
    }
    .show .img-show{
        width: 600px;
        height: 400px;
        background: #FFF;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
        overflow: hidden
    }
    .img-show span{
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 99;
        cursor: pointer;
    }
    .img-show img{
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
    }
    /*End style*/
</style>
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-dashboard"></i> {{$user->bname}} All Documents</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            </ul>
        </div>


        <a href="{{ route('alluser')}}" id="backBtn" class="btn btn-info">Back</a>
        <hr>
        <div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3> Client Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="container">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th style="text-align: center; width:10%">Name</th>
                                            <th style="text-align: center; width:20%">Email</th>
                                            <th style="text-align: center; width:10%">Client ID</th>
                                            <th style="text-align: center; width:20%">Business Name</th>
                                            <th style="text-align: center; width:20%">Business Address</th>
                                            <th style="text-align: center; width:20%">Firm Name </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($user))
                                                <tr>
                                                    <td style="text-align: center">{{ $user->name }}</td>
                                                    <td style="text-align: center">{{ $user->email }}</td>
                                                    <td style="text-align: center">{{ $user->clientid }}</td>
                                                    <td style="text-align: center">{{ $user->bname }}
                                                    <input type="hidden" id="bname" value="{{$user->bname}}">
                                                    </td>
                                                    <td style="text-align: center">{{ $user->baddress }}</td>
                                                    <td style="text-align: center">{{ \App\Models\User::where('id',$user->firm_id)->first()->name}}</td>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div><br>
        <div id="contentContainer">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3> All Documents</h3>
                            <form  action="{{ route('admin.reportSearch', encrypt($id))}}" method ="POST">
                                @csrf
                                <br>
                                <div class="container">
                                    <div class="row">
                                        <div class="container-fluid">
                                            <div class="form-group row">
                                                <label for="date" class="col-form-label col-md-2">From Date</label>
                                                <div class="col-md-3">
                                                    <input type="date" class="form-control" id="fromDate" name="fromDate" value="{{$fromDate}}" required/>
                                                </div>
                                                <label for="date" class="col-form-label col-md-2">To Date</label>
                                                <div class="col-md-3">
                                                    <input type="date" class="form-control" id="toDate" name="toDate" value="{{$toDate}}" required/>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="submit" class="btn" name="search" title="Search"><img src="https://img.icons8.com/android/24/000000/search.png"/></button>
                                                </div>
    
                                            </div>
    
                                        </div>
    
                                    </div>
    
                                </div>
                                <br>
                            </form>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover" id="example">
                                <thead>
                                <tr>
                                    <th style="text-align: center">SL</th>
                                    <th style="text-align: center">Date</th>
                                    <th style="text-align: center">Image ID/ Invoice ID</th>
                                    <th style="text-align: center">Particular</th>
                                    <th style="text-align: center">Category</th>
                                    <th style="text-align: center">Amount</th>
                                    <th style="text-align: center">Vat</th>
                                    <th style="text-align: center">Net</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $data)
                                        
                                            <tr>
                                                <td style="text-align: center">{{ $key + 1 }}</td>
                                                <td style="text-align: center">{{$data->date}}</td>
                                                <td style="text-align: center">
                                                    @if (isset($data->invoice_id))
                                                        {{ \App\Models\Invoice::where('id',$data->invoice_id)->first()->invoiceid}}
                                                    @else
                                                        {{$data->photo_id}}
                                                    @endif
                                                </td>
                                                <td style="text-align: center">{{$data->particular}}</td>
                                                <td style="text-align: center">{{$data->category}}</td>
                                                <td style="text-align: center">{{$data->amount}}</td>
                                                <td style="text-align: center">{{$data->vat}}</td>
                                                <td style="text-align: center">{{$data->net}}</td>
                                            </tr>
                                        
                                    @endforeach
                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- image popup show  --}}
        <div class="show">
            <div class="overlay"></div>
            <div class="img-show">
              <span>X</span>
              <img src="">
            </div>
        </div>
    </main>
@endsection
@section('script')
    <script>
    $(document).ready(function() {
        var $companyname = $("#bname").val();
        var $from = $("#fromDate").val();
        var $to = $("#toDate").val();
        if ($from == "") {
            $title2 = "All Transaction";
        }else{
            $title2 = "From " + $from + " to " + $to;
        }
        var table = $('#example').DataTable( {
            lengthChange: false,
            buttons: [{
                extend: 'pdfHtml5',
                customize: function (doc) {
                    doc.content[1].table.widths = 
                        Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                },
                split: [ 'csv', 'excel'],
                title: $companyname + '\n' + $title2,
                    customize: function(doc) {
                        doc.styles.title = {
                        color: 'black',
                        fontSize: '24',
                        alignment: 'center'
                        }   
                    }  
                }]
            });
     
        table.buttons().container()
            .appendTo( '#example_wrapper .col-md-6:eq(0)' );
    });
    
    </script>
 


    
    <script type="text/javascript">
        $(document).ready(function() {
            $("#alluser").addClass('active');
            $("#alluser").addClass('is-expanded');
            $("#user").addClass('active');
        });
    </script>


@endsection
