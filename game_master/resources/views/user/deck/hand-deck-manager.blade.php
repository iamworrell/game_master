<x-layout>
  {{-- Access Styling --}}
  @vite('resources/css/app.css')
  @php $gameUser = session('gameUser'); @endphp
  
  <div class="card-manager-page">
    <div class="player-section">
      <img src="{{ asset('images/avatar/' . $gameUser->master_icon_path . '.png') }}" alt="Player Avatar" class="player-avatar">
      <div class="player-menu">
        <button class="menu-btn hand" id="menu-btn">Hand</button>
        <button class="menu-btn deck" id="menu-btn">Deck</button>
      </div>
    </div>
  
    <div class="select-card-section">
      <h2 class="section-title" id="hand-title">Your Hand</h2>
      <div class="hand-cards-container">
        <div id="js-hand-cards" class="hand-cards">
          <!-- JS will populate this -->
        </div>
      </div>
    
      <button class="action-btn" id="actionBtn" disabled>Choose</button>
    
      <h2 class="section-title" id="deck-title">Deck</h2>
      <div class="deck-cards-container">
        <div class="deck-cards">
          @for ($i = 0; $i < 50; $i++)
          <div class="card-box-deck" onclick="selectCard(this, '{{ $i }}', 'deck')">
            <img src="{{ asset('images/cards/caterpie.png') }}" alt="Card">
          </div>
          @endfor
        </div>
      </div>
    </div>
  
    <div class="other-section">
      <div class="obtain-card-tile">
        <p>Discover more powerful cards to enhance your deck.</p>
        <button class="obtain-btn">Obtain Cards</button>
      </div>
      <div class="new-cards">
        <img src="{{ asset('images/new-card1.png') }}" alt="New Card">
        <img src="{{ asset('images/new-card2.png') }}" alt="New Card">
        <img src="{{ asset('images/new-card3.png') }}" alt="New Card">
      </div>
    </div>
  </div>
  <script>
    console.log("Items")
    
    let selectedCard = null;
    const buttons = document.querySelectorAll('.menu-btn');
    const chooseBtn = document.getElementById('actionBtn');
    const deckContainer = document.querySelector('.deck-cards-container');
    const handTitle = document.getElementById('hand-title');
    const deckTitle = document.getElementById('deck-title');
  
    function resetSelection() {
      if (selectedCard) {
        selectedCard.classList.remove('selected');
        selectedCard = null;
      }
      chooseBtn.textContent = 'Choose';
      chooseBtn.classList.remove('selected');
      chooseBtn.disabled = true;
    }
  
    function selectCard(cardElement, id, type) {
      if (selectedCard === cardElement) {
        // unselect
        resetSelection();
      } else {
        // deselect old, select new
        if (selectedCard) selectedCard.classList.remove('selected');
        selectedCard = cardElement;
        selectedCard.classList.add('selected');
        chooseBtn.textContent = type === 'hand' ? 'Remove' : 'Add';
        chooseBtn.classList.add('selected');
        chooseBtn.disabled = false;
      }
    }
  
    buttons.forEach(button => {
      button.addEventListener('click', () => {
        buttons.forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');
  
        const isHand = button.classList.contains('hand');
  
        // Toggle visibility
        handContainer.classList.toggle('hidden', !isHand);
        handTitle.classList.toggle('hidden', !isHand);
        deckTitle.textContent = isHand ? 'Deck' : 'Your Deck'; // Adjusted title
  
        // Move deck up if hand hidden
        deckContainer.classList.toggle('hidden', false);
  
        // Reset selection
        resetSelection();
      });
    });


    //convert php variable into javascript
    const items = @json($userCards);
    const id = @json($userId);
    console.log(items[0])

    //Grab the container
    const handContainer = document.getElementById('js-hand-cards');

    //Render function
    function renderItems() {
    handContainer.innerHTML = ''; // clear container

    items.forEach((cardName, i) => {
        const wrapper = document.createElement('div');
        wrapper.className = 'card-box-hand';

        //store card name in element as a dataset
        wrapper.dataset.card = cardName;

        //Get selected card data from hand
        wrapper.addEventListener('click', () => {
            const cardValue = wrapper.dataset.card;
            console.log(cardValue);

            //get the name of the card to remove
            nameOfCardToRemove = cardValue;
        });

        //call selectCard function on click
        wrapper.setAttribute('onclick', `selectCard(this, '${i}', 'hand')`);

        //create image tag
        const img = document.createElement('img');
        img.src = "{{ asset('images/cards') }}/" + cardName + ".png";
        img.alt = "Card";

        //add image tag to wrapper
        wrapper.appendChild(img);
        handContainer.appendChild(wrapper);
    });
}


    let nameOfCardToRemove = '';

    //Initial render
    renderItems();

    //Remove selected card from hand and then re-render the page
    function removeCardFromHand(nameOfCard) {
      const index = items.indexOf(nameOfCard);
      if (index !== -1) {
          items.splice(index, 1);
      }

      renderItems();
              
    }

    //Add/Remove Button
    chooseBtn.addEventListener('click',  ()=>{
      //Remove Card from Deck
      if(chooseBtn.textContent == 'Remove')
      {
        //remove selected card from deck on screen
        removeCardFromHand(nameOfCardToRemove);
        console.log(nameOfCardToRemove)

        //remove selected card from database
        //Call Fetch API to server
        fetch("{{ route('cards.remove') }}", {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}",
          },
          body: JSON.stringify({ userCards: items, userID: id})
        })
        .then(res => res.json())
        .then(data => {
          if (data.status === 'success') {
            console.log(`Card removed on server: ${data.cardName}`);
          } else {
            console.error('Server failed to remove card');
          }
        })
        .catch(err => {
          console.error('Error:', err);
        });

        //Clear selection
        nameOfCardToRemove = '';



      }

      
    });
    
  </script>
  
  
</x-layout>
</html>