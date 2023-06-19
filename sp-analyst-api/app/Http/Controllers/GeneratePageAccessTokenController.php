<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFBInstPageAccessToken;
use App\Models\StoreFacebookAccessToken;
use App\Models\StoreFacebookLongAccessToken;
use App\Models\StoreFacebookPageAccessToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class GeneratePageAccessTokenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // GET FACEBOOK PAGE ACCESS TOKEN
    public function getfacebookpageaccesstoken()
    
    {  

        $user_id = auth('sanctum')->user();
        $facebook_long_access_token = StoreFacebookLongAccessToken::where('client_id', $user_id->client_id)->first();
        $user_page_info_id = $facebook_long_access_token->facebook_userdetails->facebook_user_id;
        $facebook_long_access_token = $facebook_long_access_token->long_lived_access_token;
        // return response()->json([
        //   $user_page_info_id
        // ]);
        $php_curl = curl_init();

        curl_setopt_array($php_curl, array(
            CURLOPT_URL => "https://graph.facebook.com/$user_page_info_id/accounts?access_token=$facebook_long_access_token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 1000,

            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Laravel curl Requesred Headers
                'Content-Type: application/json',
            ),
        ));
        $final_results = curl_exec($php_curl);
        $err = curl_error($php_curl);
        $err = curl_error($php_curl);
        curl_close($php_curl);

        if ($err) {
            echo "Laravel cURL Error #:" . $err;
        } else {

               $page_data = json_decode($final_results);

               return response()->json([
                "facebook_page_access_token"=> $page_data->data
               ]);



                
        }

        //   $user_id = auth('sanctum')->user();
        //  $facebook_long_access_token = StoreFacebookLongAccessToken::where('client_id', $user_id->client_id)->first();
        //   $user_page_info_id = $facebook_long_access_token->facebook_userdetails->facebook_user_id;
        //  $facebook_long_access_token = $facebook_long_access_token->long_lived_access_token;

        //  $api_url = "https://graph.facebook.com/$user_page_info_id/accounts?access_token=$facebook_long_access_token";

        //  $response = Http::withHeaders([])->get($api_url);

       

        // $quizzes = json_decode($response->body());
        // foreach($quizzes as $quiz){
        //         $question = new StoreFBInstaPageAccessToken;
        //         $question->page_name = $quiz['name'];
        //         $question->access_token = $quiz['access_token'];
        //         $question->page_category = $quiz['category'];
        //         $question->save();
        // }
        // return "DONE";
            
        
    }

     // STORE FACEBOOK PAGE ACCESS TOKEN
    public function StoreFBPageAccessToken(StoreFBInstPageAccessToken $request) {
          $request->validated($request->all());
           
           $store_page_access_token =  StoreFacebookPageAccessToken::create([
          'user_id'=> Auth::user()->id,
          'client_id'=> Auth::user()->client_id,
          'page_name'=>$request->page_name,
          'access_token'=>$request->access_token,
          'page_category'=>$request->page_category,
          'page_id'=>$request->page_id,
        ]);

        return response()->json([
            'status'=>200,
            'message'=>"Page access linked successfully",
            'store_page_access_token' => $store_page_access_token
        ]);

    }

    public function getFacebookPageId(){
        $user_id = auth('sanctum')->user();
        $facebook_page_id = StoreFacebookPageAccessToken::where('client_id', $user_id->client_id)->get();

        return response()->json([
            'facebook_page_id'=> $facebook_page_id
        ]);
    }

    public function getFacebookPageAccessDetails(){

         $user_id = auth('sanctum')->user();
        $facebook_page_details = StoreFacebookPageAccessToken::where('client_id', $user_id->client_id)->get();

        return response()->json([
            'facebook_page_details'=> $facebook_page_details
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
