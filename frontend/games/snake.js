const gameBoard = document.getElementById('game-board');
const scoreElement = document.getElementById('score');
const statusMessage = document.getElementById('status-message');
const resetButton = document.getElementById('reset');

const GRID_SIZE = 20;
let snake = [];
let food = null;
let direction = { x: 0, y: 0 };
let nextDirection = { x: 0, y: 0 }; // Buffer to prevent self-collision on rapid keypress
let gameInterval;
let score = 0;
let isGameActive = false;
let gameSpeed = 150; // Milliseconds per frame

function initGame() {
    clearInterval(gameInterval);
    snake = [{ x: 10, y: 10 }]; // Start in middle
    food = null;
    direction = { x: 0, y: 0 };
    nextDirection = { x: 0, y: 0 };
    score = 0;
    isGameActive = false;
    scoreElement.innerText = 0;
    statusMessage.innerText = "Press Arrow Keys to Start";
    statusMessage.style.color = "white";
    
    createBoard();
    placeFood();
    draw();
    
    // Listen for keys
    document.addEventListener('keydown', handleInput);
}

function startGame() {
    if (isGameActive) return;
    isGameActive = true;
    statusMessage.innerText = "Go!";
    gameInterval = setInterval(gameLoop, gameSpeed);
}

function createBoard() {
    gameBoard.innerHTML = '';
    // Create 400 divs (20x20)
    for (let i = 0; i < GRID_SIZE * GRID_SIZE; i++) {
        const cell = document.createElement('div');
        cell.classList.add('cell');
        gameBoard.appendChild(cell);
    }
}

function placeFood() {
    let validPosition = false;
    while (!validPosition) {
        const x = Math.floor(Math.random() * GRID_SIZE);
        const y = Math.floor(Math.random() * GRID_SIZE);
        
        // Check if food spawns on snake body
        const onSnake = snake.some(segment => segment.x === x && segment.y === y);
        if (!onSnake) {
            food = { x, y };
            validPosition = true;
        }
    }
}

function handleInput(e) {
    // Prevent scrolling
    if(["ArrowUp","ArrowDown","ArrowLeft","ArrowRight"].indexOf(e.code) > -1) {
        e.preventDefault();
    }

    if (!isGameActive && (e.key.includes('Arrow'))) {
        startGame();
    }

    // Logic to prevent 180 degree turns
    switch (e.key) {
        case 'ArrowUp':
            if (direction.y !== 1) nextDirection = { x: 0, y: -1 };
            break;
        case 'ArrowDown':
            if (direction.y !== -1) nextDirection = { x: 0, y: 1 };
            break;
        case 'ArrowLeft':
            if (direction.x !== 1) nextDirection = { x: -1, y: 0 };
            break;
        case 'ArrowRight':
            if (direction.x !== -1) nextDirection = { x: 1, y: 0 };
            break;
    }
}

function gameLoop() {
    direction = nextDirection;

    // If no direction set yet, don't move
    if (direction.x === 0 && direction.y === 0) return;

    const head = { ...snake[0] };
    head.x += direction.x;
    head.y += direction.y;

    // Check Wall Collision
    if (head.x < 0 || head.x >= GRID_SIZE || head.y < 0 || head.y >= GRID_SIZE) {
        gameOver();
        return;
    }

    // Check Self Collision
    if (snake.some(segment => segment.x === head.x && segment.y === head.y)) {
        gameOver();
        return;
    }

    snake.unshift(head); // Add new head

    // Check Food Collision
    if (head.x === food.x && head.y === food.y) {
        score += 10;
        scoreElement.innerText = score;
        placeFood();
        // Slightly increase speed every 50 points
        if (score % 50 === 0 && gameSpeed > 50) {
            clearInterval(gameInterval);
            gameSpeed -= 10;
            gameInterval = setInterval(gameLoop, gameSpeed);
        }
    } else {
        snake.pop(); // Remove tail if no food eaten
    }

    draw();
}

function draw() {
    // 1. Select only cells inside our game board
    const cells = document.querySelectorAll('#game-board .cell');
    
    // 2. Reset ALL cells to basic state first
    cells.forEach(cell => {
        cell.className = 'cell'; 
    });

    // 3. Draw Snake
    snake.forEach((segment, index) => {
        const i = segment.y * GRID_SIZE + segment.x;
        // Check if cell exists to prevent crashing if out of bounds
        if (cells[i]) {
            cells[i].classList.add('snake');
            if (index === 0) cells[i].classList.add('snake-head');
        }
    });

    // 4. Draw Food
    if (food) {
        const i = food.y * GRID_SIZE + food.x;
        if (cells[i]) cells[i].classList.add('food');
    }
}

function gameOver() {
    clearInterval(gameInterval);
    isGameActive = false;
    statusMessage.innerText = "Game Over!";
    statusMessage.style.color = "#ff4757";
}

resetButton.addEventListener('click', initGame);

// Initialize
initGame();