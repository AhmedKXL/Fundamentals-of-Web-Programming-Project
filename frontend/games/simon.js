const gameBoard = document.getElementById('game-board');
const levelIndicator = document.getElementById('level-indicator');
const statusMessage = document.getElementById('status-message');
const startButton = document.getElementById('start-btn');
const pads = document.querySelectorAll('.pad');

let sequence = [];
let playerSequence = [];
let level = 0;
let isGameActive = false;

// Colors mapping
const colors = ['green', 'red', 'yellow', 'blue'];

function initGame() {
    sequence = [];
    playerSequence = [];
    level = 0;
    isGameActive = true;
    levelIndicator.innerText = 1;
    statusMessage.innerText = "Watch closely...";
    statusMessage.style.color = "white";
    
    startButton.innerText = "Restart";
    nextRound();
}

function nextRound() {
    level++;
    levelIndicator.innerText = level;
    playerSequence = [];
    
    // Add random color
    const randomColor = colors[Math.floor(Math.random() * 4)];
    sequence.push(randomColor);

    // Play sequence
    playSequence();
}

function playSequence() {
    isGameActive = false; // Disable input
    gameBoard.classList.add('unclickable');
    statusMessage.innerText = "Watch...";

    let delay = 0;
    
    sequence.forEach((color, index) => {
        setTimeout(() => {
            flashPad(color);
        }, delay);
        // Delay between flashes (speed up as levels go high)
        delay += 600; 
    });

    // Re-enable input after sequence finishes
    setTimeout(() => {
        isGameActive = true;
        gameBoard.classList.remove('unclickable');
        statusMessage.innerText = "Your Turn!";
    }, delay);
}

function flashPad(color) {
    const pad = document.querySelector(`.pad.${color}`);
    pad.classList.add('active');
    
    // Remove class after 300ms
    setTimeout(() => {
        pad.classList.remove('active');
    }, 300);
}

function handlePadClick(e) {
    if (!isGameActive) return;

    const selectedColor = e.target.dataset.color;
    if (!selectedColor) return;

    // Visual feedback for click
    flashPad(selectedColor);
    
    // Add to player sequence
    playerSequence.push(selectedColor);

    // Check logic
    checkInput(playerSequence.length - 1);
}

function checkInput(currentIndex) {
    if (playerSequence[currentIndex] !== sequence[currentIndex]) {
        gameOver();
        return;
    }

    // If sequence is complete
    if (playerSequence.length === sequence.length) {
        isGameActive = false;
        statusMessage.innerText = "Good job!";
        setTimeout(nextRound, 1000);
    }
}

function gameOver() {
    isGameActive = false;
    statusMessage.innerText = "Game Over!";
    statusMessage.style.color = "#ff4757";
    sendResult(9, level);
    // Flash background red
    document.body.style.backgroundColor = "#500";
    setTimeout(() => {
        document.body.style.backgroundColor = ""; // Reset
    }, 200);

    startButton.innerText = "Try Again";
}

function sendResult(game_id, score) {
    const formData = new FormData();
    formData.append("score", score);
    formData.append("game_id", game_id);
    fetch("../php/save_score.php", {method: "POST", body: formData});
}

// Event Listeners
pads.forEach(pad => {
    pad.addEventListener('click', handlePadClick);
});

startButton.addEventListener('click', initGame);