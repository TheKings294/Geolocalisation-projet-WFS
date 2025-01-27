import {toast} from "./shared/toats.js";
import {request} from "../services/http-request.js";

export const handelForm = () => {
    const formLogin = document.querySelector('#form-login')
    const btnLogin = document.querySelector('#login-btn')

    btnLogin.addEventListener('click', async () => {
        if (formLogin.checkValidity() === false) {
            formLogin.reportValidity()
            return false
        }
        const formData = new FormData(formLogin)
        const loginResult = await request('login',
            'conect',
            null,
            null ,
            null,
            formData,
            'POST',
            null,
            null)

        if (loginResult.hasOwnProperty('success')) {
            toast('authentication successful', 'text-bg-success')
            document.location.href='index.php'
        } else if (loginResult.hasOwnProperty('error')) {
            toast(loginResult.error, 'text-bg-danger')
        }
    })
}