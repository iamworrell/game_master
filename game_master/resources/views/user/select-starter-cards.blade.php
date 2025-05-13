<x-layout>
  {{-- Access Styling --}}
  @vite('resources/css/app.css')
  <div class="select-starter-cards">
    <h1>Choose Your Starter Cards</h1>
  
    <div class="card-grid" id="cardGrid">
      @foreach ($cards as $card)
        <div class="card-box" onclick="toggleSelect(this, '{{ $card->pokemon_name }}')">
          <div class="check-circle hidden">✔</div>
          <img src="{{ asset('images/cards/' . $card->pokemon_name . '.png') }}" alt="{{ $card->pokemon_name }}">
        </div>
      @endforeach
    </div>
  
    <form id="cardForm" method="POST" action="/user/{{$userId}}/select-starter-card">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" name="cards" id="cardsInput">
      <button class="submit-btn" type="submit">Confirm Selection</button>
    </form>
  </div>
  
  <script>
    const selectedCards = [];
  
    function toggleSelect(cardElement, cardName) {
      const checkmark = cardElement.querySelector('.check-circle');
      const isSelected = !checkmark.classList.contains('hidden');
  
      if (isSelected) {
        checkmark.classList.add('hidden');
        const index = selectedCards.indexOf(cardName);
        if (index !== -1) selectedCards.splice(index, 1);
      } else {
        checkmark.classList.remove('hidden');
        selectedCards.push(cardName);
      }
    }
  
    const form = document.getElementById('cardForm');
    form.addEventListener('submit', function () {
      document.getElementById('cardsInput').value = JSON.stringify(selectedCards);
    });
  </script>
</x-layout>
