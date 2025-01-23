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
        handelModalBtnGroup()
    })
    handelBtn()
    sendForm('new')
    autocompletion()
    handelSireneButtonByLength()
}
export const editSellPointFonction = async (id) => {
    handelBtn()
    const res = await request('form-sell-point', 'get', null, null, null, null, 'GET', id)
    const newGroupBtn = document.querySelector('#modal-open')
    if(res.hasOwnProperty('error')) {
        toast(res.error, 'text-bg-danger')
        return false
    }
    newGroupBtn.addEventListener('click', () => {
        modal(modalForm, 'Create group', 'Create Group Form')
        handelModalBntInsee()
    })
    await getGroup()
    setMap(res.result.coordonate_y, res.result.coordonate_x, 13)
    setMarker(null, res.result.coordonate_y, res.result.coordonate_x, '#27742d')
    setView(res.result.coordonate_x, res.result.coordonate_y, 20)
    document.querySelector('#img').required = false
    showSellPointInfo(res.result)
    sendForm('edit')
    handelSireneButtonByLength()
}
const getGroup = async () => {
    const dataList = document.querySelector('#groupList')
    const groupData = await request('groups', 'getall', null, null, null, null, 'GET', null)
    if(groupData.hasOwnProperty('error')) {
        toast(groupData.error, 'text-bg-danger')
        return false
    }
    dataList.innerHTML = ''
    dataList.innerHTML = '<option selected class="list-item" value="null">--Group--</option>'
    for (let i = 0; i < groupData.result.length; i++) {
        const optionElement = document.createElement('option')
        optionElement.setAttribute('value', groupData.result[i].id)
        const textElement = document.createTextNode(groupData.result[i].name)
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
                    document.querySelector('#alert-message').innerHTML = ''
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
                    document.querySelector('#alert-message').innerHTML = '<div class="alert alert-warning" role="alert">\n' +
                        '  Vous devez remplir le formulaire' +
                        '</div>\n'
                    window.scrollTo({
                        top: 0,
                        behavior: "smooth", // Smooth scrolling
                    });
                    return false
                }
                if(i - 1 === 0) {
                    disabledBtn('prev', true)
                } else if (i !== 1) {
                    disabledBtn('next', false)
                    document.querySelector('#next-btn').classList.remove('d-none')
                }
                document.querySelector('#alert-message').innerHTML = ''
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
        let tab
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
        let j = 0
        for (let i = 0; i < WEEK_DAY.length; i++) {
            if(timeInputs[j].value === null && timeInputs[j+1].value === null) {
                tab.push({
                    [WEEK_DAY[i]]: {
                        ouverture: 'fermer',
                        fermeture: 'fermer',
                    }
                })
            } else {
                tab.push({
                    [WEEK_DAY[i]]: {
                        ouverture: timeInputs[j].value,
                        fermeture: timeInputs[j+1].value,
                    }
                })
            }
            j += 2
        }
        data.append('time', JSON.stringify(tab))
        data.append('image', document.querySelector('#img').files[0])
        console.log(tab)
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
const handelModalBtnGroup = () => {
    document.querySelector('#modal-btn')?.addEventListener('click', async () => {
        const formModal = document.querySelector('#form-modal')
        if(formModal.checkValidity() === false) {
            toast('veuillez remplir le formulaire', 'text-bg-danger')
            return false
        }
        const formData = new FormData
        formData.append('name', formModal.querySelector('#group-name').value)
        formData.append('color', formModal.querySelector('#color-group').value)
        const res = await request('groups', 'new', null, null, null, formData, 'POST', null)
        if(res.hasOwnProperty('success')) {
            toast('Group created', 'text-bg-success')
            closeModal()
            await getGroup()
            document.querySelector('#modal-btn').removeEventListener('click', () => {})
        } else if (res.hasOwnProperty('error')) {
            toast(res.error, 'text-bg-danger')
        }
    })
}
const handelModalBntInsee = () => {

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
const handelSireneButtonByLength = () => {
    document.querySelector('#siret-number')?.addEventListener('keydown', (e) => {
        document.querySelector('#sirene-api-btn').disabled = true
        if(e.target.value.length === 14) {
            document.querySelector('#sirene-api-btn').disabled = false
            document.querySelector('#sirene-api-btn')?.addEventListener('click', async () => {
                document.querySelector('#sirene-api-btn').innerHTML = 'Loading ...'
                const res = await request('form-sell-point', 'insee-api', null, null, null, null, 'GET', null, document.querySelector('#siret-number').value)
                if (res.hasOwnProperty('result')) {
                    const data = JSON.parse(res.result)
                    const addressElement = document.querySelector('#address')
                    addressElement.setAttribute('value', data.address)
                    addressElement.setAttribute('data-x', data.coorX)
                    addressElement.setAttribute('data-y', data.coorY)
                    addressElement.setAttribute('data-dep', data.departement)
                    setMarker(null,data.coorX, data.coorY, '#27742d')
                    setView(data.coorY, data.coorX, 20)
                } else if (res.hasOwnProperty('error')) {
                    toast(res.error, 'text-bg-danger')
                }
                document.querySelector('#sirene-api-btn').innerHTML = 'SIRET API'
            })
        }
    })
}