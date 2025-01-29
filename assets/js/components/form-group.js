import {request} from "../services/http-request.js";
import {toast} from "./shared/toats.js";

export const editFormGroup = async (id) => {
    const res = await request(
        'form-group',
        'get',
        null,
        null,
        null,
        null,
        'GET',
        id,
        null,
        null)
    if (res.hasOwnProperty('error')) {
        toast(res.error, 'text-bg-danger')
        return true
    }
    document.querySelector('#group-name').value = res.result.name
    document.querySelector('#group-color').value = res.result.color

    handelForm('edit', id)

}
export const newFormGroup = () => {
    handelForm('new')
}
const handelForm = (action, id = null) => {
    document.querySelector('#form-group-btn')?.addEventListener('click', async () => {
        if (document.querySelector('#form-group').checkValidity() === false) {
            document.querySelector('#form-group').reportValidity()
        }
        const formData = new FormData
        formData.append('name', document.querySelector('#group-name').value)
        formData.append('color', document.querySelector('#group-color').value)
        const res = await request('form-group', action,null, null, null, formData, 'POST', id, null, null)

        if (res.hasOwnProperty('error')) {
            toast(res, 'text-bg-danger')
        } else if (res.hasOwnProperty('success')) {
            toast('action réussi', 'text-bg-success')
        }
    })
}