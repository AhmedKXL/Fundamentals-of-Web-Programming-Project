const gameBoard = document.getElementById('game-board');
const scoreDisplay = document.getElementById('score');
const statusMessage = document.getElementById('status-message');
const resetButton = document.getElementById('reset');

const SIZE = 4;
let board = [];
let score = 0;
let isGameActive = true;

function initGame() {
    board = Array(SIZE).fill().map(() => Array(SIZE).fill(0));
    score = 0;
    isGameActive = true;
    scoreDisplay.innerText = 0;
    statusMessage.innerText = "Join the numbers to get 2048!";
    
    // Add two starting numbers
    addNewTile();
    addNewTile();
    updateBoardUI();
    
    document.addEventListener('keydown', handleInput);
}

function addNewTile() {
    let emptyTiles = [];
    for (let r = 0; r < SIZE; r++) {
        for (let c = 0; c < SIZE; c++) {
            if (board[r][c] === 0) emptyTiles.push({r, c});
        }
    }
    
    if (emptyTiles.length > 0) {
        let rand = emptyTiles[Math.floor(Math.random() * emptyTiles.length)];
        // 90% chance of 2, 10% chance of 4
        board[rand.r][rand.c] = Math.random() < 0.9 ? 2 : 4;
    }
}

function updateBoardUI() {
    gameBoard.innerHTML = '';
    for (let r = 0; r < SIZE; r++) {
        for (let c = 0; c < SIZE; c++) {
            const tile = document.createElement('div');
            tile.classList.add('tile');
            const value = board[r][c];
            if (value > 0) {
                tile.innerText = value;
                tile.classList.add(`x${value}`);
            }
            gameBoard.appendChild(tile);
        }
    }
    scoreDisplay.innerText = score;
}

function handleInput(e) {
    if (!isGameActive) return;

    // Prevent scrolling
    if(["ArrowUp","ArrowDown","ArrowLeft","ArrowRight"].indexOf(e.code) > -1) {
        e.preventDefault();
    }

    let moved = false;
    switch(e.key) {
        case 'ArrowUp': moved = moveUp(); break;
        case 'ArrowDown': moved = moveDown(); break;
        case 'ArrowLeft': moved = moveLeft(); break;
        case 'ArrowRight': moved = moveRight(); break;
    }

    if (moved) {
        addNewTile();
        updateBoardUI();
        checkGameOver();
    }
}

// Logic to process a single row/column (slide and merge)
function slideAndMerge(row) {
    // 1. Filter out zeros
    let arr = row.filter(val => val !== 0);
    
    // 2. Merge pairs
    for (let i = 0; i < arr.length - 1; i++) {
        if (arr[i] === arr[i+1]) {
            arr[i] *= 2;
            score += arr[i];
            arr[i+1] = 0;
        }
    }
    
    // 3. Filter zeros created by merge
    arr = arr.filter(val => val !== 0);
    
    // 4. Pad with zeros to fill length
    while (arr.length < SIZE) {
        arr.push(0);
    }
    return arr;
}

function moveLeft() {
    let moved = false;
    for (let r = 0; r < SIZE; r++) {
        let oldRow = board[r];
        let newRow = slideAndMerge(oldRow);
        if (oldRow.join(',') !== newRow.join(',')) moved = true;
        board[r] = newRow;
    }
    return moved;
}

function moveRight() {
    let moved = false;
    for (let r = 0; r < SIZE; r++) {
        let oldRow = board[r];
        // Reverse, slide, reverse back
        let reversed = oldRow.slice().reverse();
        let newRow = slideAndMerge(reversed);
        newRow.reverse();
        if (oldRow.join(',') !== newRow.join(',')) moved = true;
        board[r] = newRow;
    }
    return moved;
}

function moveUp() {
    let moved = false;
    for (let c = 0; c < SIZE; c++) {
        let col = [board[0][c], board[1][c], board[2][c], board[3][c]];
        let newCol = slideAndMerge(col);
        
        for (let r = 0; r < SIZE; r++) {
            if (board[r][c] !== newCol[r]) moved = true;
            board[r][c] = newCol[r];
        }
    }
    return moved;
}

function moveDown() {
    let moved = false;
    for (let c = 0; c < SIZE; c++) {
        let col = [board[0][c], board[1][c], board[2][c], board[3][c]];
        let reversed = col.reverse();
        let newCol = slideAndMerge(reversed);
        newCol.reverse();
        
        for (let r = 0; r < SIZE; r++) {
            if (board[r][c] !== newCol[r]) moved = true;
            board[r][c] = newCol[r];
        }
    }
    return moved;
}

function checkGameOver() {
    // 1. Check for 2048
    for (let r = 0; r < SIZE; r++) {
        for (let c = 0; c < SIZE; c++) {
            if (board[r][c] === 2048) {
                isGameActive = false;
                sendResult(6, score);
                statusMessage.innerText = "You Won! (Press Reset)";
                statusMessage.style.color = "#2ed573";
            }
        }
    }

    // 2. Check if full
    let isFull = true;
    for (let r = 0; r < SIZE; r++) {
        if (board[r].includes(0)) isFull = false;
    }

    if (isFull) {
        // Check if any merges are possible
        if (!canMove()) {
            isGameActive = false;
            sendResult(6, score);
            statusMessage.innerText = "Game Over!";
            statusMessage.style.color = "#ff4757";
        }
    }
}

function canMove() {
    for (let r = 0; r < SIZE; r++) {
        for (let c = 0; c < SIZE; c++) {
            let val = board[r][c];
            // Check right
            if (c < SIZE - 1 && board[r][c+1] === val) return true;
            // Check down
            if (r < SIZE - 1 && board[r+1][c] === val) return true;
        }
    }
    return false;
}

function sendResult(game_id, score) {
    const formData = new FormData();
    formData.append("score", score);
    formData.append("game_id", game_id);
    fetch("../php/save_score.php", {method: "POST", body: formData});
}

resetButton.addEventListener('click', initGame);
initGame();