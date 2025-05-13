<?php


namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Models\GameUser;
use App\Models\GameHistory;
use App\Models\PokemonCard;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
  public function userSignUp()
  {
    return view('user.signup');
  }

  public function userLoginPage()
  {
    return view('user.login');
  }

  public function landing()
  {
    return view('user.landing-page');
  }


  //CREATE + ADD GAME USER TO TABLE
  //logic for adding game user to database
  //when a post request is made the function has access to a Request Object
  public function createUser(Request $request)
  {
    // Step 1: Create the game history record for the history table
    // IMPORTANT - This record needs to be created first, because the game_user table needs something to refernece
    $history = GameHistory::create([
      'username' => $request->input('username'),
      'history' => '',
      'wins' => 0,
      'loses' => 0,
    ]);

    
    //ADD DATA WITH VALIDATION
    // // Step 1: Validate the request
    // $validated = $request->validate([
    //   'username' => 'required|string|max:255',
    //   'email' => 'required|email|unique:game_users,email',
    //   'password' => 'required|string|min:6',
    //   'first_name' => 'required|string|max:255',
    //   'last_name' => 'required|string|max:255',
    //   'country'   => 'nullable|string|max:255',
    //   'city'   => 'nullable|string|max:255',
    //   'birthdate_date_format'   => 'nullable|date|max:255',
    //   'birthdate_string_format'   => 'nullable|string|max:255',
    //   'gender'   => 'nullable|string|max:255',
    //   'master_icon_path'   => 'nullable|string|max:255',
    // ]);

    // // Step 2: Create the user
    // GameUser::create($validated);
    

    //Add Data from form to table without validating
    GameUser::create([
      'username'    => $request->input('username'),
      'email'       => $request->input('email'),
      'password'    => bcrypt($request->input('password')), //still hash!
      'first_name'  => $request->input('first_name'),
      'last_name'   => $request->input('last_name'),
      'country'   => $request->input('country'),
      'city'   => $request->input('city'),
      // 'birthdate_date_format'   => $request->input('birthdate_date_format'),
      // 'birthdate_string_format'   => $request->input('birthdate_string_format'),
      'gender'   => $request->input('gender'),
      'master_icon_path'   => $request->input('master_icon_path'),
      'game_history_id' => $history->id, // 🔗 link the user to the game_history table
    ]);


    

    //Redirect Options
    //Use Case Code Examples
    //Redirect to a path	return redirect('/dashboard');
    //Redirect to a full URL	return redirect('https://example.com');
    //Redirect to a named route	return redirect()->route('route.name');
    //Named route with params	return redirect()->route('user.profile', ['id' => 5]);
    //Redirect back (previous page)	return redirect()->back();
    //Redirect with flash message	return redirect('/dashboard')->with('success', 'Action successful!');
    //Redirect with form errors	return redirect()->back()->withErrors($validator)->withInput();
    //Redirect to controller action	return redirect()->action([UserController::class, 'show'], ['id' => 1]);
    $user = GameUser::where('email', $request->input('email'))->first();
    
    //Store data in session
    session(['gameUser' => $user]);
    return redirect("/user/homepage/{$user->uuid}");
  }


  public function loginUser(Request $request)
  {
    $user = GameUser::where('email', $request->input('email'))->first();
    if (!$user) {
      //User not found
      return back()->withErrors(['email' => 'User does not exist.']);
    }

    //Check passwords
    if ($user && Hash::check($request->input('password'), $user->password)) {
      
      //Store data in session
      session(['gameUser' => $user]);
      //Password matches — log in the user
      return redirect("/user/homepage/{$user->uuid}"); // or wherever you want
    } else {
      return back()->withErrors(['email' => 'Invalid credentials.']);
    }

  }


  public function userHomePage($uuid)
  {
    //Logic to select the cards a player has
    //first get player uuid
    $gameUser = GameUser::where('uuid', $uuid)->first();

    //get column with cards
    $userCardsString = $gameUser->cards;

    //process string data - to remove unecessary characters
    $remove = ['[', '"', ' ', ']'];
    $processedStringOfCards =  str_replace($remove, "",  $userCardsString);

    //turn string of cards to an array
    $userCardsArray = explode(',', $processedStringOfCards);

    return view('user.home', ["userCards"=>$userCardsArray, "gameUser" => $gameUser]);
  }

  public function playPage($uuid)
  {
    $gameUser = GameUser::where('uuid', $uuid)->first();
    return view('user.play', []);
  }

  //Send us to page for user to select cards
  public function selectStarterCards($uuid)
  {
    $cards = PokemonCard::take(5)->get();
    return view('user.select-starter-cards', ["cards" => $cards, "userId" => $uuid]);
  }

  //Save selected cards to user record
  public function submitSelectedCards(Request $request, $uuid)
  {
      $gameUser = GameUser::where('uuid', $uuid)->first();

      if (!$gameUser) {
        abort(404, 'Game user not found.');
      }

      //Get the cards input from the request
      //the cards from input is a JSON string or array
      $cards = $request->input('cards'); 

      // If it's a JSON string, decode it
      if (is_string($cards)) {
          $cards = json_decode($cards, true);
      }

      //Update user cards
      $gameUser->cards = $cards; 
      $gameUser->save();

      return redirect("/user/homepage/{$gameUser->uuid}");
  }

  public function battlePage($uuid)
  {
    //Logic to select the cards a player has
    //first get player uuid
    $gameUser = GameUser::where('uuid', $uuid)->first();

    //get column with cards
    $userCardsString = $gameUser->cards;

    //process string data - to remove unecessary characters
    $remove = ['[', '"', ' ', ']'];
    $processedStringOfCards =  str_replace($remove, "",  $userCardsString);

    //turn string of cards to an array
    $userCardsArray = explode(',', $processedStringOfCards);


    //Create an array to store the records from the pokemon_table
    $pokemonCardDetails = [];
    $pokemonMovesAssociativeArray = [];
    $pokemonMovesKeys = [];


    //Then we use the name of the cards to find the records in the pokemon_cards table
    //We are only getting the records of the pokemon the user has in their cards column,
    //therefore anything returned is waht the user has
    foreach($userCardsArray as $userCard)
    {
      array_push($pokemonCardDetails, PokemonCard::where('pokemon_name', $userCard)->first());

    };

    //Convert Json Data to a String and Store in Array
    foreach($pokemonCardDetails as $pokemonCardDetail)
    {
      array_push($pokemonMovesAssociativeArray, json_decode(json_encode($pokemonCardDetail->moveset), true));
    };

    for($i = 0; $i < count($pokemonMovesAssociativeArray); $i++)
    {
      array_push($pokemonMovesKeys, array_keys($pokemonMovesAssociativeArray[$i]));
    }
    

    
    //moveset stores the moves and their damages in json in key/value pairs
    //moveKeys store the names of the moves only
    return view('battle.battle-ground', ['cardDetails' => $pokemonCardDetails, 'moveset' => $pokemonMovesAssociativeArray, 'userCards' => $userCardsArray, 'moveKeys' => $pokemonMovesKeys]);
  }


  public function deckManager($uuid)
  {
    //Logic to select the cards a player has
    //first get player uuid
    $gameUser = GameUser::where('uuid', $uuid)->first();

    //get column with cards
    $userCardsString = $gameUser->cards;

    //process string data - to remove unecessary characters
    $remove = ['[', '"', ' ', ']'];
    $processedStringOfCards =  str_replace($remove, "",  $userCardsString);

    //turn string of cards to an array
    $userCardsArray = explode(',', $processedStringOfCards);
    Log::info($userCardsArray);

    //send to view
    return view('user.deck.hand-deck-manager', ['userCards' => $userCardsArray, 'userId' => $uuid]);
  }


  //Function to remove card from the cards column of the game_user table
  public function removeCardFromHand(Request $request)
  {
    Log::info('Incoming request data:', $request->all());
    
    $cardName = $request->input('userCards');
    $userId   = $request->input('userID');

    //Query
    DB::table('game_users')
    ->where('uuid', $userId)  //find the row with matching UUID
    ->update([
        'cards' => $cardName  //change the value of this column
    ]);

    return response()->json([
      'status' => 'success',
      'message' => 'Cards updated',
    ]);

  }

  public function logout(Request $request)
  {
    $request->session()->invalidate(); //Wipe all session data & regenerate session ID
    $request->session()->regenerateToken(); //Regenerate CSRF token

    return redirect('/'); 

  }
}