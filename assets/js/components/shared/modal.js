export const modal = (modalBodyText, btnValue, Title) => {
    const modalElement = document.querySelector('#myModal')
    const myModal = new bootstrap.Modal(modalElement)
    const modalBody = document.querySelector('.modal-body')
    const modalBtn = document.querySelector('#modal-btn')
    const modalTitle = document.querySelector('#modal-title')

    modalBody.innerHTML = modalBodyText
    modalBtn.innerHTML = btnValue
    modalTitle.innerHTML = Title
    myModal.show()
}