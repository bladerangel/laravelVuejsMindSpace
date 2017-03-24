<?php

namespace App\Http\Controllers;

use App\Quote;
use Illuminate\Http\Request;
use JWTAuth;

class QuoteController extends Controller
{
    public function postQuote(Request $request)
    {

        /*if (!$user = JWTAuth::parseToken()->authenticate()) {
            $response = ['message' => 'User not found!'];
            return response()->json($response, 404);
        } middleware jwt.auth*/

        $user = JWTAuth::parseToken()->toUser();
        $quote = new Quote();
        $quote->content = $request->input('content');
        $quote->save();
        $response = ['quote' => $quote, 'user' => $user];
        return response()->json($response, 201);
    }

    public function getQuotes()
    {
        $quotes = Quote::all();
        $response = ['quotes' => $quotes];
        return response()->json($response, 200);
    }

    public function putQuote(Request $request, $id)
    {
        $quote = Quote::find($id);
        if (!$quote) {
            $response = ['message' => 'Document not found'];
            return response()->json($response, 404);
        }
        $quote->content = $request->input('content');
        $quote->save();
        $response = ['quote' => $quote];
        return response()->json($response, 200);
    }

    public function deleteQuote($id)
    {
        $quote = Quote::find($id);
        $quote->delete();
        $response = ['message' => 'Quote deleted'];
        return response()->json($response, 200);
    }
}
