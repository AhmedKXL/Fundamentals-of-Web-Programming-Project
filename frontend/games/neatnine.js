const gameBoard = document.getElementById('game-board');
const moveDisplay = document.getElementById('move-count');
const statusMessage = document.getElementById('status-message');
const resetButton = document.getElementById('reset');

let tiles = []; // Array to store the grid state (1-8, and 9 representing empty)
let moveCount = 0;
let isGameActive = true;

// Initialize the game
function initGame() {
    // Start with a solved state: [1, 2, 3, 4, 5, 6, 7, 8, 9] (9 is empty)
    tiles = [1, 2, 3, 4, 5, 6, 7, 8, 9];
    moveCount = 0;
    isGameActive = true;
    moveDisplay.innerText = 0;
    statusMessage.innerText = "Order the tiles 1-8";
    statusMessage.style.color = "white";

    // Shuffle by simulating valid moves (ensures solvability)
    shuffleBoard(150); // 150 random moves
    renderBoard();
}

// Render the grid
function renderBoard() {
    gameBoard.innerHTML = '';
    tiles.forEach((num, index) => {
        const tile = document.createElement('div');
        tile.classList.add('tile');
        
        if (num === 9) {
            tile.classList.add('empty');
            tile.innerText = '';
        } else {
            tile.innerText = num;
            // Optional: Highlight if it's in the correct spot (index + 1 == num)
            if (index + 1 === num) {
                tile.classList.add('correct');
            }
        }

        // Pass the index so we know which tile was clicked
        tile.addEventListener('click', () => handleTileClick(index));
        gameBoard.appendChild(tile);
    });
}

function handleTileClick(index) {
    if (!isGameActive) return;

    const emptyIndex = tiles.indexOf(9);
    
    // Check if the clicked tile is adjacent to the empty slot
    if (isAdjacent(index, emptyIndex)) {
        // Swap them
        [tiles[index], tiles[emptyIndex]] = [tiles[emptyIndex], tiles[index]];
        
        moveCount++;
        moveDisplay.innerText = moveCount;
        renderBoard();
        checkWin();
    }
}

// Helper to check adjacency in a 3x3 grid
function isAdjacent(idx1, idx2) {
    const row1 = Math.floor(idx1 / 3);
    const col1 = idx1 % 3;
    const row2 = Math.floor(idx2 / 3);
    const col2 = idx2 % 3;

    // Adjacent if distance is exactly 1 (horizontally or vertically)
    return Math.abs(row1 - row2) + Math.abs(col1 - col2) === 1;
}

// Shuffle by simulating random valid moves
function shuffleBoard(moves) {
    for (let i = 0; i < moves; i++) {
        const emptyIndex = tiles.indexOf(9);
        const neighbors = getNeighbors(emptyIndex);
        const randomNeighbor = neighbors[Math.floor(Math.random() * neighbors.length)];
        
        // Swap
        [tiles[emptyIndex], tiles[randomNeighbor]] = [tiles[randomNeighbor], tiles[emptyIndex]];
    }
}

function getNeighbors(index) {
    const neighbors = [];
    const row = Math.floor(index / 3);
    const col = index % 3;

    if (row > 0) neighbors.push(index - 3); // Up
    if (row < 2) neighbors.push(index + 3); // Down
    if (col > 0) neighbors.push(index - 1); // Left
    if (col < 2) neighbors.push(index + 1); // Right
    
    return neighbors;
}

function checkWin() {
    // Check if array is [1, 2, 3, 4, 5, 6, 7, 8, 9]
    const isWin = tiles.every((val, index) => val === index + 1);
    
    if (isWin) {
        isGameActive = false;
        sendResult(3, moveCount);       // Must use correct id from games table
        statusMessage.innerText = "Puzzle Solved!";
        statusMessage.style.color = "#2ed573";
        
        // Highlight all tiles green
        const allTiles = document.querySelectorAll('.tile');
        allTiles.forEach(t => t.style.borderColor = "#2ed573");
    }
}

function sendResult(game_id, score) {
    const formData = new FormData();
    formData.append("score", score);
    formData.append("game_id", game_id);
    fetch("../php/save_score.php", {method: "POST", body: formData});
}

resetButton.addEventListener('click', initGame);

// Start
initGame();