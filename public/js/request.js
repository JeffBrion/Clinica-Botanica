const api_url = 'http://127.0.0.1:8000/api/';

function makeRequest(url, method, callback, error, form_id = null) {
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status >= 200 && xhr.status < 300) {
                let responseData = null;
                try {
                    responseData = JSON.parse(xhr.responseText);
                } catch (e) {
                    responseData = xhr.responseText;
                }
                callback(responseData);
            } else {
                let errorMessage = `Error ${xhr.status}: ${xhr.statusText}`;
                try {
                    const errorResponse = JSON.parse(xhr.responseText);
                    if (errorResponse.message) {
                        errorMessage = errorResponse.message;
                    }
                    error();
                } catch (e) {
                    error();
                }
            }
        }
    };

    xhr.open(method, url, true);

    if (form_id) {
        const form = document.getElementById(form_id);
        const formData = new FormData(form);

        let hasFile = false;
        for (const entry of formData.entries()) {
            const [key, value] = entry;
            if (form.elements[key].type === 'file' && form.elements[key].value !== '') {
                hasFile = true;
                break;
            }
        }
        if (hasFile) {
            xhr.send(formData);
        } else {
            let jsonData = {};
            formData.forEach((value, key) => {
                if (form.elements[key].type === 'checkbox') {
                    jsonData[key] = form.elements[key].checked;
                } else {
                    jsonData[key] = value;
                }
            });

            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.send(JSON.stringify(jsonData));
        }
    } else {
        xhr.send();
    }
}