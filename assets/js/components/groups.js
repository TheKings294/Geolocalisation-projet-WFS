export const getRowGroups = (group) => {
    const line = document.createElement('tr')
    line.innerHTML = `
    <td>${group.id}</td>
    <td>${group.name}</td>
    <td><p style="color: ${group.color}; background-color: ${group.color}">jqhsdqjhsd</p></td>
    <td>
        <p>
            <i class="fa-solid fa-trash text-danger" data-id="${group.id}"></i>   
            <i class="fa-solid fa-pen-to-square text-primary" data-id="${group.id}"></i>
        </p>
    </td>
    `
    return line
}
