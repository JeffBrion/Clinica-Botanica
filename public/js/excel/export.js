document.addEventListener('DOMContentLoaded', function(){

    Array.from(document.getElementsByClassName('excel_export_btn')).forEach(function(btn){
        btn.addEventListener('click', function(){
            exportToExcel(btn.dataset.target);
        });
    });

});

function exportToExcel(table_id){
    const table = document.getElementById(table_id);
    const wb = XLSX.utils.table_to_book(table);
    XLSX.writeFile(wb, table_id+'.xlsx');
}