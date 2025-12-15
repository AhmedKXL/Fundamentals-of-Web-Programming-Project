const gameBoard = document.getElementById('game-board');
const mineCountDisplay = document.getElementById('mine-count');
const timerDisplay = document.getElementById('timer');
const statusMessage = document.getElementById('status-message');
const resetButton = document.getElementById('reset');

const SIZE = 10;
const BOMB_COUNT = 12;

let board = [];
let gameOver = false;
let flags = 0;
let time = 0;
let timerInterval = null;
let isFirstClick = true;

function initGame() {
    stopTimer();
    time = 0;
    timerDisplay.innerText = 0;
    flags = 0;
    mineCountDisplay.innerText = BOMB_COUNT;
    gameOver = false;
    isFirstClick = true;
    statusMessage.innerText = "Right Click to Flag Bombs";
    statusMessage.style.color = "white";
    
    createBoard();
}

function startTimer() {
    if (timerInterval) return;
    timerInterval = setInterval(() => {
        time++;
        timerDisplay.innerText = time;
    }, 1000);
}

function stopTimer() {
    clearInterval(timerInterval);
    timerInterval = null;
}

function createBoard() {
    gameBoard.innerHTML = '';
    board = [];

    // Create logical and visual board
    for (let i = 0; i < SIZE * SIZE; i++) {
        const cell = document.createElement('div');
        cell.classList.add('cell', 'covered');
        cell.dataset.id = i;
        
        // Prevent context menu on right click
        cell.addEventListener('contextmenu', (e) => {
            e.preventDefault();
            addFlag(cell);
        });

        cell.addEventListener('click', () => clickCell(cell));
        gameBoard.appendChild(cell);
        
        board.push({
            id: i,
            isBomb: false,
            isRevealed: false,
            isFlagged: false,
            nearbyBombs: 0
        });
    }
}

function generateBombs(excludeIndex) {
    let bombsPlaced = 0;
    while (bombsPlaced < BOMB_COUNT) {
        const rand = Math.floor(Math.random() * (SIZE * SIZE));
        // Don't place bomb on first click or where one already exists
        if (rand !== excludeIndex && !board[rand].isBomb) {
            board[rand].isBomb = true;
            bombsPlaced++;
        }
    }

    // Calculate numbers
    for (let i = 0; i < SIZE * SIZE; i++) {
        if (!board[i].isBomb) {
            const total = getNeighbors(i).reduce((acc, idx) => acc + (board[idx].isBomb ? 1 : 0), 0);
            board[i].nearbyBombs = total;
        }
    }
}

function clickCell(cell) {
    const id = parseInt(cell.dataset.id);
    
    if (gameOver || board[id].isFlagged || board[id].isRevealed) return;

    if (isFirstClick) {
        isFirstClick = false;
        startTimer();
        generateBombs(id);
    }

    if (board[id].isBomb) {
        endGame(false, id);
    } else {
        revealCell(id);
        checkWin();
    }
}

function addFlag(cell) {
    const id = parseInt(cell.dataset.id);
    if (gameOver || board[id].isRevealed) return;

    if (!board[id].isFlagged) {
        if (flags < BOMB_COUNT) {
            board[id].isFlagged = true;
            cell.classList.add('flagged');
            cell.innerText = '🚩';
            flags++;
        }
    } else {
        board[id].isFlagged = false;
        cell.classList.remove('flagged');
        cell.innerText = '';
        flags--;
    }
    mineCountDisplay.innerText = BOMB_COUNT - flags;
}

function revealCell(id) {
    const cell = gameBoard.children[id];
    const data = board[id];

    if (data.isRevealed || data.isFlagged) return;

    data.isRevealed = true;
    cell.classList.remove('covered');
    
    if (data.nearbyBombs > 0) {
        cell.innerText = data.nearbyBombs;
        cell.dataset.num = data.nearbyBombs; // For CSS coloring
    } else {
        // Empty cell (0 bombs), recurse!
        getNeighbors(id).forEach(neighborId => {
            const neighbor = board[neighborId];
            if (!neighbor.isRevealed && !neighbor.isBomb) {
                revealCell(neighborId);
            }
        });
    }
}

function getNeighbors(id) {
    const neighbors = [];
    const isLeftEdge = (id % SIZE === 0);
    const isRightEdge = (id % SIZE === SIZE - 1);

    if (id - SIZE >= 0) neighbors.push(id - SIZE); // Up
    if (id + SIZE < SIZE * SIZE) neighbors.push(id + SIZE); // Down
    if (!isLeftEdge && id - 1 >= 0) neighbors.push(id - 1); // Left
    if (!isRightEdge && id + 1 < SIZE * SIZE) neighbors.push(id + 1); // Right
    
    // Diagonals
    if (!isLeftEdge && id - SIZE - 1 >= 0) neighbors.push(id - SIZE - 1);
    if (!isRightEdge && id - SIZE + 1 >= 0) neighbors.push(id - SIZE + 1);
    if (!isLeftEdge && id + SIZE - 1 < SIZE * SIZE) neighbors.push(id + SIZE - 1);
    if (!isRightEdge && id + SIZE + 1 < SIZE * SIZE) neighbors.push(id + SIZE + 1);

    return neighbors;
}

function checkWin() {
    let matches = 0;
    for (let i = 0; i < board.length; i++) {
        // Win if every NON-bomb is revealed
        if (!board[i].isBomb && board[i].isRevealed) {
            matches++;
        }
    }

    if (matches === (SIZE * SIZE) - BOMB_COUNT) {
        endGame(true);
    }
}

function endGame(isWin, clickedBombId) {
    gameOver = true;
    stopTimer();
    
    // Reveal all bombs
    board.forEach((data, index) => {
        if (data.isBomb) {
            const cell = gameBoard.children[index];
            cell.innerText = '💣';
            cell.classList.remove('covered', 'flagged');
            cell.classList.add('mine');
        }
    });

    if (isWin) {
        statusMessage.innerText = "YOU WON! 🎉";
        statusMessage.style.color = "#2ed573";
        sendResult(8, time);
    } else {
        statusMessage.innerText = "GAME OVER 💥";
        statusMessage.style.color = "#ff4757";
        // Highlight the one that killed you
        if (clickedBombId !== undefined) {
             gameBoard.children[clickedBombId].style.backgroundColor = "darkred";
        }
    }
}

function sendResult(game_id, score) {
    const formData = new FormData();
    formData.append("score", score);
    formData.append("game_id", game_id);
    fetch("../php/save_score.php", {method: "POST", body: formData});
}

resetButton.addEventListener('click', initGame);

initGame();