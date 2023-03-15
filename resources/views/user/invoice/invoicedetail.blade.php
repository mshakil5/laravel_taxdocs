@extends('layouts.user')
@section('content')
<style>
    .pl25{
        padding-left: 25px;
    }
</style>

<div class="dashboard-content">

    





    <section class=""> 
        <div class="row  my-3 mx-0 "> 
            <div class="col-md-12">
                <div class="row my-2">
                            
                    <div class="col-md-12 mt-2 text-center">
                        <div class="overflow">
                            <table class="table table-custom shadow-sm bg-white contentContainer" id="example">
                                <thead>
                                    <tr> 
                                        <th style="text-align: center">Sl</th>
                                        <th style="text-align: center">Description</th>
                                        <th style="text-align: center">Quantity</th>
                                        <th style="text-align: center">Unit Price</th>
                                        <th style="text-align: center">Vat Amount</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($data as $key =>  $data)
                                    <tr>
                                      <td style="text-align: center">{{ $key + 1 }}</td>
                                      <td style="text-align: center">{{ $data->description }}</td>
                                      <td style="text-align: center">{{ $data->quantity }}</td>
                                      <td style="text-align: center">{{ $data->unite_rate }}</td>
                                      <td style="text-align: center">{{ $data->vat }}</td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </section> 

</div>




@endsection
@section('script')
<script>

    $(document).ready(function () {
        $('#example').DataTable();
    });

    

</script>

@endsection
