export const getRowUsers = (user) => {
    const line = document.createElement('tr')
    line.innerHTML = `
    <td>${user.id}</td>
    <td>${user.email}</td>
    <td><p class="${user.is_active === 1 ? 'text-success' : 'text-danger'}">${user.is_active === 1 ? 'activated' : 'disabled'}</p></td>
    <td><p><i class="fa-solid fa-trash text-danger" data-id="${user.id}"></i>   <i class="fa-solid fa-pen-to-square text-primary" data-id="${user.id}"></i></p></td>
    `
    return line
}

