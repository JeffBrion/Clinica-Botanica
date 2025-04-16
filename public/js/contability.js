// eliminar separador de miles y dos decimales
function parseAccountingNumber(numberString) {
    // Elimina los separadores de miles
    let cleanedString = numberString.replace(/,/g, '');
    // Convierte a número de punto flotante
    return parseFloat(cleanedString) || 0;
}


//poner separador de miles y dos decimales
function formatAccountingNumber(number) {
    if(!number) return 0;
    return number.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function setnumberFormatToElemet(numberString) {
    numberString = numberString.replace(/[^0-9.]/g, '');
    const parts = numberString.split('.');
    if (parts.length > 2) {
        return parts[0] + '.' + parts.slice(1).join('');
    }
    if (parts[1] && parts[1].length > 2) {
        return parts[0] + '.' + parts[1].slice(0, 2);
    }
    return parseFloat(numberString) || 0;
}

function removeCommas(numberString) {
    return numberString.replace(/,/g, '');
}