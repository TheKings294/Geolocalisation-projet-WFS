import {toast} from "./shared/toats.js";
import {getCookie} from "./shared/cookie.js";
import {request} from "../services/http-request.js";

export const editUserFunction = async (id) => {
    const res = await request('form-user',
        'get',
        null,
        null,
        null,
        null,
        'GET',
        id,
        null)
    if(res.hasOwnProperty('error')) {
        toast(res.error, 'text-bg-danger')
        return false
    }
    showUserInfo(res.result)
    handelBtn('edit', id)
}
export const setUserFunction = async () => {
    handelBtn('new')
}
const showUserInfo = (user) => {
    const emilElement = document.querySelector('#email')
    const checkBoxElement = document.querySelector('#is-active')
    emilElement.setAttribute('value', user.email)
    checkBoxElement.checked = user.is_active
    const id = parseInt(getCookie('user_id'))
    if(user.id === id) {
        checkBoxElement.disabled = true
    }
}
const handelBtn = (action, id = null) => {
    const validBtn = document.querySelector('#valid-btn')
    switch (action) {
        case 'edit':
            validBtn.setAttribute('name', 'edit')
            validBtn.setAttribute('data-id', id)
            validBtn.addEventListener('click', async () => {
                const form = document.querySelector('#form-user')
                const formData = new  FormData(form)
                const res = await request('form-user',
                    'edit',
                    null,
                    null,
                    null,
                    formData,
                    'POST',
                    id,
                    null)
                if(res.hasOwnProperty('error')) {
                    toast(res.error, 'text-bg-danger')
                } else if (res.hasOwnProperty('success')) {
                    toast('User Update', 'text-bg-success')
                }
            })
            break
        case 'new':
            validBtn.setAttribute('name', 'new')
            validBtn.addEventListener('click', async () => {
                const form = document.querySelector('#form-user')
                const formData = new FormData(form)
                const res = await request('form-user',
                    'new',
                    null,
                    null,
                    null,
                    formData,
                    'POST',
                    null,
                    null)
                if(res.hasOwnProperty('error')) {
                    toast(res.error, 'text-bg-danger')
                } else if (res.hasOwnProperty('success')) {
                    toast('User Created', 'text-bg-success')
                }
            })
            break
    }

}