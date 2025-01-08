<div class="mt-2 mb-2 d-flex justify-content-center align-items-center">
    <h1 class="text-center mb-3">Users List</h1>
    <a href="index.php?component=form-user&action=new" class="ms-4 btn btn-success text-warning">Nouvelle utilisateur <i class="fa-solid fa-plus"></i></a>
</div>
<div>
    <table class="table" id="list-users">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">email</th>
            <th scope="col">is_active</th>
            <th scope="col">action</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center">
    <nav aria-label="Page navigation example">
        <ul class="pagination" id="nav-users">

        </ul>
    </nav>
</div>
<script src="./assets/js/components/users.js" type="module"></script>
<script type="module">
    import {refreshPageUsers} from "./assets/js/components/users.js";

    document.addEventListener('DOMContentLoaded', async () => {
        let curentPage = 1
        refreshPageUsers(curentPage)
    })
</script>