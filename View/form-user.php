<div>
    <h1 class="text-center">User Form</h1>
</div>
<div>
    <form id="form-user">
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="col">
                <label for="check-password" class="form-label">Check Password</label>
                <input type="password" class="form-control" id="check-password" name="check-password">
            </div>
        </div>
        <div class="mb-3">
            <input type="checkbox" class="form-check-input" id="is-active" name="is-active">
            <label class="form-check-label" for="is-active">Désactiver</label>
        </div>
        <button type="button" class="btn btn-success" id="valid-btn">Submit</button>
    </form>
</div>
<script src="./assets/js/components/user.js" type="module"></script>
<script type="module">
    import {editUserFunction, setUser} from "./assets/js/components/user.js";

    document.addEventListener('DOMContentLoaded', () => {
        const url = new URL(window.location.href);
        const params = url.searchParams;
        if(params.has('action') && params.get('action') === "edit") {
            editUserFunction(params.get('id'))
        } else if (params.has('action') && params.get('action') === "new") {
            setUser()
        }
    })
</script>