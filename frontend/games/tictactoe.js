document.addEventListener('DOMContentLoaded', () => {
    const gameBoard = document.getElementById('game-board');
    const timerDisplay = document.getElementById('timer');
    const resetButton = document.getElementById('reset');

    let board = ['', '', '', '', '', '', '', '', ''];
    let currentPlayer = 'X';
    let gameActive = true;
    let timer = 0;
    let timerInterval;

    function createBoard() {
        gameBoard.innerHTML = '';
        board.forEach((cell, index) => {
            const cellElement = document.createElement('div');
            cellElement.classList.add('cell');
            cellElement.textContent = cell;
            cellElement.addEventListener('click', () => handleCellClick(index));
            gameBoard.appendChild(cellElement);
        });
    }

    function handleCellClick(index) {
        if (board[index] !== '' || !gameActive) return;

        board[index] = currentPlayer;
        createBoard();
        checkWinner();
        if (gameActive) aiPlay();
    }

    function aiPlay() {
        const emptyCells = board.map((cell, index) => (cell === '' ? index : null)).filter(i => i !== null);
        if (emptyCells.length === 0) return;

        const randomIndex = Math.floor(Math.random() * emptyCells.length);
        const aiMove = emptyCells[randomIndex];
        board[aiMove] = 'O';
        createBoard();
        checkWinner();
    }

    function checkWinner() {
        const winConditions = [
            [0, 1, 2], [3, 4, 5], [6, 7, 8],
            [0, 3, 6], [1, 4, 7], [2, 5, 8],
            [0, 4, 8], [2, 4, 6]
        ];

        for (const condition of winConditions) {
            const [a, b, c] = condition;
            if (board[a] === board[b] && board[a] === board[c] && board[a] !== '') {
                alert(`${board[a]} wins!`);
                gameActive = false;
                clearInterval(timerInterval);  // Stop the timer here
                return;
            }
        }

        if (!board.includes('')) {
            alert("It's a draw!");
            gameActive = false;
            clearInterval(timerInterval);  // Stop the timer here
        }
    }

    function startTimer() {
        if (timerInterval) clearInterval(timerInterval);  // Clear any existing interval
        timerInterval = setInterval(() => {
            timer++;
            timerDisplay.textContent = timer;
        }, 1000);
    }

    function resetGame() {
        board = ['', '', '', '', '', '', '', '', ''];
        currentPlayer = 'X';
        gameActive = true;
        timer = 0;
        timerDisplay.textContent = timer;

        clearInterval(timerInterval);  // Clear any existing timer interval
        startTimer();  // Start a new timer
        createBoard();
    }

    resetButton.addEventListener('click', resetGame);
    resetGame();
    startTimer();
});
