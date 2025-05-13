<x-layout>
  {{-- Access Styling --}}
  @vite('resources/css/app.css')
  
  <div class="homepage">

  
    <!-- Main Content -->
    <div class="main-content">
        <!-- Left Panel -->
        <div class="left-panel">
          
            <img class="avatar" src="{{ asset('images/avatar/' . $gameUser->master_icon_path . '.png') }}" alt="Player Avatar">
          
            
            <p><strong>Welcome Player, {{ $gameUser->username }}</strong></p>
        </div>

        <!-- Center Dashboard -->
        <div class="center-panel">
          <a class="dashboard-box box-large" href="/user/deck-manager/{{$gameUser->uuid}}">
            <div>
              <img class="deck-image" src="{{ asset('images/deck.png') }}">
              <div class="naming-block">
                <div class="image-text">My Deck</div>
              </div>
                
              
              
            </div>
          </a>
          
          
          <div class="dashboard-box box-small">Leaderboard</div>
          <div class="dashboard-box box-small">Achievements</div>
          <div class="dashboard-box box-medium">Battle Log</div>
          <div class="dashboard-box box-small">Daily Rewards</div>
          <div class="dashboard-box box-small">Events</div>
        </div>

        <!-- Right Panel -->
        <div class="right-panel">
            <div class="panel-section">
                <h3>News</h3>
                <p>New tournament starts Friday!</p>
                <p>Patch 1.4 adds 10 new cards.</p>
            </div>

            <div class="panel-section">
                <h3>FAQs</h3>
                <p>How to earn points?</p>
                <p>What are rarity levels?</p>
            </div>

            <div class="panel-section">
                <h3>Contact</h3>
                <p>Email: support@gameapp.com</p>
                <p>Discord: GameAppServer</p>
            </div>
        </div>
    </div>
  </div>

  {{-- Prompt player to select starter cards if first login --}}
  @if ($userCards[0] == "")
    <!-- Overlay + Modal -->
    <div class="overlay" id="emptyDeckModal">
      <div class="modal-card">
        <h2>Your Deck Is Empty</h2>
        <p>Your current deck is empty. Please select starter cards to begin your journey!</p>
        <a href="/user/{{$gameUser->uuid}}/select-starter-card">
          <button class="btn">
            Select Starter Cards
          </button>
        </a>
      </div>
    </div>
  @else
    
  @endif
  
</x-layout>