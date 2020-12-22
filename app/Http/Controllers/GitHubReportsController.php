<?php

namespace App\Http\Controllers;

use Curl\Curl;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Session;



class GitHubReportsController extends Controller
{
    private $curl;

    public function __construct()
    {
        $this->curl = new Curl();
    }
    
    /**
     * Can't do anything till we oauth in
     *
     * @return void
     */
    public function login()
    {

        if(!empty(Request::get('code'))) {
            $this->curl->setHeader('Accept', 'application/json'); // returns info as an array
            $this->curl->post(env('GH_POST_URL'), array(
                'client_id' => env('GH_CLIENT_ID'),
                'client_secret' => env('GH_CLIENT_SECRET'),
                'code' => Request::get('code'),
            ));

            if ($this->curl->error) {
                echo 'Error: ' . $this->curl->errorCode . ': ' . $this->curl->errorMessage . "\n";
            } else {
                if (isset($this->curl->response->access_token)) {
                    Session::put('accessToken',$this->curl->response->access_token);
                }
                return redirect(route('report.show'))->with('status', 'You are logged in!');;
            }
        } else if(!empty(Request::get('error'))) {
            echo Request::get('error_description');
            echo "<br>";
            echo '<a href="' . Request::get('error_uri') . '">' . Request::get('error_uri') . '</a>';
        } else {
            return redirect(route('login'))->with('status', 'Not able to authorize the app');
        }
    }

    /**
     * Where we can see the report
     *
     * @return void
     */
    public function dashboard()
    {
        if(empty(Session::get('accessToken'))) {
            return redirect(route('login'))->with('status', 'You cannot access this report until you login and authorize it.');
        }

        // TODO: Need to do query here and get results from the database
        $results = DB::table('stars_stats')->select('id', 'repo_id', 'name', 'repo_url', 'description', 'stargazers_count','repo_created_at', 'last_pushed_at')->paginate('20');
        return view('dashboard', compact('results'));
    }

    public function detail($id)
    {
        if(empty(Session::get('accessToken'))) {
            return redirect(route('login'))->with('status', 'You cannot access this report until you login and authorize it.');
        }

        // TODO: Need to do query here and get results from the database
        $result = DB::table('stars_stats')->where('id', $id)->first();
        return view('detail', ['result' => $result]);
    }

    /**
     * Start the process of getting api results and saving to db
     *
     * @return void
     */
    public function runReport() {
        $this->saveStars();

        return redirect(route('report.show'))->with('status', 'Report Updated!');
    }

    /**
     * Query the API
     *
     * @return void
     */
    private function queryStars()
    {
        $this->curl->setHeader('User-Agent', 'LookingForStargazers-jphilapy'); // returns info as an array... github recommends putting username here
        $this->curl->setHeader('Accept', 'application/json'); // returns info as an array for this api, otherwise a string
        $this->curl->setHeader('Accept', 'application/vnd.github.v3+json'); // lock in the api version for stability
        $this->curl->setHeader('Authorization', 'token ' . Session::get('accessToken')); // let us in!

        $this->curl->get('https://api.github.com/search/repositories?q=stars:%3E=10000&sort=stars&order=desc&per_page=101'); // get public repos

        return $this->curl->response->items;
    }

    /**
     * Save api results to the database
     *
     * @return void
     */
    private function saveStars()
    {
        $resp = $this->queryStars();

        foreach ($resp as $record) {

            DB::table('stars_stats')
                ->updateOrInsert(
                    ['repo_id' => $record->id],
                    [
                        'name' => $record->name,
                        'repo_url' => $record->html_url,
                        'description' => $record->description,
                        'stargazers_count' => $record->stargazers_count,
                        'repo_created_at' => date("Y-m-d H:i:s", strtotime($record->created_at)),
                        'last_pushed_at' => date("Y-m-d H:i:s", strtotime($record->pushed_at)),
                    ]
                );
        }

    }
}
