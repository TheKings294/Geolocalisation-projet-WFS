import {activeSpinner, disabledSpinner} from "./spinner.js";
import {deletUser} from "../../services/users.js";
import {getInpage} from "./Inpage.js";
import {getRowUsers} from "../users.js";
import {getRowsSellPoint} from "../sell-point.js";
import {request} from "../../services/http-request.js";

export const refreshPage = async (curentPage, situation, component, sens, who) => {
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
        trash[i].addEventListener('click', () => {
            const id = trash[i].getAttribute('data-id')
            const response = deletUser(id)
        })
    }
    const edit = document.querySelectorAll('.fa-pen-to-square')
    for (let i = 0; i < edit.length; i++) {
        edit[i].addEventListener('click', () => {
            const id = edit[i].getAttribute('data-id')
            document.location.href=`index.php?component=form-user&action=get&id=${id}`
        })
    }
    getInpage(nbPage.result.nb, curentPage, situation, component, sens, who)
    disabledSpinner()
}