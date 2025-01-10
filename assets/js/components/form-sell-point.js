import {request} from "../services/http-request.js";
import {toast} from "./shared/toats.js";
import {setMap} from "./shared/map.js";
import {updateProgressBar} from "./shared/progress-bar.js";
import {FORM_PROGRESS_BAR_UPDATE} from "./shared/constant.js";

export const formSPFuntion = () => {
    const newGroupBtn = document.querySelector('#modal-open')
    setMap(47.16, 4.68, 5)
    getGroup()
    newGroupBtn.addEventListener('click', () => {
        modal(modalForm, 'Create group', 'Create Group Form')
    })
    handelBtn()
}
const getGroup = async () => {
    const dataList = document.querySelector('#groupList')
    const groupData = await request('groups', 'getall', null, null, null)
    if(groupData.hasOwnProperty('error')) {
        toast(groupData.error, 'text-bg-danger')
        return false
    }
    for (let i = 0; i < groupData.data.length; i++) {
        const optionElement = document.createElement('option')
        optionElement.setAttribute('value', groupData.data[i].name)
        const textElement = document.createTextNode(groupData.data[i].name)
        optionElement.appendChild(textElement)
        dataList.appendChild(optionElement)
    }
}

const modalForm = `
<form>
    <div class="mb-3">
        <label for="group-name" class="form-label">Group Name</label>
        <input type="text" id="group-name" class="form-control" required>
    </div>
</form>`

const handelBtn = () => {
    document.querySelector('#next-btn')?.addEventListener('click', () => {
        navBtnFuntion(true)
    })
    document.querySelector('#prev-btn')?.addEventListener('click', () => {
        navBtnFuntion(false)
    })

}

const navBtnFuntion = (value) => {
    const tabs = document.querySelectorAll('.tab-pane')

    for (let i = 0; i < tabs.length; i++) {
        if(tabs[i].classList.contains('active')) {
            const formElement = tabs[i].querySelector(`#form${i+1}`)
            if(value === true) {
                if(formElement.checkValidity() === false) {
                    formElement.reportValidity()
                    return false
                } else if (i === 1) {
                    disabledBtn('next', true)
                }
                updateTabsAndButton(i, i+1)
                disabledBtn('prev', false)
                updateProgressBar(FORM_PROGRESS_BAR_UPDATE * (i+1))
                return false
            } else {
                if(formElement.checkValidity() === false) {
                    formElement.reportValidity()
                    return false
                }
                if(i - 1 === 0) {
                    disabledBtn('prev', true)
                }
                updateTabsAndButton(i, i-1)
                updateProgressBar(FORM_PROGRESS_BAR_UPDATE * (i-1))
                return false
            }
        }
    }
}

const updateTabsAndButton = (now, next) => {
    const formElements = document.querySelectorAll('.tab-pane')
    const formBtnElements = document.querySelectorAll('.nav-form')
    console.log(formBtnElements)

    formElements[now].classList.remove('show', 'active', 'montrer')
    formBtnElements[now].classList.remove('active')
    formBtnElements[now].disabled = "true"
    formElements[next].classList.add('show', 'active', 'montrer')
    formBtnElements[next].classList.add('active')
}

const disabledBtn = (btn, action) => {
    document.querySelector(`#${btn}-btn`).disabled = action
}