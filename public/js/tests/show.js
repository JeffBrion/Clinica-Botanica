document.addEventListener('DOMContentLoaded', function() {
    let btns = document.querySelectorAll('.btn_show_add_evaluation_modal');
    btns.forEach(btn => {
        btn.addEventListener('click', function(){showModal(btn);});
    });
    document.getElementById('instrument_type').addEventListener('change', setInstrumentType);
});

function showModal(btn){
    let modal =  new bootstrap.Modal(document.getElementById('modal_add_evaluation'));
    setModalData({evaluator_id: btn.dataset.workerId, worked_type: btn.dataset.workerType});
    setInstrumentType();
    modal.show();
}

function setModalData(data)
{
    document.getElementById('evaluator_id').value = data.evaluator_id;
    document.getElementById('worked_type').value = data.worked_type;
}

function setInstrumentType()
{
    let instrument_type = document.getElementById('instrument_type').value;

    if(instrument_type === 'autoevaluation')
    {
        document.getElementById('evaluated_container_search').style.display = 'none';
        document.getElementById('evaluated_id').innerHTML = '';
    }
    else
    {
        document.getElementById('evaluated_container_search').style.display = 'block';
    }
}