const gameBoard = document.getElementById('game-board');
const savingsDisplay = document.getElementById('savings-display');
const timerDisplay = document.getElementById('timer');
const statusMessage = document.getElementById('status-message');
const startButton = document.getElementById('start-btn');

const GRID_SIZE = 16;
let savings = 500; // Start with some savings
let timeLeft = 60;
let gameInterval;
let spawnInterval;
let isGameActive = false;
let cells = [];

// Item definitions
const ITEMS = {
    INCOME: { type: 'income', icon: '💵', value: 150, text: "+$150 Income!" },
    BILL:   { type: 'bill',   icon: '🧾', value: -100, penalty: -300, text: "Bill Paid -$100" },
    LUXURY: { type: 'luxury', icon: '💎', value: -200, text: "Impulse Buy -$200!" }
};

function initGame() {
    createBoard();
    resetStats();
    statusMessage.innerText = "Earn Income, Pay Bills, Ignore Luxuries!";
    statusMessage.style.color = "white";
    startButton.innerText = "Start Budgeting";
    startButton.onclick = startGame;
}

function resetStats() {
    savings = 500;
    timeLeft = 60;
    updateUI();
    clearInterval(gameInterval);
    clearInterval(spawnInterval);
    isGameActive = false;
}

function createBoard() {
    gameBoard.innerHTML = '';
    cells = [];
    for (let i = 0; i < GRID_SIZE; i++) {
        const cell = document.createElement('div');
        cell.classList.add('cell');
        cell.dataset.index = i;
        cell.addEventListener('mousedown', () => handleCellClick(cell)); // mousedown for faster reaction
        gameBoard.appendChild(cell);
        cells.push({ element: cell, item: null, timeout: null });
    }
}

function startGame() {
    if (isGameActive) return;
    resetStats();
    isGameActive = true;
    startButton.innerText = "Running...";
    statusMessage.innerText = "GO!";
    
    // Game Timer
    gameInterval = setInterval(() => {
        timeLeft--;
        updateUI();
        if (timeLeft <= 0) endGame(true);
    }, 1000);

    // Spawn Items Loop (speeds up over time)
    spawnItem();
    spawnInterval = setInterval(spawnItem, 700);
}

function spawnItem() {
    if (!isGameActive) return;

    // Find empty cells
    const emptyIndices = cells
        .map((c, i) => c.item === null ? i : null)
        .filter(i => i !== null);

    if (emptyIndices.length === 0) return;

    const randIndex = emptyIndices[Math.floor(Math.random() * emptyIndices.length)];
    const cellData = cells[randIndex];

    // Determine type (50% Income, 30% Luxury, 20% Bill)
    const randType = Math.random();
    let typeObj;
    
    if (randType < 0.5) typeObj = ITEMS.INCOME;
    else if (randType < 0.8) typeObj = ITEMS.LUXURY;
    else typeObj = ITEMS.BILL;

    // Apply to cell
    cellData.item = typeObj;
    cellData.element.classList.add(typeObj.type);
    cellData.element.innerText = typeObj.icon;

    // Set lifespan (Bills last longer because you MUST click them)
    const lifespan = typeObj.type === 'bill' ? 2500 : 1500;

    cellData.timeout = setTimeout(() => {
        // If it was a BILL and it expired -> PENALTY
        if (cellData.item && cellData.item.type === 'bill') {
            savings += ITEMS.BILL.penalty;
            statusMessage.innerText = "Missed Bill! Late Fee -$300";
            statusMessage.style.color = "#ff4757";
            flashCell(cellData.element, 'expired');
        }
        clearCell(randIndex);
        updateUI();
    }, lifespan);
}

function handleCellClick(element) {
    if (!isGameActive) return;
    
    const index = parseInt(element.dataset.index);
    const cellData = cells[index];
    
    if (!cellData.item) return; // Empty cell clicked

    const type = cellData.item.type;

    // Logic based on type
    if (type === 'income') {
        savings += ITEMS.INCOME.value;
        statusMessage.innerText = ITEMS.INCOME.text;
        statusMessage.style.color = "#2ed573";
    } 
    else if (type === 'bill') {
        savings += ITEMS.BILL.value; // It costs money to pay bills
        statusMessage.innerText = ITEMS.BILL.text;
        statusMessage.style.color = "#ffa502";
    } 
    else if (type === 'luxury') {
        savings += ITEMS.LUXURY.value; // Bad choice
        statusMessage.innerText = ITEMS.LUXURY.text;
        statusMessage.style.color = "#ff4757";
    }

    // Clear immediately after click
    clearTimeout(cellData.timeout);
    clearCell(index);
    updateUI();
}

function clearCell(index) {
    const cellData = cells[index];
    cellData.item = null;
    cellData.element.className = 'cell'; // Remove all type classes
    cellData.element.innerText = '';
}

function flashCell(element, cssClass) {
    element.classList.add(cssClass);
    setTimeout(() => {
        if(element.classList.contains(cssClass)) {
             element.classList.remove(cssClass);
        }
    }, 200);
}

function updateUI() {
    savingsDisplay.innerText = `$${savings}`;
    timerDisplay.innerText = `${timeLeft}s`;
    
    // Change color if in debt
    if (savings < 0) {
        savingsDisplay.style.color = "#ff4757";
    } else {
        savingsDisplay.style.color = "#2ed573";
    }

    if (savings <= -500) {
        endGame(false); // Bankruptcy
    }
}

function endGame(timeUp) {
    isGameActive = false;
    clearInterval(gameInterval);
    clearInterval(spawnInterval);
    
    // Clear board
    cells.forEach((c, i) => {
        clearTimeout(c.timeout);
        clearCell(i);
    });

    if (timeUp) {
        statusMessage.innerText = `Time's Up! Final Savings: $${savings}`;
    } else {
        statusMessage.innerText = "Bankruptcy! Game Over.";
    }
    
    startButton.innerText = "Try Again";
}

// Initialize
initGame();