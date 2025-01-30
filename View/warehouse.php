<div class="mt-2 mb-2 d-flex justify-content-center align-items-center">
    <h1 class="text-center mb-3">Warehouse</h1>
    <a href="index.php?component=form-warehouse&action=new" class="ms-4 btn btn-success text-warning">New Warehouse <i class="fa-solid fa-plus"></i></a>
</div>
<div>
    <table class="table" id="list">
        <thead>
        <tr>
            <th scope="col"><button type="button"
                                    data-component="users"
                                    data-action="id"
                                    data-sens="ASC"
                                    class="head btn btn-success">
                    #
                </button>
            </th>
            <th scope="col" ><button type="button"
                                     data-component="warehouse"
                                     data-action="name"
                                     data-sens="ASC"
                                     class="head btn btn-success">
                    nom
                </button>
            </th>
            <th scope="col"><button type="button"
                                    data-component="warehouse"
                                    data-action="address"
                                    data-sens="ASC"
                                    class="head btn btn-success">
                    address
                </button>
            </th>
            <th scope="col" ><button type="button"
                                     data-component="warehouse"
                                     data-action="department"
                                     data-sens="ASC"
                                     class="head btn btn-success">
                    department
                </button>
            </th>
            <th scope="col" ><button type="button"
                                     data-component="warehouse"
                                     data-action="region"
                                     data-sens="ASC"
                                     class="head btn btn-success">
                    region
                </button>
            </th>
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
    import {refreshPage} from "./assets/js/components/shared/list.js";
    import {sortFunction} from "./assets/js/components/shared/sortby.js";

    document.addEventListener('DOMContentLoaded', async () => {
        let curentPage = 1
        await sortFunction(curentPage, 4, 'warehouse')
        refreshPage(curentPage, 4, 'warehouse', 'ASC', 'id', 'warehouse')
    })
</script>
