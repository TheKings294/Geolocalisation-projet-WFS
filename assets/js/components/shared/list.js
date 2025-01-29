import {activeSpinner, disabledSpinner} from "./spinner.js";
import {getInpage} from "./Inpage.js";
import {getRowUsers} from "../users.js";
import {getRowsSellPoint} from "../sell-point.js";
import {request} from "../../services/http-request.js";
import {toast} from "./toats.js";
import {getRowGroups} from "../groups.js";

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
        } else if (situation === 2) {
            tableBody.appendChild(getRowsSellPoint(data.result[i]))
        } else if (situation === 3) {
            tableBody.appendChild(getRowGroups(data.result[i]))
        }
    }
    const trash = document.querySelectorAll('.fa-trash')
    for (let i = 0; i < trash.length; i++) {
        trash[i].addEventListener('click', async () => {
            const id = trash[i].getAttribute('data-id')
            //console.log(confirm('Voulez vous vriament supriemr'))
            if(confirm('Voulez vous vraiment suprimer') === true) {
                console.log(id)
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