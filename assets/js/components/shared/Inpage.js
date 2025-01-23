import {refreshPage} from "./list.js";
import {LIST_ITEM_PER_PAGE} from "./constant.js";


export const getInpage = (total, curentPage, situation, component, sens, action, editLink) => {
    const nbPage = countPage(total)
    const inpageElement = document.querySelector('#nav-users')
    inpageElement.innerHTML = ''
    inpageElement.innerHTML += `<li class="page-item"><a class="page-link" href="#" id="prev-link" data-component="${component}" data-sens="${sens}" data-action="${action}">Previous</a></li>`

    for (let i = 0; i < nbPage; i++) {
        inpageElement.innerHTML += `<li class="page-item"><a class="page-link nb-page-link" href="#" data-page="${i+1}" data-component="${component}" data-sens="${sens}" data-action="${action}">${i+1}</a></li>`
    }
    inpageElement.innerHTML += `<li class="page-item"><a class="page-link" href="#" id="next-link" data-component="${component}" data-sens="${sens}" data-action="${action}">Next</a></li>`
    handleInpageClick(curentPage, situation, editLink)
}

export const handleInpageClick = (curentPage, situation, editLink) => {
    console.log(editLink)
    const nextLink = document.querySelector('#next-link')
    const previousLink = document.querySelector('#prev-link')
    const nbPageLink = document.querySelectorAll('.nb-page-link')

    previousLink.addEventListener('click', async () => {
        if(curentPage > 1) {
            curentPage--
            await refreshPage(curentPage, situation, previousLink.getAttribute('data-component'), previousLink.getAttribute('data-sens'), previousLink.getAttribute('data-action'), editLink)
        }
    })

    nextLink.addEventListener('click', async () => {
        curentPage++
        await refreshPage(curentPage, situation, nextLink.getAttribute('data-component'), nextLink.getAttribute('data-sens'), nextLink.getAttribute('data-action'), editLink)
    })

    nbPageLink.forEach(btn => {
        btn.addEventListener('click', async (e) => {
            await refreshPage(e.target.getAttribute("data-page"), situation, btn.getAttribute('data-component'), btn.getAttribute('data-sens'), btn.getAttribute('data-action'), editLink)
        })
    })
}

const countPage = (total) => {
    return Math.ceil(total/LIST_ITEM_PER_PAGE)
}