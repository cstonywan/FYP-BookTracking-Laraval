@extends('layouts.app')

@section('content')
<script type="text/javascript">
 

</script>
@if (session('message'))
    <div class="alert alert-success w-50 mx-auto" role="alert">
        {{ session('message') }}
    </div>
@endif
<div class="row">
<div class="text-center col-md-3 col-sm-8">
<img src="/img/setting.png" height="550px" weight="550px">
</div>   
    <div class="col-md-9 col-sm-6">           
        
      <form action="/rfid/rfidSetting/store" method="get">
          @csrf         
          <div class="row justify-content-center">
                  
                  <div class="col-md-7" style="padding-top: 120px;">  
                      <h2>RFID Setting:</h2>                   
                      <div class="row justify-content-center">                     
                          <div class="form-group col-md-6 col-sm-8">
                              <label for="readerA_ip" class="pl-3 col-form-label" style="color:#707070;">ReaderA IP (eg:192.168.1.140)</label>
                              <input id="readerA_ip" type="text" class="form-control add-input" name="readerA_ip" caption="readerA_ip" value="{{$record->ReaderA_ip}}" required autocomplete="readerA_ip" autofocus>
                          </div>

                          <div class="form-group col-md-6 col-sm-8">
                              <label for="readerB_ip" class="pl-3 col-form-label" style="color:#707070;">ReaderB IP</label>
                              <input id="readerB_ip" type="text" class="form-control add-input" name="readerB_ip" caption="readerB_ip" value="{{ $record->ReaderB_ip }}" required autocomplete="readerB_ip" autofocus>
                          </div>
                      </div>
                      <div class="row justify-content-center">
                          <div class="form-group col-md-6 col-sm-8">
                              <label for="readerC_ip" class="pl-3 col-form-label" style="color:#707070;">ReaderC IP</label>
                              <input id="readerC_ip" type="text" class="form-control add-input" name="readerC_ip" caption="readerC_ip" value="{{ $record->ReaderC_ip }}" required autocomplete="readerC_ip" autofocus>
                          </div>

                          <div class="form-group col-md-6 col-sm-8">
                              <label for="readerD_ip" class="pl-3 col-form-label" style="color:#707070;">ReaderD IP</label>
                              <input id="readerD_ip" type="text" class="form-control add-input" name="readerD_ip" caption="readerD_ip" value="{{ $record->ReaderD_ip }}" required autocomplete="readerD_ip" autofocus>
                          </div>
                      </div>

                      <div class="row justify-content-center">
                          <div class="form-group col-md-6 col-sm-8">
                              <label for="distance_a" class="pl-3 col-form-label" style="color:#707070;">Distance A (meters)</label>
                              <input id="distance_a" type="text" class="form-control add-input" name="distance_a" caption="distance_a" value="{{ $record->distance_A }}" required autocomplete="distance_a" autofocus>
                          </div>
                          <div class="form-group col-md-6 col-sm-8">
                              <label for="distance_b" class="pl-3 col-form-label" style="color:#707070;">Distance B (meters)</label>
                              <input id="distance_b" type="text" class="form-control add-input" name="distance_b" caption="distance_b" value="{{ $record->distance_B }}" required autocomplete="distance_b" autofocus>
                          </div>                  
                      </div>

                      <div class="row justify-content-center">
                          <div class="form-group col-md-6 col-sm-8">
                              <label for="p" class="pl-3 col-form-label" style="color:#707070;">Tx Power (Eg:-65)</label>
                              <input id="p" type="text" class="form-control add-input" name="p" caption="p" value="{{ $record->p }}" required autocomplete="p" autofocus>
                          </div>
                          <div class="form-group col-md-6 col-sm-8">
                              <label for="n" class="pl-3 col-form-label" style="color:#707070;">Path Loss Exponent (Eg:2)</label>
                              <input id="n" type="text" class="form-control add-input" name="n" caption="n" value="{{ $record->n }}" required autocomplete="n" autofocus>
                          </div>                  
                      </div>  
                      <div class="row justify-content-center mx-auto">
                        <button type="submit" class="btn btn-success btn-lg col-md-12">
                            <strong>submit</strong>
                        </button>
                      </div>          
                  </div>
                 
          </div>          
      </form>
    </div>
</div>
@endsection
