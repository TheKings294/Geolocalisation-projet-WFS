import {request} from "../services/http-request.js";
import {toast} from "./shared/toats.js";
import {setMap, setMarker, setView} from "./shared/map.js";
import {updateProgressBar} from "./shared/progress-bar.js";
import {FORM_PROGRESS_BAR_UPDATE, WEEK_DAY} from "./shared/constant.js";
import {addressAutoCompletion, getDepartement} from "../services/form-sell-point.js";
import {closeModal, modal} from "./shared/modal.js";

const url = new URL(window.location.href);
const params = url.searchParams;

export const formSPFuntion = async () => {
    const newGroupBtn = document.querySelector('#modal-open')
    setMap(47.16, 4.68, 5)
    await getGroup()
    newGroupBtn.addEventListener('click', () => {
        modal(modalForm, 'Create group', 'Create Group Form')
    })
    handelBtn()
    sendForm('new')
    autocompletion()
    handelModalBtn()
}
export const editSellPointFonction = async (id) => {
    handelBtn()
    const res = await request('form-sell-point', 'get', null, null, null, null, 'GET', id)
    if(res.hasOwnProperty('error')) {
        toast(res.error, 'text-bg-danger')
        return false
    }
    await getGroup()
    setMap(res.result.coordonate_y, res.result.coordonate_x, 13)
    setMarker(null, res.result.coordonate_y, res.result.coordonate_x, '#27742d')
    setView(res.result.coordonate_x, res.result.coordonate_y, 20)
    document.querySelector('#img').required = false
    showSellPointInfo(res.result)
    sendForm('edit')
}
const getGroup = async () => {
    const dataList = document.querySelector('#groupList')
    const groupData = await request('groups', 'getall', null, null, null, null, 'GET', null)
    if(groupData.hasOwnProperty('error')) {
        toast(groupData.error, 'text-bg-danger')
        return false
    }
    console.log(groupData)
    for (let i = 0; i < groupData.data.length; i++) {
        const optionElement = document.createElement('option')
        optionElement.setAttribute('value', groupData.data[i].id)
        const textElement = document.createTextNode(groupData.data[i].name)
        optionElement.appendChild(textElement)
        optionElement.classList.add('list-item')
        dataList.appendChild(optionElement)
    }
}

const modalForm = `
<form id="form-modal">
    <div class="mb-3">
        <label for="group-name" class="form-label">Group Name</label>
        <input type="text" id="group-name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="color-group" class="form-label">Group Color</label>
        <input type="color" class="form-control form-control-color" id="color-group" value="#563d7c" title="Choose your color">
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
                } else if (i !== 1) {
                    disabledBtn('next', false)
                    document.querySelector('#next-btn').classList.remove('d-none')
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
const sendForm = (action) => {
    document.querySelector('#form-btn').addEventListener('click', async () => {
        const adresse = document.querySelector('#address')
        let x = adresse.getAttribute('data-x')
        let y = adresse.getAttribute('data-y')
        let dep = adresse.getAttribute('data-dep')
        const timeInputs = document.querySelectorAll('.time')
        let data = new FormData()
        let id
        data.append('name', document.querySelector('#name').value)
        data.append('managerName', document.querySelector('#manager-name').value)
        data.append('siret', document.querySelector('#siret-number').value)
        data.append('group', document.querySelector('#groupList').value)
        data.append('address', adresse.value)
        data.append('coor-x', x)
        data.append('coor-y', y)
        data.append('department', dep)

        if(params.get('action') === "get" && params.has('id')) {
            id = params.get('id')
        } else {
            id = null
        }

        for (let i = 0; i < timeInputs.length; i++) {
            data.append(`time${i}`, timeInputs[i].value)
        }
        data.append('image', document.querySelector('#img').files[0])
        const res = await request('form-sell-point', action, null, null, null, data, 'POST', id)

        if(res.hasOwnProperty('success')) {
            toast(res.success, 'text-bg-success')
            updateProgressBar('100')
            navBtnFuntion(false)
            navBtnFuntion(false)
            if(params.has('action')&& params.get('action') === "new") {
                document.querySelector('#form1').reset()
                document.querySelector('#form2').reset()
                document.querySelector('#form3').reset()
            }
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
const showSellPointInfo = (sell) => {
    document.querySelector('#name').setAttribute('value', sell.name)
    document.querySelector('#manager-name').setAttribute('value', sell.manager)
    document.querySelector('#siret-number').setAttribute('value', sell.siret)
    document.querySelector('#address').setAttribute('value', sell.address)
    const json = JSON.parse(sell.hourly)
    const times = document.querySelectorAll('.time')
    for (let i = 0; i <= 13; i+=2) {
        for (let j = 0; j < 7; j++) {
            times[i].setAttribute('value', json[WEEK_DAY[j]].ouverture)
            times[i+1].setAttribute('value', json[WEEK_DAY[j]].fermeture)
        }
    }
    document.querySelector('#img-view').innerHTML = `
    <img src="./uploads/${sell.img}" class="img-thumbnail" alt="Image du restaurant" width="200px">
    `
    document.querySelector('#address').setAttribute('data-x', sell.coordonate_x)
    document.querySelector('#address').setAttribute('data-y', sell.coordonate_y)
    document.querySelector('#address').setAttribute('data-dep', sell.department)
    const groupElement = document.querySelectorAll('.list-item')
    for(let i = 0; i < groupElement.length; i++) {
        if(groupElement[i].value == sell.group_id) {
            groupElement[i].selected = true
        }
    }
}