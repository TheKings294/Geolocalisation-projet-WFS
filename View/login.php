<div>
    <h1 class="text-center">Login</h1>
</div>
<div class="ms-8 me-8">
    <form method="post" id="form-login">
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="button" class="btn btn-success" id="login-btn">Submit</button>
    </form>
</div>
<script src="./assets/js/components/login.js" type="module"></script>
<script type="module">
    import {handelForm} from "./assets/js/components/login.js";

    document.addEventListener('DOMContentLoaded', () => {
        handelForm()
    })
</script>
