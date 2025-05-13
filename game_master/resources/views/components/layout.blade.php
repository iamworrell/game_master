<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Game Master - Home</title>
    
</head>
<body>
  {{-- Access Session Data --}}
  @php $gameUser = session('gameUser'); @endphp

  <!-- Banner -->
  <img class="banner" src="{{ asset('images/game_master.png') }}" alt="Banner">

  {{-- The form is to handle the logout button functionality --}}
  <form method="GET" action="{{ route('game.logout') }}" style="display: inline;">
  @csrf
    <!-- Navigation -->
    <nav class="nav-bar">
      <a href="/user/homepage/{{$gameUser->uuid}}">Home</a>
      <a href="/user/profile/">Profile</a>
      <a href="/user/player-cards/">Player Cards</a>
      <a href="/user/play/{{ $gameUser->uuid }}">Play</a>
      <a href="/settings">Settings</a>

      <!-- Logout as a POST form -->
      <a>
        <button type="submit">
          Logout
        </button>
      </a>
      
    </nav>
  </form>
    {{ $slot }}
  
</body>
</html>