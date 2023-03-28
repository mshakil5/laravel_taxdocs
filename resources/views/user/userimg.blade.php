@extends('layouts.user')
@section('content')
<style>
    /*loader css*/
    #loading {
        position: fixed;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0.7;
        background-color: #fff;
        z-index: 99;
    }

    #loading-image {
    z-index: 100;
    }

    .popup{
        width: 240px;
        margin: auto;
        text-align: center
    }
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
    }
    .show .overlay{
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,.66);
        position: absolute;
        top: 0;
        left: 0;
    }
    
    .show .img-show {
        width: 500px;
        height: 500px;
        background: #FFF;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .img-show span{
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 99;
        cursor: pointer;
    }
    
    .img-show img {
        width: 500px;
        height: auto;
        position: relative;
        top: 0;
        left: 0;
    }
    /*End style*/
</style>

<div class="dashboard-content">

        <!-- Image loader -->
        <div id='loading' style='display:none ;'>
            <img src="{{ asset('images/company/loader.gif') }}" id="loading-image" alt="Loading..." style="height: 225px;" />
       </div>
     <!-- Image loader -->
    

    <section class="profile purchase-status px-4">

        <div class="row">
            <div class="col-md-12">
                <div class="title-section">
                    <span class="iconify" data-icon="clarity:heart-solid"></span>
                    <div class="mx-2">Add New Image</div>
                </div>
                
                <div class="ermsg"></div>

                <div class="col-md-12 text-muted bg-white ">
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <input type="date" placeholder="Date" id="date" name="date"  class="form-control" value="{{date('Y-m-d')}}">
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
                                            @if ($ext == 'pdf')
                                                <div class="row justify-content-center">
                                                    <iframe src="{{asset('images/'.$data->image)}}" width="20%" height="100px">
                                                            This browser does not support PDFs.Please download the PDF to view it: <a href="{{asset('images/'.$data->image)}}">Download PDF</a>
                                                    </iframe>
                                                </div>
                                            @else
                                            <div class="popup">
                                                <img src="{{asset('images/'.$data->image)}}" height="100px" width="200px" alt="">
                                            </div>


                                            @endif
                                            
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

    {{-- image popup show  --}}
    <div class="show" style="display: none">
        <div class="overlay"></div>
        <div class="img-show">
          <span>X</span>
          <img src="">
        </div>
    </div>

</div>



@endsection
@section('script')

<script>


    
$(function () {
"use strict";

    $(".popup img").click(function () {
        var $src = $(this).attr("src");
        $(".show").fadeIn();
        $(".img-show img").attr("src", $src);
    });
    
    $("span, .overlay").click(function () {
        $(".show").fadeOut();
    });
    
});


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
                $("#loading").show();

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
                          $('#image').val('');
                        window.setTimeout(function(){location.reload()},2000)
                      }
                  },
                    complete:function(d){
                        $("#loading").hide();
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
