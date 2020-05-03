@extends('layouts.app')

@section('content')


<h1 align="center"><strong>Hardware Setting</strong></h1>
<div class=row>
   
        @if($errors->any())   
            <div class="alert alert-danger w-50 mx-auto">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li><strong>{{ $error }}</strong></li>
                    @endforeach
                </ul>
            </div>    
            @else
                @if (session('message'))
                    <div class="alert alert-success w-50 mx-auto" role="alert">
                        {{ session('message') }}
                    </div>
                @endif
        @endif 
   
</div>   

<div class="row justify-content-center">
        <div class="text-center col-md-5 col-sm-8">
            <img src="/img/setting.png" height="400px" weight="400px">
        </div>   
</div>
                 
      <form action="/rfid/rfidSetting/store" method="get">
          @csrf
          @if($record!=null)         
          <div class="row justify-content-center">
                    <div class="col-md-6 col-sm-8">    
                                                          
                                <div class="row justify-content-center">                                            
                                    <div class="form-group col-md-6 col-sm-8">                                
                                        <strong><label for="readerA_ip" class="pl-3 col-form-label" >ReaderA IP (e.g.192.168.1.140)</label></strong>
                                        <input id="readerA_ip" type="text" class="form-control add-input" name="readerA_ip" caption="readerA_ip" value="{{$record->ReaderA_ip}}" required autocomplete="readerA_ip" autofocus>
                                    </div>

                                    <div class="form-group col-md-6 col-sm-8">
                                         <strong><label for="readerB_ip" class="pl-3 col-form-label" >ReaderB IP</label></strong>
                                        <input id="readerB_ip" type="text" class="form-control add-input" name="readerB_ip" caption="readerB_ip" value="{{ $record->ReaderB_ip }}" required autocomplete="readerB_ip" autofocus>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="form-group col-md-6 col-sm-8">
                                         <strong><label for="readerC_ip" class="pl-3 col-form-label" >ReaderC IP</label></strong>
                                        <input id="readerC_ip" type="text" class="form-control add-input" name="readerC_ip" caption="readerC_ip" value="{{ $record->ReaderC_ip }}" required autocomplete="readerC_ip" autofocus>
                                    </div>

                                    <div class="form-group col-md-6 col-sm-8">
                                         <strong><label for="readerD_ip" class="pl-3 col-form-label" >ReaderD IP</label></strong>
                                        <input id="readerD_ip" type="text" class="form-control add-input" name="readerD_ip" caption="readerD_ip" value="{{ $record->ReaderD_ip }}" required autocomplete="readerD_ip" autofocus>
                                    </div>
                                </div>

                                <div class="row justify-content-center">
                                    <div class="form-group col-md-6 col-sm-8">
                                         <strong><label for="distance_a" class="pl-3 col-form-label" >Distance A (meters)</label></strong>
                                        <input id="distance_a" type="text" class="form-control add-input" name="distance_a" caption="distance_a" value="{{ $record->distance_A }}" required autocomplete="distance_a" autofocus>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-8">
                                         <strong><label for="distance_b" class="pl-3 col-form-label" >Distance B (meters)</label></strong>
                                        <input id="distance_b" type="text" class="form-control add-input" name="distance_b" caption="distance_b" value="{{ $record->distance_B }}" required autocomplete="distance_b" autofocus>
                                    </div>                  
                                </div>

                                <div class="row justify-content-center">
                                    <div class="form-group col-md-6 col-sm-8">
                                         <strong><label for="p" class="pl-3 col-form-label" >Tx Power (e.g. p = -64)</label></strong>
                                        <input id="p" type="text" class="form-control add-input" name="p" caption="p" value="{{ $record->p }}" required autocomplete="p" autofocus>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-8">
                                         <strong><label for="n" class="pl-3 col-form-label" >Path Loss Exponent (e.g. n = 2)</label></strong>
                                        <input id="n" type="text" class="form-control add-input" name="n" caption="n" value="{{ $record->n }}" required autocomplete="n" autofocus>
                                    </div>                  
                                </div> 
                                <br> 
                                <div class="row justify-content-center mx-auto">
                                    <button type="submit" class="btn btn-success btn-lg col-md-12" style="border-radius: 15px; background-color: #043364;border-color: #043364;">
                                        <strong>Update Setting</strong>
                                    </button>
                                </div>          
                            </div>
                
            </div>
        
          @endif         
      </form>
   
</div>

@endsection
<style  type= text/css>
.label{
    color:#043364;
}

</style>

<script type="text/javascript">
    // {{$errors->first('readerB_ip')}}  
    // {{$errors->first('readerC_ip')}}  
    // {{$errors->first('readerD_ip')}}  
    // {{$errors->first('distance_a')}}       
    // {{$errors->first('distance_b')}} 
    // {{$errors->first('p')}}       
    // {{$errors->first('n')}} 

    
</script>