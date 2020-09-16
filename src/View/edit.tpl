{extends file = 'index.tpl'}
{block name = 'content'}
    <form method="post">
        <div class="form-group">
            <label for="name">Имя пользователя</label>
            <input type="text" name="name" id="name" value="{$task->getName()|default:''}" class="form-control">
        </div>

        <div class="form-group">
            <label for="email">Электронная почта</label>
            <input type="text" name="email" id="email" value="{$task->getEmail()|default:''}" class="form-control">
        </div>

        <div class="form-group">
            <label for="body">Описание задачи</label>
            <textarea class="form-control" name="body" id="body">{$task->getBody()|default:''}</textarea>
        </div>

        <div class="form-group">
            <label for="status">Статус</label>
            <select name="status" id="status" class="form-control">
                <option value="0" {if $task->getStatus()|default:0 == 0}selected{/if}>Не выполнена</option>
                <option value="1" {if $task->getStatus()|default:0 == 1}selected{/if}>Выполнена</option>
            </select>
        </div>

        <div class="form-group">
            <button class="btn btn-success" type="submit">Сохранить</button>
        </div>
    </form>
{/block}