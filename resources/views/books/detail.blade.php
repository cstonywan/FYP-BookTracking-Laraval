@extends('layouts.app')

@section('content')


<div class="container">
    <div class="justify-content-center">
        <!-- <h1 align="center">{{ $book->title}}</h1> -->
        <div class="col-md-12 justify-content-center">

            @if(session()->has('update_message'))
            <div class="alert alert-success alert-dismissable" style="Font-size:25px;Font-weight:bold;min-width:1200px;">
                Success! You had lead the book.
            </div>
            @endif
            <!--For show image -->
            
            <div class="row justify-content-center">
           
            <div class="col-md-12">
                <h1 align=center><strong>Book Information</strong></h1>
               
            </div>
                <div class="col-md-3">
                    @if($book->image)
                        <img src="/storage/{{ $book->image }}" weight="200px" height="300px" class="img-thumbnail">
                    @else
                        <img src="/storage/uploads/default.png" class="border" weight="250" height="350">
                    @endif
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="text-info"><span><strong >{{$book->title}}</strong></span>                                                   
                            </h1><br>
                        </div>
                        <div class="col-md-12">                        
                            <span id="bookstatus" style="color:#043364"><strong> {{$book->status}}</strong></span>
                        </div>
                        <div class="col-md-12">
                        <div class="row">
                            @if($book->status=="inLibrary")
                            <div class="col-md-2">                                   
                                <span>
                                    <button type="button" class="btn btn-info" title="Track Book" style="background: transparent;border: none;background-repeat:no-repeat;  outline:none;" onclick="window.location='{{ url('/b/track/'.$book->id) }}'">
                                    <img src="/icon/track.png" style ="border:0;"width="50px" height="50px" onmouseover="hovertrack(this);" onmouseout="unhovertrack(this);">                                   
                                    </button>
                                </span>
                            </div> 
                            @else
                            <span>
                                    <button type="button" class="btn btn-info" title="Track Book" style="background: transparent;border: none;background-repeat:no-repeat;  outline:none;" onclick="window.location='{{ url('/b/track/'.$book->id) }}'" disabled>
                                    <img src="/icon/track.png" style ="border:0;"width="50px" height="50px">                                   
                                    </button>
                                </span>
                            @endif
                            <div class="col-md-2">
                                <span>
                                    @if (Auth::user()->role >= 1 && $book->status == "inLibrary")                                                                
                                    <form action="{{ route('manageBorrow') }}" method="get">
                                        @csrf
                                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                                        <button type="submit"  class="btn btn-info" title="Lend book" style="background: transparent;border: none; background-repeat:no-repeat; outline:none;" id="leadbook_btn" >
                                        <img src="/icon/lend.png" style ="border:0;" width="50px" height="50px" onmouseover="hoverlend(this);" onmouseout="unhoverlend(this);">                                                       
                                    </form>                                                             
                                    @endif
                                <span>                                
                                </div>                                 
                           </div>                                                                 
                                              
                        </div>
                    </div>    
                    <div class="row">
                        <div class="col-md-6">
                        <br>
                        <strong style="color:#043364">Tag ID:</strong><h3 style="color:#787878">{{$book->tag_id}}</h3><br>
                        </div>
                        <div class="col-md-6">
                        <br>
                        <strong style="color:#043364">Type:</strong><h3 style="color:#787878">{{$book->type}}</h3><br>
                        </div>
                        <div class="col-md-6">
                           <strong style="color:#043364">Author:</strong><p style="color:#787878">{{$book->author}}</p>                            
                        </div>
                        <div class="col-md-6">
                            <strong style="color:#043364">Publisher: </strong><p style="color:#787878">{{$book->publisher}}</p>                   
                        </div>
                        <div class="col-md-6">
                            <strong style="color:#043364">Publication Year: </strong><p style="color:#787878">{{$book->publicationYear}}</p>                   
                        </div>
                        <div class="col-md-6">
                            <strong style="color:#043364">Language: </strong><p style="color:#787878">{{$book->language}}</p>                   
                        </div> 
                        <div class="col-md-6">
                            <strong style="color:#043364">ISBN: </strong><p style="color:#787878">{{$book->ISBN}}</p>                   
                        </div> 
                        <div class="col-md-6">
                            <strong style="color:#043364">Page Number: </strong><p style="color:#787878">{{$book->pageNumber}}</p>                   
                        </div>
                        
                        <div class="col-md-12">
                        <br>
                        <strong style="color:#043364">Description: </strong>
                        <p style="color:#787878">{{$book->description}}</p>
                        </div>
                    </div>
                </div>               
            
           </div>

         <!--For show Book Details -->

       

           
        </div>
    </div>
</div>

@endsection
<script type="text/javascript">

function hovertrack(element) {
  element.setAttribute('src', '/icon/trackhover.png');
  var spans = document.getElementById('bookstatus');
  spans.style.color = '#ff6e42';
}

function unhovertrack(element) {
  element.setAttribute('src', '/icon/track.png');
  var spans = document.getElementById('bookstatus');
  spans.style.color = '#043364';
} 

function hoverlend(element) {
  element.setAttribute('src', '/icon/lendhover.png');
}

function unhoverlend(element) {
  element.setAttribute('src', '/icon/lend.png');
} 

</script>