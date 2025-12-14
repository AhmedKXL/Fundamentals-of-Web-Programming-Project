const gameBoard = document.getElementById('game-board');
const currentPlayerDisplay = document.getElementById('current-player');
const statusMessage = document.getElementById('status-message');
const resetButton = document.getElementById('reset');

const ROWS = 6;
const COLS = 7;
let board = [];
let currentPlayer = 'red'; // 'red' (Player) or 'yellow' (Bot)
let isGameActive = true;
let isBotTurn = false; // Flag to prevent player clicking during bot turn

function initGame() {
    board = [];
    gameBoard.innerHTML = '';
    isGameActive = true;
    isBotTurn = false;
    currentPlayer = 'red';
    updatePlayerDisplay();
    statusMessage.innerText = '';

    // Create board logic and UI
    for (let r = 0; r < ROWS; r++) {
        let row = [];
        for (let c = 0; c < COLS; c++) {
            row.push(null);
            const cell = document.createElement('div');
            cell.classList.add('cell');
            cell.dataset.row = r;
            cell.dataset.col = c;
            cell.addEventListener('click', handleCellClick);
            gameBoard.appendChild(cell);
        }
        board.push(row);
    }
}

function handleCellClick(e) {
    // Prevent click if game over or if it's bot's turn
    if (!isGameActive || isBotTurn) return;

    const col = parseInt(e.target.dataset.col);
    attemptMove(col);
}

function attemptMove(col) {
    // Find lowest empty row in column
    for (let r = ROWS - 1; r >= 0; r--) {
        if (!board[r][col]) {
            makeMove(r, col);
            return true; // Move successful
        }
    }
    return false; // Column full
}

function makeMove(r, c) {
    board[r][c] = currentPlayer;
    updateBoardUI(r, c);

    if (checkWin(r, c, currentPlayer)) {
        endGame(false);
    } else if (checkDraw()) {
        endGame(true);
    } else {
        switchPlayer();
    }
}

function switchPlayer() {
    currentPlayer = currentPlayer === 'red' ? 'yellow' : 'red';
    updatePlayerDisplay();

    if (currentPlayer === 'yellow') {
        isBotTurn = true;
        setTimeout(botMove, 600); // 600ms delay for realism
    } else {
        isBotTurn = false;
    }
}

// --- BOT LOGIC ---
function botMove() {
    if (!isGameActive) return;

    // 1. Check if Bot can win immediately
    let winMove = findBestMove('yellow');
    if (winMove !== -1) {
        attemptMove(winMove);
        return;
    }

    // 2. Check if Player is about to win (Block them)
    let blockMove = findBestMove('red');
    if (blockMove !== -1) {
        attemptMove(blockMove);
        return;
    }

    // 3. Otherwise pick a random valid column
    let validCols = [];
    for (let c = 0; c < COLS; c++) {
        if (!board[0][c]) validCols.push(c);
    }
    
    if (validCols.length > 0) {
        const randomCol = validCols[Math.floor(Math.random() * validCols.length)];
        attemptMove(randomCol);
    }
}

// Helper to simulate a move to see if it wins
function findBestMove(player) {
    for (let c = 0; c < COLS; c++) {
        // Find where the piece would land in this column
        for (let r = ROWS - 1; r >= 0; r--) {
            if (!board[r][c]) {
                // Temporarily place piece
                board[r][c] = player;
                let won = checkWin(r, c, player);
                // Remove piece (backtrack)
                board[r][c] = null;

                if (won) return c; // Found a winning column
                break; // Move to next column
            }
        }
    }
    return -1; // No critical move found
}

function updateBoardUI(row, col) {
    const index = row * COLS + col;
    const cell = gameBoard.children[index];
    cell.classList.add(currentPlayer);
}

function updatePlayerDisplay() {
    if (currentPlayer === 'red') {
        currentPlayerDisplay.innerText = "You (Red)";
        currentPlayerDisplay.className = 'player-red';
    } else {
        currentPlayerDisplay.innerText = "Bot (Yellow)";
        currentPlayerDisplay.className = 'player-yellow';
    }
}

function checkWin(r, c, playerToCheck) {
    const directions = [[0, 1], [1, 0], [1, 1], [1, -1]];
    return directions.some(([dr, dc]) => {
        let count = 1;
        // Check positive direction
        for (let i = 1; i < 4; i++) {
            const nr = r + dr * i;
            const nc = c + dc * i;
            if (nr >= 0 && nr < ROWS && nc >= 0 && nc < COLS && board[nr][nc] === playerToCheck) count++;
            else break;
        }
        // Check negative direction
        for (let i = 1; i < 4; i++) {
            const nr = r - dr * i;
            const nc = c - dc * i;
            if (nr >= 0 && nr < ROWS && nc >= 0 && nc < COLS && board[nr][nc] === playerToCheck) count++;
            else break;
        }
        return count >= 4;
    });
}

function checkDraw() {
    return board[0].every(cell => cell !== null);
}

function endGame(draw) {
    isGameActive = false;
    if (draw) {
        statusMessage.innerText = "It's a Draw!";
        statusMessage.style.color = 'white';
    } else {
        if (currentPlayer === 'red') {
            statusMessage.innerText = "You Win!";
            statusMessage.style.color = '#ff4757';
        } else {
            statusMessage.innerText = "Bot Wins!";
            statusMessage.style.color = '#ffa502';
        }
    }
}

resetButton.addEventListener('click', initGame);

initGame();