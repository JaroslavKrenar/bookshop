<?php
/**
 *  @author Jaroslav Krenar
 */

class ApiControllerTest extends TestCase {
    /* use \Illuminate\Foundation\Testing\DatabaseMigrations; */ // Resetting the database after eEach test

    const BASE_URL = '/api/v1';

    protected $bookData = [];

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp()
    {
        $faker = Faker\Factory::create();

        $this->bookData = [
            'isbn' => $faker->isbn13,
            'author' => $faker->name,
            'title' => $faker->realText('50'),
            'rating' => $faker->randomFloat(2, 0, 20),
            'release_date' => $faker->date(),
        ];

        parent::setUp();
    }

    protected function getServerParams()
    {
        $headers = [];
        $headers['CONTENT_TYPE'] = 'application/json';
        $headers['Accept'] = 'application/json';

        return $this->transformHeadersToServerVars($headers);
    }

    public function testCreate()
    {
        $this->response = $this->call('POST', self::BASE_URL . '/add-book', [], $cookies = [], $files = [], $this->getServerParams(), json_encode($this->bookData));

        /*$this->seeJson(['id' => true]);*/ /* Skipped due to bug https://github.com/laravel/framework/issues/11068 */
        $this->seeStatusCode(200);
    }
    
    public function testCreateFailed()
    {
        $bookData = $this->bookData;
        
        $bookData['rating'] = 'text'; // incorrect rating
        
        $this->response = $this->call('POST', self::BASE_URL . '/add-book', [], $cookies = [], $files = [], $this->getServerParams(), json_encode($bookData));

        /*$this->seeJson(['message', 'code']);*/ /* Skipped due to bug https://github.com/laravel/framework/issues/11068 */
        $this->seeStatusCode(500);
    }

    public function testSearch()
    {
        $this->response = $this->call('GET', self::BASE_URL . '/search', $parameters = [], $cookies = [], $files = [], $this->getServerParams(), $content = null);

        /*$this->seeJsonStructure(['books' => true, 'count' => true]);*/ /* Skipped due to bug https://github.com/laravel/framework/issues/11068 */
        $this->seeStatusCode(200);
        
        // search by isbn
        $this->response = $this->call('GET', self::BASE_URL . '/search', ['isbn' => $this->bookData['isbn']], $cookies = [], $files = [], $this->getServerParams(), $content = null);
        
        $this->seeStatusCode(200);
        
        // search by author
        $this->response = $this->call('GET', self::BASE_URL . '/search', ['author' => $this->bookData['author']], $cookies = [], $files = [], $this->getServerParams(), $content = null);
        
        $this->seeStatusCode(200);
        
        // search by title
        $this->response = $this->call('GET', self::BASE_URL . '/search', ['title' => $this->bookData['title']], $cookies = [], $files = [], $this->getServerParams(), $content = null);
        
        $this->seeStatusCode(200);
        
        // search by relase date
        $this->response = $this->call('GET', self::BASE_URL . '/search', ['release_date' => $this->bookData['release_date']], $cookies = [], $files = [], $this->getServerParams(), $content = null);
        
        $this->seeStatusCode(200);
        
        // search by rating
        $this->response = $this->call('GET', self::BASE_URL . '/search', ['minimum_rating' => $this->bookData['rating']], $cookies = [], $files = [], $this->getServerParams(), $content = null);
    
        $this->seeStatusCode(200);
    }
}
