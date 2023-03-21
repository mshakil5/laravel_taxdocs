@extends('admin.layouts.admin')

@section('content')
<main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
      </ul>
    </div>
    <div class="row">

      @if (Auth::user()->is_type == 2)
      <div class="col-md-6 col-lg-3">
        <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
          <div class="info">
            <h4>Users</h4>
            <p><b>{{\App\Models\User::where('firm_id','=', Auth::user()->id)->where('is_type','0')->count()}}</b></p>
          </div>
        </div>
      </div>
      @endif

      @if (Auth::user()->is_type == 2)
      <div class="col-md-6 col-lg-3">
        <div class="widget-small info coloured-icon"><i class="icon fa fa-thumbs-o-up fa-3x"></i>
          <div class="info">
            <h4>Documents</h4>
            <p><b>{{\App\Models\Photo::where('firm_id','=', Auth::user()->id)->count()}}</b></p>
          </div>
        </div>
      </div>
      @endif

      {{-- <div class="col-md-6 col-lg-3">
        <div class="widget-small warning coloured-icon"><i class="icon fa fa-files-o fa-3x"></i>
          <div class="info">
            <h4>Uploades</h4>
            <p><b>10</b></p>
          </div>
        </div>
      </div>


      <div class="col-md-6 col-lg-3">
        <div class="widget-small danger coloured-icon"><i class="icon fa fa-star fa-3x"></i>
          <div class="info">
            <h4>Stars</h4>
            <p><b>500</b></p>
          </div>
        </div>
      </div> --}}


    </div>
    <div class="row">
      <div class="col-md-6" id="contentContainer">
        <div class="tile">
          <h3 class="tile-title">New user notification</h3>
          @if (Auth::user()->is_type == 1)
            @foreach (\App\Models\User::where('admin_notify','=', 0)->where('is_type','0')->get() as $user)
            <div class="bs-component">
              <div class="alert alert-dismissible alert-success">
                <a id="newusernBtn" user_id="{{$user->id}}"><button class="close" type="button" data-dismiss="alert">×</button></a>
                <strong>New Customer!!</strong> New Customer added. <a class="alert-link" href="{{ route('notassigncustomer')}}">See More</a>.
              </div>
            </div>
            @endforeach
          @endif

          @if (Auth::user()->is_type == 2)
            @foreach (\App\Models\User::where('agent_assign','=', 1)->where('firm_id','=', Auth::user()->id)->where('agent_notify','=', 0)->where('is_type','0')->get() as $user)
            <div class="bs-component">
              <div class="alert alert-dismissible alert-success">
                <a id="newusernotiBtn" user_id="{{$user->id}}"><button class="close" type="button" data-dismiss="alert">×</button></a>
                <strong>New Customer!!</strong> New Customer added. <a class="alert-link" href="{{ route('alluser')}}">See More</a>.
              </div>
            </div>
            @endforeach
          @endif

        </div>
      </div>

      <div class="col-md-6" id="contentContainer2">
        <div class="tile">
          <h3 class="tile-title">User Image Notification</h3>

          @if (Auth::user()->is_type == 1)
            @foreach (\App\Models\Photo::where('admin_notification','=', 0)->orderby('id','DESC')->get() as $img)
            <div class="bs-component">
              <div class="alert alert-dismissible alert-success">
                <a id="newimgnotiAdminBtn" imgid="{{$img->id}}"><button class="close" type="button" data-dismiss="alert">×</button></a>
                <strong>New Image!!</strong> New Image added. <a class="alert-link" href="{{ route('showimg', encrypt($img->user_id))}}">See More</a>.
              </div>
            </div>
            @endforeach
          @endif


            @if (Auth::user()->is_type == 2)
            @foreach (\App\Models\Photo::where('accfirm_notification','=', 0)->orderby('id','DESC')->where('firm_id','=', Auth::user()->id)->get() as $img)
            <div class="bs-component">
              <div class="alert alert-dismissible alert-success">
                <a id="newimgnotiAgentBtn" imgid="{{$img->id}}"><button class="close" type="button" data-dismiss="alert">×</button></a>
                <strong>New Image!!</strong> New Image added. <a class="alert-link" href="{{ route('showimg', encrypt($img->user_id))}}">See More</a>.
              </div>
            </div>
            @endforeach
          @endif



        </div>
      </div>





    </div>
  </main>
@endsection

@section('script')
<script>
  $(document).ready(function () {

  //header for csrf-token is must in laravel
  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  //


      //  new user notification
      var url = "{{URL::to('/admin/newusernoti')}}";
      $("#contentContainer").on('click','#newusernBtn', function(){

          var userid= $(this).attr('user_id');

          $.ajax({
              url: url,
              method: "POST",
              data: {userid},
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

      //  new user notification
      var agenturl = "{{URL::to('/agent/newusernoti')}}";
      $("#contentContainer").on('click','#newusernotiBtn', function(){

          var userid= $(this).attr('user_id');

          $.ajax({
              url: agenturl,
              method: "POST",
              data: {userid},
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


      var adminimgurl = "{{URL::to('/admin/newimage-notification')}}";
      $("#contentContainer2").on('click','#newimgnotiAdminBtn', function(){

          var imgid= $(this).attr('imgid');

          $.ajax({
              url: adminimgurl,
              method: "POST",
              data: {imgid},
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

      var agentimgurl = "{{URL::to('/agent/newimage-notification')}}";
      $("#contentContainer2").on('click','#newimgnotiAgentBtn', function(){

          var imgid= $(this).attr('imgid');

          $.ajax({
              url: agentimgurl,
              method: "POST",
              data: {imgid},
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


      








  });
</script>
@endsection
