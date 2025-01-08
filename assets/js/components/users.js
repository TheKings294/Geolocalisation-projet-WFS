import {activeSpinner, disabledSpinner} from "./shared/spinner.js";
import {countPage, getNbPage, getUsers} from "../services/users.js";

export const refreshPageUsers = async (curentPage) => {
    const tableElement = document.querySelector('#list-users')
    const tableBody = tableElement.querySelector('tbody')
    activeSpinner()

    const usersData = await getUsers(curentPage)
    const nbPageData = await getNbPage()
    tableBody.innerHTML= ''
    for(let i = 0; i< usersData.result.length; i++) {
        tableBody.appendChild(getRowUsers(usersData.result[i]))
    }
    getInpage(nbPageData.result.nb, curentPage)
    disabledSpinner()
}

const getRowUsers = (user) => {
    const line = document.createElement('tr')
    line.innerHTML = `
    <td>${user.id}</td>
    <td>${user.email}</td>
    <td><p class="${user.is_active === 1 ? 'text-success' : 'text-danger'}">${user.is_active === 1 ? 'activated' : 'disabled'}</p></td>
    <td></td>
    `
    return line
}

const getInpage = (total, curentPage) => {
    const nbPage = countPage(total)
    const inpageElement = document.querySelector('#nav-users')
    inpageElement.innerHTML = ''
    inpageElement.innerHTML += '<li class="page-item"><a class="page-link" href="#" id="prev-link">Previous</a></li>'

    for (let i = 0; i < nbPage; i++) {
        inpageElement.innerHTML += `<li class="page-item"><a class="page-link nb-page-link" href="#" data-page="${i+1}">${i+1}</a></li>`
    }
    inpageElement.innerHTML += '<li class="page-item"><a class="page-link" href="#" id="next-link">Next</a></li>'
    handleInpageClick(curentPage)
}

const handleInpageClick = (curentPage) => {
    const nextLink = document.querySelector('#next-link')
    const previousLink = document.querySelector('#prev-link')
    const nbPageLink = document.querySelectorAll('.nb-page-link')

    previousLink.addEventListener('click', async () => {
        if(curentPage > 1) {
            curentPage--
            await refreshPageUsers(curentPage)
        }
    })

    nextLink.addEventListener('click', async () => {
        curentPage++
        await refreshPageUsers(curentPage)
    })

    nbPageLink.forEach(btn => {
        btn.addEventListener('click', async (e) => {
            await refreshPageUsers(e.target.getAttribute("data-page"))
        })
    })
}