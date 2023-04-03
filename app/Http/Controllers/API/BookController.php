<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Book;
use Validator;
use App\Http\Resources\BookResource;
use Carbon\Carbon;
   
class BookController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $books = Book::whereRaw('1 = 1');
        $title = $request->query('title') ? trim($request->query('title')) : '';
        if(!empty($title))
        {
            $books = $books->where('title', 'LIKE', '%'.$title.'%');
        }
        $author = $request->query('author') ? trim($request->query('author')) : '';
        if(!empty($author))
        {
            $books = $books->where('author', 'LIKE', '%'.$author.'%');
        }
        $isbn = $request->query('isbn') ? trim($request->query('isbn')) : '';
        if(!empty($isbn))
        {
            $books = $books->where('isbn', '=', $isbn);
        }
        $genre = $request->query('genre') ? trim($request->query('genre')) : '';
        if(!empty($genre))
        {
            $books = $books->where('genre', 'LIKE', '%'.$genre.'%');
        }
        $publishDate = $request->query('publishDate') ? trim($request->query('publishDate')) : '';
        if(!empty($publishDate))
        {
            $books = $books->where('published', '=',  $publishDate);
        }
        $books = $books->orderByRaw('id DESC');
        $limit = $request->query('limit') ? (int) $request->query('limit') : 0;
        if($limit > 0) {
            $books = $books->paginate($limit);
        } else {
            $books = $books->get();
        }
        return response()->json([
            'success' => true,
            'data' => BookResource::collection($books),
            'total' => Book::count(),
            'message' => 'Books retrieved successfully.'
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'title' => 'required',
            'author' => 'required',
            'genre' => 'required',
            'description' => 'required',
            'isbn' => 'required',
            'image' => 'required',
            'published' => 'required',
            'publisher' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $book = Book::create($input);
   
        return $this->sendResponse(new BookResource($book), 'Book created successfully.');
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::find($id);
  
        if (is_null($book)) {
            return $this->sendError('Book not found.');
        }
   
        return $this->sendResponse(new BookResource($book), 'Book retrieved successfully.');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        if($request->has('title') && !empty($request->get('title')))
        {
            $book->title = $request->get('title');
        }
        if($request->has('author') && !empty($request->get('author')))
        {
            $book->author = $request->get('author');
        }
        if($request->has('genre') && !empty($request->get('genre')))
        {
            $book->genre = $request->get('genre');
        }
        if($request->has('description') && !empty($request->get('description')))
        {
            $book->description = $request->get('description');
        }
        if($request->has('isbn') && !empty($request->get('isbn')))
        {
            $book->isbn = $request->get('isbn');
        }
        if($request->has('image') && !empty($request->get('image')))
        {
            $book->image = $request->get('image');
        }
        if($request->has('publisher') && !empty($request->get('publisher')))
        {
            $book->publisher = $request->get('publisher');
        }
        if($request->has('published') && !empty($request->get('published')))
        {
            $book->published = $request->get('published');
        }
        $book->save();
   
        return $this->sendResponse(new BookResource($book), 'Book updated successfully.');
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();
   
        return $this->sendResponse([], 'Book deleted successfully.');
    }
}