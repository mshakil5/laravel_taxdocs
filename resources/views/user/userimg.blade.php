@extends('layouts.user')
@section('content')
<style>
    .pl25{
        padding-left: 25px;
    }
</style>

<div class="dashboard-content">

    

    <section class="profile purchase-status px-4">

        <div class="title-section">
            <span class="iconify" data-icon="clarity:heart-solid"></span>
            <div class="mx-2">Add New Image</div>
        </div>

        <div class="title-section row mt-3">
            <div class="col-md-12">
                <div class="ermsg"></div>
                <div class="col-md-12 text-muted bg-white ">
                        <div class="row">
                            <div class="col-md-4 ">
                                <input type="date" placeholder="Date" id="date" name="date"  class="form-control">
                            </div>
                            
                            <div class="col-md-4 ">
                                <input type="file" placeholder="Image" id="image" name="image" class="form-control">
                            </div>
                            {{-- <div class="col-md-12 my-2">
                                <input type="text" placeholder="Description" class="form-control">
                            </div> --}}
                            <div class="col-md-12 my-2">
                                <button class="text-white btn-theme ml-1" id="addBtn" type="submit"> Submit </button>
                            </div>
                        </div>
                </div>
            </div>
        </div>

    </section>



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
                                        <th style="text-align: center">Date</th>
                                        <th style="text-align: center;width:50%">Image/PDF</th>
                                        <th style="text-align: center">Action </th> 
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach (\App\Models\Photo::where('user_id',Auth::user()->id)->orderby('id','DESC')->get() as $key => $data)
                                    <tr>
                                      <td style="text-align: center">{{ $key + 1 }}</td>
                                      <td style="text-align: center">{{ $data->date }}</td>
                                      <td style="text-align: center;width:50%">
                                          @if ($data->image)

                                          @php
                                            //   $extension = $data->image->getClientOriginalExtension();
                                              $ext = pathinfo(storage_path().$data->image, PATHINFO_EXTENSION);
                                          @endphp
                                            <div class="row justify-content-center">
                                                <iframe src="{{asset('images/'.$data->image)}}" width="30%" height="300px">
                                                        This browser does not support PDFs.Please download the PDF to view it: <a href="{{asset('images/'.$data->image)}}">Download PDF</a>
                                                </iframe>
                                            </div>
                                          @endif
                                      </td>
                                      
                                      <td style="text-align: center">
                                        @if ($data->status == 0)
                                            <a id="deleteBtn" rid="{{$data->id}}" class="text-white btn-theme">Delete</a>
                                        @endif
                                      </td>
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
        $("#addThisFormContainer").hide();
        $("#newBtn").click(function(){
            clearform();
            $("#newBtn").hide(100);
            $("#addThisFormContainer").show(300);

        });
        $("#FormCloseBtn").click(function(){
            $("#addThisFormContainer").hide(200);
            $("#newBtn").show(100);
            clearform();
        });
        //header for csrf-token is must in laravel
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        //
        var url = "{{URL::to('/user/photo')}}";
        // console.log(url);
        $("#addBtn").click(function(){
                var file_data = $('#image').prop('files')[0];
                if(typeof file_data === 'undefined'){
                    file_data = 'null';
                }
                var form_data = new FormData();
                form_data.append('image', file_data);
                form_data.append("date", $("#date").val());
                form_data.append("title", $("#title").val());
                $.ajax({
                  url: url,
                  method: "POST",
                  contentType: false,
                  processData: false,
                  data:form_data,
                  success: function (d) {
                      if (d.status == 303) {
                          $(".ermsg").html(d.message);
                      }else if(d.status == 300){
                          $(".ermsg").html(d.message);
                            window.setTimeout(function(){location.reload()},2000)
                      }
                  },
                  error: function (d) {
                      console.log(d);
                  }
              });
              
        });

         
            //Delete
            $(".contentContainer").on('click','#deleteBtn', function(){
                if(!confirm('Sure?')) return;
                codeid = $(this).attr('rid');
                info_url = url + '/'+codeid;
                $.ajax({
                    url:info_url,
                    method: "GET",
                    type: "DELETE",
                    data:{
                    },
                    success: function(d){
                        if(d.success) {
                            alert(d.message);
                            location.reload();
                        }
                    },
                    error:function(d){
                        console.log(d);
                    }
                });
            });
            //Delete
        
        

    });

    $(document).ready(function () {
        $('#example').DataTable();
    });

    

</script>

@endsection
