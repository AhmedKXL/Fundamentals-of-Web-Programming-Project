const colors = ['red', 'blue', 'green', 'yellow', 'orange', 'purple', 'pink', 'cyan'];
const board = [...colors, ...colors]; // Duplicate colors for pairs
let firstCard = null;
let secondCard = null;
let lockBoard = false;
let score = 0;
let matchedPairs = 0; // Track matched pairs
let timer = setInterval(updateScore, 1000);

function shuffle(array) {
    return array.sort(() => Math.random() - 0.5);
}

function createBoard() {
    const gameBoard = document.getElementById('game-board');
    shuffle(board).forEach(color => {
        const card = document.createElement('div');
        card.classList.add('card');
        card.dataset.color = color;
        card.addEventListener('click', flipCard);
        gameBoard.appendChild(card);
    });
}

function flipCard() {
    if (lockBoard || this.classList.contains('flipped')) return;

    this.classList.add('flipped');
    this.style.backgroundColor = this.dataset.color;

    if (!firstCard) {
        firstCard = this;
    } else {
        secondCard = this;
        checkForMatch();
    }
}

function checkForMatch() {
    lockBoard = true;
    if (firstCard.dataset.color === secondCard.dataset.color) {
        matchedPairs++;
        resetCards();
        // Check if all pairs are matched
        if (matchedPairs === colors.length) {
            gameOver();
        }
    } else {
        setTimeout(() => {
            // Flip cards back if they do not match
            firstCard.classList.remove('flipped');
            firstCard.style.backgroundColor = '#ccc';
            secondCard.classList.remove('flipped');
            secondCard.style.backgroundColor = '#ccc';
            resetCards();
        }, 1500);
    }
}

function resetCards() {
    [firstCard, secondCard] = [null, null];
    lockBoard = false;
}

function updateScore() {
    score++;
    document.getElementById('timer').textContent = `${score}`;
}

function gameOver() {
    clearInterval(timer);
    sendResult(4, score);       // Must use correct id from games table
    alert('Congratulations! You matched all pairs! Your time score: ' + score);
}

function sendResult(game_id, score) {
    const formData = new FormData();
    formData.append("score", score);
    formData.append("game_id", game_id);
    fetch("../php/save_score.php", {method: "POST", body: formData});
}

createBoard();
