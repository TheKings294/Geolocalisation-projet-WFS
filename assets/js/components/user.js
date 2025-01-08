import {getUerInfo, setUser, setUserInfo} from "../services/user.js";
import {toast} from "./shared/toats.js";

export const editUserFunction = async (id) => {
    const res = await getUerInfo(id)
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

    console.log('email', emilElement)
    console.log('checkbox', checkBoxElement)

    emilElement.setAttribute('value', user.email)
    checkBoxElement.checked = true
}
const handelBtn = (action, id = null) => {
    const validBtn = document.querySelector('#valid-btn')
    switch (action) {
        case 'edit':
            validBtn.setAttribute('name', 'edit')
            validBtn.setAttribute('data-id', id)
            validBtn.addEventListener('click', async () => {
                const res = await setUserInfo(id)
                if(res.hasOwnProperty('error')) {
                    toast(res.error, 'text-bg-danger')
                } else if (res.hasOwnProperty('successfull')) {
                    toast(res.successfull, 'text-bg-success')
                }
            })
            break
        case 'new':
            validBtn.setAttribute('name', 'new')
            validBtn.addEventListener('click', async () => {
                const res = await setUser()
                if(res.hasOwnProperty('error')) {
                    toast(res.error, 'text-bg-danger')
                } else if (res.hasOwnProperty('successfull')) {
                    toast(res.successfull, 'text-bg-success')
                }
            })
            break
    }

}