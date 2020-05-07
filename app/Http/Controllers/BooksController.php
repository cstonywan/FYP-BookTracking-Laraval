<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Request;
use App\Book;
use App\Alltag;
use App\Rfid;
use App\Setting;
use App\lostbook;
use App\Fivemins;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use DateTime;


class BooksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // public function create()
    // {
    //   return view('/b/postajax');
    // }

    // public function postAjax(Request $request){
    //      $bookid = $request->bookid;

    //     $book = Book::find($bookid);
    //     if($book){
    //         $book->status = 'inLibrary';
    //         $book->save();
    //     }     
    //    // $data = $request->all();
    //     #create or update your data here

    //     return response()->json(['success'=>$bookid]); 
    // }

    public function getAjax(){

        $usedTag = Book::whereNotNull('tag_id')->where('status','=','inLibrary')      
        ->pluck('tag_id')->toArray(); //inlibrary        
        $currentTag = Rfid::whereIn('tag_id', $usedTag)->get();

        $miss_tag = array();
        $group = collect($currentTag)->groupBy('tag_id');
        
        $currentDate = date('Y-m-d H:i:s.') . gettimeofday()['usec'];
       
         
        foreach($group as $tag) {
            $missing = true;
            for ($i=0; $i<count($tag); $i++) {
              if (strtotime($currentDate) - strtotime($tag[$i]['reader_record_time']) <= 5) {
                  $missing  = false;            
              }                      
            }
            if ($missing) {
                array_push($miss_tag, $tag[0]['tag_id']);
            }
        }
        $bookid = array();
        $bookTitle = array(); 
        $record = array(); 
        
        for($i=0; $i<count($miss_tag); $i++){
            $bookid[$i] = Book::where('tag_id','=',$miss_tag[$i])->value('id');
            $bookTitle[$i] = Book::where('tag_id','=',$miss_tag[$i])->value('title');             
            $record[$i] = [$bookid[$i], $bookTitle[$i], $miss_tag[$i]];                                                               
        }

        // if(count($record)>0){
        //     for($a=0;$a<count($record);$a++){                              
        //         $book = Book::find( $record[$a][0]);
        //         if($book){
        //             $book->status = 'missing';
        //             $book->save();
        //         }
        //     }
        // }
            
      
        return response()->json(
            $record
        );            
        //   $bookid = array();
        //   $bookTitle = array();      
        //   $checkmiss = whereNotIn('tag_id',$miss_tag)->get();

        //   return $checkmiss;
        //   for($i=0;$i<count($miss_tag);$i++){
        //         $bookid[$i] = Book::where('tag_id','=',$miss_tag[$i])->value('id');
        //         $bookTitle[$i] = Book::where('tag_id','=',$miss_tag[$i])->value('title');  
            
            
        //             lostbook::create([
        //                 'book_id'=> $bookid[$i],
        //                 'tag_id'=>$miss_tag[$i],
        //                 'title'=> $bookTitle[$i]
        //              ]);                                
        //   }
    }

    public function manage()
    {            
        $sort = request('sort');
        $usedTag = Book::whereNotNull('tag_id')->pluck('tag_id')->toArray();
        $notusedTag = Alltag::whereNotIn('tag_id',$usedTag)->pluck('tag_id')->toArray();  
       
        $paginate = 10;
        if ($sort == null) {
            $books = Book::paginate($paginate);
        } else {
            $books = Book::orderBy($sort)->paginate($paginate);
        }
        $entries = $books->total();
        $start = $books->currentPage() * $paginate - $paginate + 1;
        $end = $books->currentPage() * $paginate;
        if ($end > $entries) {
            $end = $entries;
        }
        $show = "Showing " . $start . " to " . $end . " of " . $entries . " entries";

        return view('books.manage')
                ->with('books', $books)
                ->with('show', $show)
                ->with('sort', $sort)
                ->with('tags',$notusedTag);
    }

    public function search(Request $request)
    {
        // dd($request->all());
        $content = $request->search_content;
        $field = $request->search_field;

        if ($content == null or $content == '')
            $books = Book::all();
        elseif ($field == 'all') {
            $books = Book::where('id', 'like', '%'.$content.'%')
                        ->orWhere('title', 'like', '%'.$content.'%')
                        ->orWhere('type', 'like', '%'.$content.'%')
                        ->orWhere('author', 'like', '%'.$content.'%')
                        ->orWhere('publisher', 'like', '%'.$content.'%')
                        ->orWhere('publicationYear', 'like', '%'.$content.'%')
                        ->orWhere('language', 'like', '%'.$content.'%')
                        ->orWhere('ISBN', 'like', '%'.$content.'%')
                        ->orWhere('description', 'like', '%'.$content.'%')
                        ->get();
        }
        else
            $books = Book::where($field, 'like', '%'.$content.'%')->get();

        return view('books.search', compact('books'));
    }

    public function detail($id)
    {
        $book = Book::find($id);
        return view('books.detail', compact('book'));
    }

    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'tag_id' => 'required|max:255',
            'title' => 'required|max:255',
            'author' => 'nullable|max:255',
            'type' => 'required',
            'publisher' => 'nullable|max:255',
            'publicationYear' => 'nullable|integer',
            'language' => 'nullable|max:255',
            'ISBN' => 'nullable|numeric',
            'description' => 'nullable|max:255',
            'pageNumber' => 'nullable|integer',
            'status' => 'required',
            'image' => 'nullable|image',
        ]);    
       

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
        }
        $data = array(
            'tag_id' => request('tag_id'),
            'title' => request('title'),
            'author' => request('author'),
            'type' => request('type'),
            'publisher' => request('publisher'),
            'publicationYear' => request('publicationYear'),
            'language' => request('language'),
            'ISBN' => request('ISBN'),
            'description' => request('description'),
            'pageNumber' => request('pageNumber'),
            'status' => request('status'),
            'image' => request('image'),
        );
       
        if (request('image') == '') {
            Book::create($data);
        }
        else {
          // In server:
          // $image = request()->file('image');
          // $imageName = $image . "." . $image->getClientOriginalExtension();
          // $imagePath = "uploads/" . $imageName;
          // $fullPath = public_path() . '/storage/uploads';
          // $upload = $image->move($fullPath, $imageName);
            $image = request('image');
            $imagePath = $image->store('uploads', 'public');
            Book::create([                
                'title' => $data['title'],
                'author' => $data['author'],
                'publisher' => $data['publisher'],
                'publicationYear' => $data['publicationYear'],
                'language' => $data['language'],
                'ISBN' => $data['ISBN'],
                'description' => $data['description'],
                'pageNumber' => $data['pageNumber'],
                'type' => $data['type'],
                'status' => $data['status'],
                'image' => $imagePath,
                'tag_id' => $data['tag_id'],
            ]);
        }
        Session::flash('message', 'Book has been added.');
    }

    public function edit($id){
        $validator = Validator::make(request()->all(), [        
            'title' => 'required|max:255',
            'tag_id' =>'required|max:255',
            'author' => 'nullable|max:255',
            'type' => 'required',
            'publisher' => 'nullable|max:255',
            'publicationYear' => 'nullable|integer',
            'language' => 'nullable|max:255',
            'ISBN' => 'nullable|numeric',
            'description' => 'nullable|max:255',
            'pageNumber' => 'nullable|integer',
            'status' => 'required',
            'image' => 'nullable|image',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
        }
        $book = Book::find($id);
        if(request('image')) {
            // Has image before
            if ($book->image) {
                $url = storage_path('app/public/'.$book->image);
                if (file_exists($url)) {
                    unlink($url);
                }
            }
            // In server:
            // $image = request()->file('image');
            // $imageName = $image . "." . $image->getClientOriginalExtension();
            // $imagePath = "uploads/" . $imageName;
            // $fullPath = public_path() . '/storage/uploads';
            // $upload = $image->move($fullPath, $imageName);
            $image = request('image');
            $imagePath = $image->store('uploads', 'public');
            $book->image = $imagePath;
        }
        $book->tag_id = request('tag_id');
        $book->title = request('title');
        $book->author = request('author');
        $book->publisher = request('publisher');
        $book->publicationYear = request('publicationYear');
        $book->language = request('language');
        $book->ISBN = request('ISBN');
        $book->description = request('description');
        $book->type = request('type');
        $book->status = request('status');
        $book->pageNumber = request('pageNumber');
        $book->save();

        Session::flash('message', 'Book has been edited.');
    }

    public function delete($id)
    {
        $book = Book::find($id);
        if ($book->image){
            $url = storage_path('app/public/'.$book->image);
            if (file_exists($url)) {
                unlink($url);
            }
        }
        $book->delete();

        Session::flash('message', 'Book has been deleted.');
    }
    public function track()
    {
      $books = Book::all()->take(5);
      return view('books.track')->with('books', $books);
    }

}
