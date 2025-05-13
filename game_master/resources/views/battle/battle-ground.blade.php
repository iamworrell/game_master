<x-layout>
  {{-- Access Styling --}}
  @vite('resources/css/battle.css')
  <div class="overlay"></div>
  <div class="battle-container">
    <div class="battle-ground">
      <div class="battle-card player" id="playerCard">
        <img class="active-card" id="playerCardImg" src="https://via.placeholder.com/150x210?text=Your+Card" alt="Player Card" />
      </div>
      <div class="vs">VS</div>
      <div class="battle-card opponent" id="opponentCard">
        <div class="health-bar">
          <div class="health-fill" id="opponentHealthFill" style="width: 100%;"></div>
        </div>
        <img class="active-card" id="opponentCardImg" src="{{ asset('images/cards/spearow.png') }}"  alt="Opponent Card" />
        <div class="damage" id="damageText"></div>
      </div>
    </div>

    <div class="bottom-container">
      <div class="hand-container">
        <div class="hand-section">
          <h2>Your Hand</h2>
          <div class="hand-cards" id="handCards">
            @for ($i = 0; $i < count($cardDetails); $i++)
              {{-- store card attack and damage in json format --}}
              <div class="hand-card" data-name="{{ $cardDetails[$i]->pokemon_name }}" data-hp="{{ $cardDetails[$i]->hit_points }}" data-type="{{ $cardDetails[$i]->pokemon_type }}" data-attacks='@json(["name" => $moveKeys[$i][0],"damage" => $moveset[$i][$moveKeys[$i][0]]])'>
                <img src="{{ asset('images/cards/' . $cardDetails[$i]->pokemon_name . '.png') }}" alt="Card" />
              </div>
            @endfor
          </div>
        </div>
        <div class="decision-section choose-button" id="decisionSection">Choose</div>
        <div class="action-buttons hidden" id="actionButtons"></div>
      </div>
      <div class="details-section" id="detailsSection">
        <h2>Details</h2>
        <p><strong>Name:</strong> <span id="cardName">-</span></p>
        <p><strong>HP:</strong> <span id="cardHp">-</span></p>
        <p><strong>Type:</strong> <span id="cardType">-</span></p>
        <div><strong>Attacks:</strong>
          <ul id="cardAttacks"></ul>
        </div>
      </div>
    </div>
  </div>

  <div class="modal" id="moveModal">
    <div class="modal-content">
      <h2>Choose Your Move</h2>
      <ul id="moveList">
        {{-- <li class="move" data-damage="20">Flamethrower - 20 damage</li>
        <li class="move" data-damage="10">Bite - 10 damage</li>
        <li class="move" data-damage="30">Skull Bash - 30 damage</li> --}}
      </ul>
    </div>
  </div>

  <script>
    

    const handCards       = document.querySelectorAll('.hand-card');
    const decisionSection = document.getElementById('decisionSection');
    const actionButtons   = document.getElementById('actionButtons');
    const details         = {
      name: document.getElementById('cardName'),
      hp:   document.getElementById('cardHp'),
      type: document.getElementById('cardType'),
      attacks: document.getElementById('cardAttacks'),
    };
    const moveModal       = document.getElementById('moveModal');
    const moveList        = document.getElementById('moveList');
    const damageText      = document.getElementById('damageText');
    const opponentHealthFill = document.getElementById('opponentHealthFill');
    const playerCardImg   = document.getElementById('playerCardImg');
    const playerCard      = document.getElementById('playerCard');

    let selectedCardData    = null;
    let battleCardData      = null;
    let handSelectedElement = null;
    let battleSelectedElement = null;
    let opponentHealth      = 60;

    //cycle through all the cards in players hands
    handCards.forEach(card => {
      card.addEventListener('click', () => {
        // hide attack/withdraw while choosing or switching
        actionButtons.classList.add('hidden');
        decisionSection.style.display = 'block';

        const isSame = battleCardData && card.dataset.name === battleCardData.name;
        handCards.forEach(c => c.classList.remove('selected'));
        if (isSame && handSelectedElement === card) {
          handSelectedElement = null;
          selectedCardData    = null;
          decisionSection.textContent = 'Choose';
          decisionSection.classList.remove('active');
          return;
        }

        card.classList.add('selected');
        handSelectedElement = card;
        selectedCardData = {
          name:    card.dataset.name,
          hp:      card.dataset.hp,
          type:    card.dataset.type,
          //convert string into a javascript object
          attacks: JSON.parse(card.dataset.attacks),
          image:   card.querySelector('img').src
        };

        // fill details panel
        details.name.textContent    = selectedCardData.name;
        details.hp.textContent      = selectedCardData.hp;
        details.type.textContent    = selectedCardData.type;
        details.attacks.innerHTML   = selectedCardData.attacks.name +" " + selectedCardData.attacks.damage;
        

        //Add moves to Move Box
        
        const li = document.createElement('li');
        li.textContent = selectedCardData.attacks.name;
        li.className = 'move';
        li.dataset.damage = selectedCardData.attacks.damage;
        moveList.appendChild(li);

        // decide button text
        if (!battleCardData) {
          decisionSection.textContent = 'Select';
        } else {
          decisionSection.textContent = isSame ? 'Choose' : 'Switch';
        }
        decisionSection.classList.add('active');
      });
    });

    

    

    decisionSection.addEventListener('click', () => {
      if (!decisionSection.classList.contains('active') || !selectedCardData) return;
      const action = decisionSection.textContent;

      if (action === 'Select') {
        // place first card
        playerCardImg.src        = selectedCardData.image;
        battleCardData           = selectedCardData;
        battleSelectedElement    = handSelectedElement;
        decisionSection.style.display = 'none';
        actionButtons.innerHTML = `
          <button id="attackBtn" class="disabled">Attack</button>
          <button id="withdrawBtn" class="disabled">Withdraw</button>`;
        actionButtons.classList.remove('hidden');
      }
      else if (action === 'Switch') {
        
        performSwitch(battleSelectedElement, selectedCardData);
      }
    });

    playerCard.addEventListener('click', (e) => {
    console.log("Hermes" + e.target)
    console.log(selectedCardData.attacks.name)
      if (!battleCardData) return;
      actionButtons.querySelectorAll('button').forEach(btn => btn.classList.remove('disabled'));
    });

    actionButtons.addEventListener('click', e => {
      if (e.target.classList.contains('disabled')) return;
      if (e.target.id === 'withdrawBtn') {
        // reset
        playerCardImg.src = 'https://via.placeholder.com/150x210?text=Your+Card';
        battleCardData      = null;
        battleSelectedElement = null;
        actionButtons.innerHTML = '';
        actionButtons.classList.add('hidden');
        decisionSection.style.display = 'block';
        decisionSection.textContent   = 'Choose';
        decisionSection.classList.remove('active');
        details.name.textContent    = '-';
        details.hp.textContent      = '-';
        details.type.textContent    = '-';
        details.attacks.innerHTML   = '';
        handCards.forEach(c => c.classList.remove('selected'));

        //reset move box on withdraw
        moveList.textContent = "";
      }
      if (e.target.id === 'attackBtn') {
        moveModal.style.display = 'flex';
      }
    });

    moveModal.addEventListener('click', e => {
      if (e.target === moveModal) moveModal.style.display = 'none';
    });

    moveList.addEventListener('click', e => {
      if (!e.target.classList.contains('move')) return;
      const damage = parseInt(e.target.dataset.damage, 10);
      moveModal.style.display = 'none';
      animateAttack(damage);
    });

    function animateAttack(dmg) {
      const dist = 200;
      playerCardImg.style.transition = 'transform 0.4s ease';
      playerCardImg.style.transform = `translateX(${-dist}px)`;
      setTimeout(() => {
        playerCardImg.style.transition = 'transform 0.2s cubic-bezier(0.34,1.56,0.64,1)';
        playerCardImg.style.transform = 'translateX(0)';
        damageText.textContent = `-${dmg}`;
        damageText.classList.add('animate');

        //calculate what is left of opponent's health bar
        opponentHealth = Math.max(0, opponentHealth - dmg);

        //update user on status
        if(opponentHealth <= 0)
        {
          console.log('You Win')
        }

        //Width of green fill is dependent on opponent health after calculations
        opponentHealthFill.style.width = `${opponentHealth}%`;
      }, 400);
      setTimeout(() => {
        damageText.classList.remove('animate');
        damageText.textContent = '';
      }, 1200);

      
    }

    function performSwitch(fromElem, newData) {
      const br = playerCardImg.getBoundingClientRect();
      const hr = fromElem.getBoundingClientRect();
      const dx = hr.left + hr.width/2 - (br.left + br.width/2);
      const dy = hr.top  + hr.height/2 - (br.top  + br.height/2);

      const clone = playerCardImg.cloneNode();
      Object.assign(clone.style, {
        position: 'fixed',
        left:     `${br.left}px`,
        top:      `${br.top}px`,
        width:    `${br.width}px`,
        height:   `${br.height}px`,
        zIndex:   '999',
        transition: 'transform 0.6s ease, opacity 0.6s ease'
      });
      document.body.append(clone);
      playerCardImg.style.opacity = '0';

      requestAnimationFrame(() => {
        clone.style.transform = `translate(${dx}px, ${dy}px)`;
        clone.style.opacity   = '0';
      });

      clone.addEventListener('transitionend', () => {
        clone.remove();
        playerCardImg.style.opacity = '1';
        playerCardImg.src           = newData.image;
        battleCardData              = newData;
        battleSelectedElement       = handSelectedElement;
        decisionSection.style.display = 'none';
        actionButtons.innerHTML = `
          <button id="attackBtn" class="disabled">Attack</button>
          <button id="withdrawBtn" class="disabled">Withdraw</button>`;
        actionButtons.classList.remove('hidden');
      });
      
    }
  </script>
</x-layout>
</html>
