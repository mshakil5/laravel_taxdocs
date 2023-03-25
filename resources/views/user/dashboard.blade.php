@extends('layouts.user')

@section('content')

<div class="dashboard-content py-2 px-4">
  <div class="userStatus">
      <div class="items">
          <span>Uploaded Documents</span>
          <span> {{ \App\Models\Photo::where('user_id', Auth::user()->id )->count() }}</span>
      </div>
  </div>
  {{-- <div class="row my-4">
      <div class="col-md-12 text-center ">
          <h4 class="text-capitalize bg-info text-white p-3 border-left d-inline-block mx-auto rounded">
              welcome to {{Auth::user()->name}}
          </h4>
      </div>
  </div> --}}

  
  <fieldset>
    <div class="row">
        @if (isset(Auth::user()->firm_id))
            <div class="col-md-4">
                <div class="transferFunds shadow-sm">
                    <div class="para pl-2 text-center">
                        <a href="{{ route('user.photo')}}"> 

                            <img src="{{asset('user/images/photo.jpeg')}}" style="width: 200px">
                        
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="transferFunds shadow-sm">
                    <div class="para pl-2 text-center">
                            <a href="{{ route('user.invoice')}}"> 
                                <img src="{{asset('user/images/inv.jpeg')}}" style="width: 200px">
                            </a>
                    </div>
                </div>
            </div>

            
            <div class="col-md-4">
                <div class="transferFunds shadow-sm">
                    <div class="para pl-2 text-center">
                        <a href="{{ route('user.payroll')}}"> 
                            <img src="{{asset('user/images/payroll.jpeg')}}" style="width: 200px">
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-4">
                <div class="transferFunds shadow-sm">
                    <div class="para pl-2 text-center">
                        <a href="#"> 

                            <img src="{{asset('user/images/photo.jpeg')}}" style="width: 200px">
                        
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="transferFunds shadow-sm">
                    <div class="para pl-2 text-center">
                            <a href="#"> 
                                <img src="{{asset('user/images/inv.jpeg')}}" style="width: 200px">
                            </a>
                    </div>
                </div>
            </div>

            
            <div class="col-md-4">
                <div class="transferFunds shadow-sm">
                    <div class="para pl-2 text-center">
                        <a href="#"> 
                            <img src="{{asset('user/images/payroll.jpeg')}}" style="width: 200px">
                        </a>
                    </div>
                </div>
            </div>
        @endif
        

    </div>
</fieldset><br>
  {{-- <fieldset>
      <div class="row">
          <div class="col-md-5">
              <div class="transferFunds shadow-sm">
                  <div class="pointer">
                      1
                  </div>
                  <div class="para pl-2">
                      <a href="{{ route('user.photo')}}"> Upload Documents</a>
                  </div>
              </div>
              <div class="transferFunds shadow-sm">
                    <div class="pointer">
                        3
                    </div>
                    <div class="para pl-2">
                        <a href="{{ route('user.invoice')}}"> Create Invoice</a>
                    </div>
                </div>
          </div>
          <div class="col-md-1 d-flex justify-content-center align-items-center">
              <h4 class="my-3"> OR</h4>
          </div>
          <div class="col-md-5">
              <div class="transferFunds shadow-sm">
                  <div class="pointer">
                      2
                  </div>
                  <div class="para pl-2">
                    <a href="{{ route('user.payroll')}}"> Payroll</a>
                  </div>
              </div>
              <div class="transferFunds shadow-sm mt-2">

                  <div class="para pl-2">
                      <b>Bank Name</b> <br>
                      
                      Bank Account Number: @if (isset(\App\Models\BankAccountDetail::where('user_id',Auth::user()->id)->where('status','1')->first()->bank_acc_number)) {{\App\Models\BankAccountDetail::where('user_id',Auth::user()->id)->where('status','1')->first()->bank_acc_number}} @endif<br>
                      Bank Account Sort Code: @if (isset(\App\Models\BankAccountDetail::where('user_id',Auth::user()->id)->where('status','1')->first()->bank_acc_sort_code)) {{\App\Models\BankAccountDetail::where('user_id',Auth::user()->id)->where('status','1')->first()->bank_acc_sort_code}} @endif<br>
                  </div>
              </div>

          </div>
      </div>
  </fieldset> --}}
  
</div>


@endsection
