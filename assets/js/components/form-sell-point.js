import {request} from "../services/http-request.js";
import {toast} from "./shared/toats.js";
import {setMap, setMarker, setView} from "./shared/map.js";
import {updateProgressBar} from "./shared/progress-bar.js";
import {FORM_PROGRESS_BAR_UPDATE} from "./shared/constant.js";
import {addressAutoCompletion, getDepartement} from "../services/form-sell-point.js";
import {closeModal, modal} from "./shared/modal.js";

export const formSPFuntion = () => {
    const newGroupBtn = document.querySelector('#modal-open')
    setMap(47.16, 4.68, 5)
    getGroup()
    newGroupBtn.addEventListener('click', () => {
        modal(modalForm, 'Create group', 'Create Group Form')
    })
    handelBtn()
    sendForm()
    autocompletion()
    handelModalBtn()
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
        optionElement.setAttribute('value', groupData.data[i].id)
        const textElement = document.createTextNode(groupData.data[i].name)
        optionElement.appendChild(textElement)
        dataList.appendChild(optionElement)
    }
}

const modalForm = `
<form id="form-modal">
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
                    document.querySelector('#next-btn').classList.add('d-none')
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
const sendForm = () => {
    document.querySelector('#form-btn').addEventListener('click', async () => {
        console.log('je suis la')
        const adresse = document.querySelector('#address')
        let x = adresse.getAttribute('data-x')
        let y = adresse.getAttribute('data-y')
        let dep = adresse.getAttribute('data-dep')
        const timeInputs = document.querySelectorAll('.time')
        let data = new FormData()
        data.append('name', document.querySelector('#name').value)
        data.append('managerName', document.querySelector('#manager-name').value)
        data.append('siret', document.querySelector('#siret-number').value)
        data.append('group', document.querySelector('#groupList').value)
        console.log(document.querySelector('#groupList').value)
        data.append('address', adresse.value)
        //faire verif des valeurs quand on est en mode edit car pas de autocompletion
        data.append('coor-x', x)
        data.append('coor-y', y)
        data.append('department', dep)

        for (let i = 0; i < timeInputs.length; i++) {
            data.append(`time${i}`, timeInputs[i].value)
        }
        data.append('image', document.querySelector('#img').files[0])
        console.log(data)
        const res = await request('form-sell-point', 'new', null, null, null, data, 'POST')

        if(res.hasOwnProperty('success')) {
            toast('Point de vente cree', 'text-bg-success')
        } else if (res.hasOwnProperty('error')) {
            toast(res.error, 'text-bg-danger')
        }

    })
}
const autocompletion = () => {
    const autoCompleteJS = new autoComplete({
        selector: "#address",
        threshold: 4,
        data: {
            src: async (query) => {
                    const res = await fetch(`https://api-adresse.data.gouv.fr/search/?q=${query}&limit=10`)
                    const data = await res.json()
                    const array = []
                    for(let i = 0; i < data.features.length; i++) {
                        array.push({label: data.features[i].properties.label})
                    }
                    return array
            },
            keys: ['label']
        },
        resultItem: {
            highlight: true
        },
        events: {
            input: {
                selection: async (event) => {
                    const selection = event.detail.selection.value;
                    autoCompleteJS.input.value = selection.label;
                    const res = await addressAutoCompletion(document.querySelector('#address').value.replace(" ", "+"))
                    const resDep = await getDepartement(res.features[0].properties.postcode)
                    console.log('x =',res.features[0].geometry.coordinates[0])
                    console.log('y =',res.features[0].geometry.coordinates[1])
                    setMarker(null,res.features[0].geometry.coordinates[1], res.features[0].geometry.coordinates[0],
                        '#27742d')
                    setView(res.features[0].geometry.coordinates[0], res.features[0].geometry.coordinates[1], 20)
                    const inputElement = document.querySelector('#address')
                    inputElement.setAttribute('data-x', res.features[0].geometry.coordinates[0])
                    inputElement.setAttribute('data-y', res.features[0].geometry.coordinates[1])
                    inputElement.setAttribute('data-dep', resDep[0].departement.code)
                }
            }
        }
    })
}
const handelModalBtn = () => {
    document.querySelector('#modal-btn')?.addEventListener('click', async () => {
        const formModal = document.querySelector('#form-modal')
        if(formModal.checkValidity() === false) {
            toast('veuillez remplir le formulaire', 'text-bg-danger')
            return false
        }
        const formData = new FormData
        formData.append('name', formModal.querySelector('#group-name').value)
        const res = await request()
        if(res.hasOwnProperty('success')) {
            toast('Group created', 'text-bg-success')
            closeModal()
        }
    })
}