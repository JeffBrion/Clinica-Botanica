function getCellValue(cell) {
    if(cell.children.length > 0){
        return getCellValue(cell.children[0]);
    }
    let value = cell.value;
    if(!value){
        value = cell.textContent;
    }
    return value;
}

function getColumnCells(table, columnIndex) {
    let cells = [];
    let rows = table.rows;
    for (let i = 0; i < rows.length; i++) {
        for (let j = 0; j < rows[i].cells.length; j++) {
            let cell = rows[i].cells[j];
            if(cell.cellIndex === columnIndex){
                cells.push(cell);
            }
        }
    }
    return cells;
}

function getRowCells(table, rowIndex) {
    let cells = [];
    let row = table.rows[rowIndex];
    for (let i = 0; i < row.cells.length; i++) {
        cells.push(row.cells[i]);
    }
    return cells;
}

function sumToUp(td){
    let sum = 0;
    let table = td.closest('table');
    let cells = getColumnCells(table, td.cellIndex);
    for(let i = 1; i < cells.length; i++){
        sum += parseAccountingNumber(getCellValue(cells[i]));
    }
    return sum;
}

function sumToLeft(td){
    let sum = 0;
    let row = td.closest('tr');
    for(let i = 1; i < row.cells.length; i++){
        sum += parseAccountingNumber(getCellValue(row.cells[i]));
    }
    return sum;
}

function sumCell(td){
    const direction = td.dataset.sumDirection;

    if(direction === 'up'){
        return sumToUp(td);
    }
    if(direction === 'down'){
        return sumToDown(td);
    }
    if(direction === 'right'){
        return sumToRight(td);
    }
    if(direction === 'left'){
        return sumToLeft(td);
    }
    return 0;
}

function setSum(td){
    td.textContent = '';
    let sum = sumCell(td);
    td.textContent = formatAccountingNumber(sum);
}

function sumAllCells(table){
    let cells = table.querySelectorAll('td[data-sum-direction]');
    cells.forEach(td => {
        setSum(td);
    });
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('td[data-sum-direction]').forEach(td => {
        setSum(td);
    });

    document.querySelectorAll('input, textarea').forEach(input => {
        input.addEventListener('change', function() {
            sumAllCells(input.closest('table'));
        });
    });
});