<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Calculator') }}</div>

                <div class="card-body">
                    <div class="calculator">
                        <div class="calculator-screen">0</div>
                        <div class="calculator-keys">
                            <button type="button" class="operator" value="+">+</button>
                            <button type="button" class="operator" value="-">-</button>
                            <button type="button" class="operator" value="*">&times;</button>
                            <button type="button" class="operator" value="/">&divide;</button>

                            <button type="button" value="7">7</button>
                            <button type="button" value="8">8</button>
                            <button type="button" value="9">9</button>

                            <button type="button" value="4">4</button>
                            <button type="button" value="5">5</button>
                            <button type="button" value="6">6</button>

                            <button type="button" value="1">1</button>
                            <button type="button" value="2">2</button>
                            <button type="button" value="3">3</button>

                            <button type="button" value="0">0</button>
                            <button type="button" class="decimal" value=".">.</button>
                            <button type="button" class="all-clear" value="all-clear">AC</button>

                            <button type="button" class="equal-sign operator" value="=">=</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Notes') }}</div>
                <div class="card-body">
                    <textarea id="note-input" class="form-control" rows="3" placeholder="Write a note..."></textarea>
                    <button id="save-note" class="btn btn-primary mt-2">Save Note</button>
                    <ul id="notes-list" class="list-group mt-3">
                        <!-- Notes will be dynamically added here -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .calculator {
        border: 1px solid #ccc;
        border-radius: 5px;
        position: relative;
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
    }

    .calculator-screen {
        width: 100%;
        height: 80px;
        background-color: #252525;
        color: #fff;
        text-align: right;
        font-size: 2.5rem;
        padding: 1rem;
        overflow: hidden;
    }

    .calculator-keys {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-gap: 1px;
    }

    .calculator-keys button {
        height: 80px;
        background-color: #fff;
        border: 1px solid #ccc;
        font-size: 2rem;
        color: #333;
        background-color: transparent;
        cursor: pointer;
    }

    .calculator-keys button:hover {
        background-color: #eaeaea;
    }

    .operator {
        color: #337ab7;
    }

    .all-clear {
        background-color: #f0595f;
        border-color: #b0353a;
        color: #fff;
    }

    .all-clear:hover {
        background-color: #f28386;
    }

    .equal-sign {
        background-color: #2e8b57;
        border-color: #256a42;
        color: #fff;
        grid-column: -2 / -1;
        grid-row: 2 / span 4;
    }

    .equal-sign:hover {
        background-color: #38a868;
    }
</style>

<script>
    const calculator = {
        displayValue: '0',
        firstOperand: null,
        waitingForSecondOperand: false,
        operator: null,
    };

    function updateDisplay() {
        const display = document.querySelector('.calculator-screen');
        display.textContent = calculator.displayValue;
    }

    updateDisplay();

    const keys = document.querySelector('.calculator-keys');
    keys.addEventListener('click', (event) => {
        const { target } = event;
        const { value } = target;

        if (!target.matches('button')) {
            return;
        }

        switch (value) {
            case '+':
            case '-':
            case '*':
            case '/':
            case '=':
                handleOperator(value);
                break;
            case '.':
                inputDecimal(value);
                break;
            case 'all-clear':
                resetCalculator();
                break;
            default:
                if (Number.isInteger(parseFloat(value))) {
                    inputDigit(value);
                }
        }

        updateDisplay();
    });

    function inputDigit(digit) {
        const { displayValue, waitingForSecondOperand } = calculator;

        if (waitingForSecondOperand === true) {
            calculator.displayValue = digit;
            calculator.waitingForSecondOperand = false;
        } else {
            calculator.displayValue = displayValue === '0' ? digit : displayValue + digit;
        }
    }

    function inputDecimal(dot) {
        if (calculator.waitingForSecondOperand === true) {
            calculator.displayValue = '0.'
            calculator.waitingForSecondOperand = false;
            return
        }

        if (!calculator.displayValue.includes(dot)) {
            calculator.displayValue += dot;
        }
    }

    function handleOperator(nextOperator) {
        const { firstOperand, displayValue, operator } = calculator
        const inputValue = parseFloat(displayValue);

        if (operator && calculator.waitingForSecondOperand) {
            calculator.operator = nextOperator;
            return;
        }

        if (firstOperand == null && !isNaN(inputValue)) {
            calculator.firstOperand = inputValue;
        } else if (operator) {
            const result = calculate(firstOperand, inputValue, operator);

            calculator.displayValue = `${parseFloat(result.toFixed(7))}`;
            calculator.firstOperand = result;
        }

        calculator.waitingForSecondOperand = true;
        calculator.operator = nextOperator;
    }

    function calculate(firstOperand, secondOperand, operator) {
        if (operator === '+') {
            return firstOperand + secondOperand;
        } else if (operator === '-') {
            return firstOperand - secondOperand;
        } else if (operator === '*') {
            return firstOperand * secondOperand;
        } else if (operator === '/') {
            return firstOperand / secondOperand;
        }

        return secondOperand;
    }

    function resetCalculator() {
        calculator.displayValue = '0';
        calculator.firstOperand = null;
        calculator.waitingForSecondOperand = false;
        calculator.operator = null;
    }

    document.addEventListener('DOMContentLoaded', () => {
        const noteInput = document.getElementById('note-input');
        const saveNoteBtn = document.getElementById('save-note');
        const notesList = document.getElementById('notes-list');
        let notes = JSON.parse(localStorage.getItem('calculator_notes')) || [];

        function renderNotes() {
            notesList.innerHTML = '';
            notes.forEach((note, index) => {
                const li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center';
                li.innerHTML = `
                    <span>${note}</span>
                    <button class="btn btn-danger btn-sm delete-note" data-index="${index}">Delete</button>
                `;
                notesList.appendChild(li);
            });
        }

        function saveNotes() {
            localStorage.setItem('calculator_notes', JSON.stringify(notes));
        }

        saveNoteBtn.addEventListener('click', () => {
            const noteText = noteInput.value.trim();
            if (noteText) {
                notes.push(noteText);
                noteInput.value = '';
                saveNotes();
                renderNotes();
            }
        });

        notesList.addEventListener('click', (event) => {
            if (event.target.classList.contains('delete-note')) {
                const index = event.target.getAttribute('data-index');
                notes.splice(index, 1);
                saveNotes();
                renderNotes();
            }
        });

        renderNotes();
    });
</script>
