export const getRowsSellPoint = (sellPoint) => {
    const line = document.createElement('tr')
    line.innerHTML = `
    <td>${sellPoint.id}</td>
    <td>${sellPoint.name}</td>
    <td>${sellPoint.manager}</td>
    <td>${sellPoint.dep_name}</td>
    <td>${sellPoint.group_name}</td>
    <td>
        <p>
            <i class="fa-solid fa-trash text-danger" data-id="${sellPoint.id}"></i>   
            <i class="fa-solid fa-pen-to-square text-primary" data-id="${sellPoint.id}"></i>
        </p>
    </td>
    `
    return line
}