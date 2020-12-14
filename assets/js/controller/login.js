/**
 * JS Proses Login
 * 
 * Untuk proses login
 * 
 * @package		CodeIgniter
 * @subpackage	Controller
 * @category	JavaScript
 * @author Wahyu Kamaludin
 */

const myForm = document.getElementById('f_login');
// submit form
myForm.addEventListener('submit', function (event) {
    event.preventDefault();
    const value = new FormData(myForm);
    sendData(value);
});

async function sendData(value) {
    const btnSubmit = document.getElementById('login');
    const options = {
        method: 'POST',
        body: value
    };
    try {
        btnSubmit.disabled = true;
        btnSubmit.textContent = "mohon tunggu...";
        const response = await fetch(site_url + 'login/do_login', options);
        const json = await response.json();
        console.log(json);
        if (json.status) {
            location.href = site_url + 'home';
        } else {
            document.getElementById('alert').innerHTML = json.message;
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = "MASUK";
        }
    } catch (error) {
        console.log(error);
        document.getElementById('alert').innerHTML = error;
        btnSubmit.disabled = false;
        btnSubmit.innerHTML = "MASUK";
    }
}