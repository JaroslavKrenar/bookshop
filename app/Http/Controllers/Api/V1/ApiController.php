<?php
/**
 *  @author Jaroslav Krenar
 */

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Requests;

class ApiController extends \App\Http\Controllers\Controller {

    /**
     * Request object 
     * 
     * @var \Illuminate\Http\Request 
     */
    public $request;

    /**
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(\Illuminate\Http\Request $request)
    {
        $this->request = $request;
        
        // you can process another type of data e.g. xml or define another transport layer in routing based on request type
        // xml example:
        /*if($this->request->xml()){
            $this->request->replace($this->processXml($this->request->input())); // parse XML data and place to input
        }*/
    }

    /**
     * API method for searching in books
     * 
     * @return \Symfony\Component\HttpFoundation\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function search()
    {
        $books = \App\Book::filter($this->request->all())->get()->toArray();
        
        return $this->sendResponse(['count' => count($books), 'books' => $books]);
    }

    /**
     * API method for adding new book
     * 
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function create(Request $request)
    {
        $book = new \App\Book($this->request->input());

        $book->save();

        return $this->sendResponse(['id' => $book->id]);
    }

    /**
     * Sends response by request type
     * 
     * @param array $data
     * @return \Symfony\Component\HttpFoundation\Response|\Illuminate\Contracts\Routing\ResponseFactory
     * @throws \Exception
     */
    protected function sendResponse(array $data)
    {
        if ($this->request->ajax() || $this->request->wantsJson()) {
            return response()->json($data);
        }

        // you can define here another response type e.g. XML
        
        throw new \Exception('Unsupported request type');
    }
}
