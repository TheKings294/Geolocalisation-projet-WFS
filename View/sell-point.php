<div class="mt-2 mb-2 d-flex justify-content-center align-items-center">
    <h1 class="text-center mb-3">Sell Point List</h1>
    <a href="index.php?component=form-sell-point&action=new" class="ms-4 btn btn-success text-warning">New Sell Point <i class="fa-solid fa-plus"></i></a>
</div>
<div>
    <table class="table" id="list">
        <thead>
        <tr>
            <th scope="col"><button type="button" data-component="sell-point" data-action="id" data-sens="ASC" class="head btn btn-success">#</button></th>
            <th scope="col" ><button type="button" data-component="sell-point" data-action="name" data-sens="ASC" class="head btn btn-success">name</button></th>
            <th scope="col"><button type="button" data-component="sell-point" data-action="manager" data-sens="ASC" class="head btn btn-success">manager</button></th>
            <th scope="col"><button type="button" data-component="sell-point" data-action="department" data-sens="ASC" class="head btn btn-success">department</button></th>
            <th scope="col"><button type="button" data-component="sell-point" data-action="group_name" data-sens="ASC" class="head btn btn-success">group</button></th>
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
<script src="./assets/js/components/shared/list.js" type="module"></script>
<script src="./assets/js/components/shared/sortby.js" type="module"></script>
<script type="module">
    import {sortFunction} from "./assets/js/components/shared/sortby.js";
    import {refreshPage} from "./assets/js/components/shared/list.js";

    document.addEventListener('DOMContentLoaded', async () => {
        let curentPage = 1
        await sortFunction(curentPage, 2)
        refreshPage(curentPage, 2, 'sell-point', 'ASC', 'id', 'sell-point')
    })
</script>

