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
<script src="./assets/js/services/login.js" type="module"></script>
<script src="./assets/js/components/shared/toats.js" type="module"></script>
<script type="module">
    import {login} from "./assets/js/services/login.js";
    import {toast} from "./assets/js/components/shared/toats.js";

    const formLogin = document.querySelector('#form-login')
    const btnLogin = document.querySelector('#login-btn')

    btnLogin.addEventListener('click', async () => {
        if(formLogin.checkValidity() === false) {
            formLogin.reportValidity()
            return false
        }
        const loginResult = await login(formLogin)

        if(loginResult.hasOwnProperty('success')) {
            toast('authentication successful', 'text-bg-success')
            document.location.href='index.php'
        } else if (loginResult.hasOwnProperty('error')) {
            toast(loginResult.error, 'text-bg-danger')
        }
    })
</script>
