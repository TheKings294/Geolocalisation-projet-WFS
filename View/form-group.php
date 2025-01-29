<div>
    <h1 class="text-center">Form group</h1>
</div>
<div>
    <form id="form-group">
        <div class="mb-3">
            <label for="group-name" class="form-label">Group name</label>
            <input type="text" id="group-name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="group-color" class="form-label">Group color</label>
            <input type="color" id="group-color" class="form-control form-control-color" required>
        </div>
        <button type="button" class="btn btn-success text-warning" id="form-group-btn">Submit</button>
    </form>
</div>
<script src="./assets/js/components/form-group.js" type="module"></script>
<script type="module">
    import {editFormGroup, newFormGroup} from "./assets/js/components/form-group.js"

    document.addEventListener('DOMContentLoaded', () => {
        const url = new URL(window.location.href);
        const params = url.searchParams;
        if (params.has('action') && params.get('action') === "get") {
            editFormGroup(params.get('id'))
        } else if (params.has('action') && params.get('action') === "new") {
            newFormGroup()
        }
    })
</script>