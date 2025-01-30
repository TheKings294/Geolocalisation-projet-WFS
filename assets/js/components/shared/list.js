import {activeSpinner, disabledSpinner} from "./spinner.js";
import {getInpage} from "./Inpage.js";
import {getRowUsers} from "../users.js";
import {getRowsSellPoint} from "../sell-point.js";
import {request} from "../../services/http-request.js";
import {toast} from "./toats.js";

export const refreshPage = async (curentPage, situation, component, sens, who, editLink) => {
    const tableElement = document.querySelector('#list')
    const tableBody = tableElement.querySelector('tbody')
    activeSpinner()
    const data = await request(component, component, who, sens, curentPage)
    const nbPage = await request(component, 'page')
    tableBody.innerHTML= ''
    for(let i = 0; i< data.result.length; i++) {
        if(situation === 1) {
            tableBody.appendChild(getRowUsers(data.result[i]))
        } else {
            tableBody.appendChild(getRowsSellPoint(data.result[i]))
        }
    }
    const trash = document.querySelectorAll('.fa-trash')
    for (let i = 0; i < trash.length; i++) {
        trash[i].addEventListener('click', async () => {
            const id = trash[i].getAttribute('data-id')
            if(confirm(`Voulez vous vraiment suprimer le point de vente n°${id}`) === true) {
                const response = await request(component, 'delete', null, null, null, null, 'GET', id)
                if(response.hasOwnProperty('error')) {
                    toast(response.error, 'text-bg-danger')
                } else if (response.hasOwnProperty('success')) {
                    toast('Objet suprimer', 'text-bg-success')
                }
                await refreshPage(curentPage, situation, component, sens, who, editLink)
            }
        })
    }
    const edit = document.querySelectorAll('.fa-pen-to-square')
    for (let i = 0; i < edit.length; i++) {
        edit[i].addEventListener('click', () => {
            const id = edit[i].getAttribute('data-id')
            document.location.href=`index.php?component=form-${editLink}&action=get&id=${id}`
        })
    }
    getInpage(nbPage.result.nb, curentPage, situation, component, sens, who, editLink)
    disabledSpinner()
}