{extends file = 'index.tpl'}
{block name = 'content'}
    <form method="post">
        <div class="form-group">
            <label for="login">Логин</label>
            <input type="text" class="form-control" name="login" id="login" placeholder="Введите логин">
            <span class="text-danger">{$errors['login_error']|default:''}</span>
        </div>

        <div class="form-group">
            <label for="password">Пароль</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Введите логин">
            <span class="text-danger">{$errors['password_error']|default:''}</span>
        </div>

        <div class="form-group">
            <button class="btn btn-success" type="submit">Войти</button>
        </div>
    </form>
{/block}