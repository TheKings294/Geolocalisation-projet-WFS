export const deletUser = async (id) => {
    const res = await fetch(`index.php?component=user&action=delet&id=${id}`, {
        headers: {
            'X-Requested-Width': 'XMLHttpRequest'
        }
    })

    return await res.json()
}
