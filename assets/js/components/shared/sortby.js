import {refreshPage} from "./list.js";


export const sortFunction = async (page, situation) => {
    const listHead = document.querySelectorAll('.head')
    const inpageBtn = document.querySelectorAll('.page-link')
    for (let i = 0; i < listHead.length; i++) {
        listHead[i].addEventListener('click', async () => {
            await refreshPage(page, situation, listHead[i].getAttribute('data-component'), listHead[i].getAttribute('data-sens'), listHead[i].getAttribute('data-action'))
            if(listHead[i].getAttribute('data-sens') === 'ASC') {
                listHead[i].setAttribute('data-sens', 'DESC')
            } else if (listHead[i].getAttribute('data-sens') === 'DESC') {
                listHead[i].setAttribute('data-sens', 'ASC')
            }
            for (let j = 0; j < inpageBtn.length; j++) {
                inpageBtn[j].setAttribute('data-component', listHead[i].getAttribute('data-component'))
                inpageBtn[j].setAttribute('data-sens', listHead[i].getAttribute('data-sens'))
                inpageBtn[j].setAttribute('data-action', listHead[i].getAttribute('data-action'))
            }
            return false
        })
    }
}
