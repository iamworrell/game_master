<x-layout>
  {{-- Access Styling --}}
  @vite('resources/css/app.css')
  @php $gameUser = session('gameUser'); @endphp

  <!-- Player List Section -->
  <div class="play-container">
      <h2>Available Players</h2>
      <center>
        <div class="player-card">
          <img src="{{ asset('images/game_master.png') }}" alt="Player Avatar" class="player-avatar">
          <div class="player-info">
              <h3>Computer</h3>
              <a href="/user/{{$gameUser->uuid}}/battle/">
                <button class="challenge-btn">Challenge Computer</button>
              </a>
              
          </div>
        </div>
      </center>

      <div class="players-grid">
          @for ($i = 1; $i <= 10; $i++)
          <div class="player-card">
              <img src="{{ asset('images/wizard.png') }}" alt="Player Avatar" class="player-avatar">
              <div class="player-info">
                  <h3>Player{{$i}}</h3>
                  <p class="record">Wins: {{ rand(10, 100) }} | Losses: {{ rand(5, 50) }}</p>
                  <div class="card-preview">
                      <img src="{{ asset('images/card-placeholder.png') }}" alt="Card 1">
                      <img src="{{ asset('images/card-placeholder.png') }}" alt="Card 2">
                      <img src="{{ asset('images/card-placeholder.png') }}" alt="Card 3">
                  </div>
                  <p class="bio">"Ready to duel and climb the leaderboard!"</p>
                  <button class="challenge-btn">Challenge</button>
              </div>
          </div>
          @endfor
      </div>
  </div>
</x-layout>
