<?php

/**
 *  @author Jaroslav Krenar
 */

namespace App;

class Book extends \App\Shared\Model {

    /**
     * Table name
     * 
     * @var string
     */
    protected $table = 'book';
    protected $fillable = ['isbn', 'author', 'title', 'rating', 'release_date'];
    protected static $rules = array(
        'isbn' => 'required|string|max:13',
        'author' => 'required|string|max:100',
        'title' => 'required|string|max:100',
        'rating' => 'required|numeric',
        'release_date' => 'required|date',
    );

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Define filter params
     * 
     * @param type $query
     * @param type $params
     * @return type
     */
    public function scopeFilter($query, $params)
    {
        \Illuminate\Support\Facades\Log::debug('Applying filter with params: '.json_encode($params));
        
        if (isset($params['isbn'])) {
            $query->where('isbn', 'LIKE', trim($params['isbn'] . '%'));
        }
        
        if (isset($params['author'])) {
            $query->where('author', 'LIKE', trim($params['author'] . '%'));
        }
        
        if (isset($params['title'])) {
            $query->where('title', 'LIKE', trim($params['title'] . '%'));
        }

        if (isset($params['release_date'])) {
            $dateParts = explode('|', $params['release_date']);
            
            if(count($dateParts) === 2){
                $query->where('release_date','>=',$dateParts[0])
                ->where('release_date','<=',$dateParts[1]);
            }
            else{
                $query->where('release_date','=',$dateParts[0]);
            }
        }
        
        if (isset($params['minimum_rating'])) {
            $query->where('rating','>=', $params['minimum_rating']);
        }

        return $query;
    }
}
