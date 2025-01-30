export const getRowWarehouse = (warehouse) => {
    const line = document.createElement('tr')
    line.innerHTML = `
    <td>${warehouse.id}</td>
    <td>${warehouse.name}</td>
    <td>${warehouse.address}</td>
    <td>${warehouse.department}</td>
    <td>${warehouse.region}</td>
    <td>
        <p>
            <i class="fa-solid fa-trash text-danger" data-id="${user.id}"></i>   
            <i class="fa-solid fa-pen-to-square text-primary" data-id="${user.id}"></i>
        </p>
    </td>
    `
    return line
}