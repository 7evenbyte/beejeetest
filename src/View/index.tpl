<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <title>Hello, world!</title>
</head>
<body>

<main role="main">
    <div class="container p-3">

        {block name = 'content'}
            <div class="row small">
                <div class="col-3">
                    {if !$smarty.session.is_admin|default:false}
                        <a href="/?act=login">Войти как администратор</a>
                    {else}
                        <a href="/?act=logout">Выйти</a>
                    {/if}
                </div>
                <div class="col-9">
                    <span>Сортировать:</span>
                    <a class="px-2" href="/?page={$smarty.get.page|default:1}&sort={$sort|default:'asc'}&sort_by=name">По автору</a>
                    <a class="px-2" href="/?page={$smarty.get.page|default:1}&sort={$sort|default:'asc'}&sort_by=email">По электронной почте</a>
                    <a class="px-2" href="/?page={$smarty.get.page|default:1}&sort={$sort|default:'asc'}&sort_by=status">По статусу</a>
                </div>
            </div>

            <hr>

            <div id="tasks-list">
                {if count($tasks)}
                    {foreach from = $tasks item = task}
                        <div class="list-group">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">{$task->getName()} ({$task->getEmail()})</h5>
                                <small>
                                    {if $smarty.session.is_admin|default:false}<a href="/?act=edit&id={$task->getId()}">Редактировать</a>{/if}
                                    {if $task->getStatus()}Выполнена{else}Не выполнена{/if}
                                </small>
                            </div>
                            <p class="mb-1">{$task->getBody()}</p>
                            <small>{if $task->modifiedByAdmin()}Отредактирована администратором{/if}</small>
                        </div>
                        <hr>
                    {/foreach}
                {/if}
            </div>

            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    {section name = pagination start = 0 loop = $pages}
                        <li class="page-item"><a class="page-link" href="/?page={$smarty.section.pagination.index + 1}&sort={$smarty.get.sort|default:'asc'}&sort_by={$smarty.get.sort_by|default:'task_id'}">{$smarty.section.pagination.index + 1}</a></li>
                    {/section}
                </ul>
            </nav>

            <div id="form-task-list">
                <span class="text-success">{$messages['create_success']|default:''}</span>
                <span class="text-danger">{$errors['form_empty']|default:''}</span>
                <form method="post">
                    <div class="form-group">
                        <label for="name">Имя</label>
                        <input type="text" name="name" required placeholder="Укажите ваше имя" id="name" class="form-control">
                        <span class="text-danger">{$errors['name_error']|default:''}</span>
                    </div>

                    <div class="form-group">
                        <label for="email">Электронная почта</label>
                        <input type="email" name="email" required placeholder="Укажите вашу электронную почту" id="email" class="form-control">
                        <span class="text-danger">{$errors['email_error']|default:''}</span>
                    </div>

                    <div class="form-group">
                        <label for="body">Описание</label>
                        <textarea name="body" id="body" required class="form-control" placeholder="Описание задачи"></textarea>
                        <span class="text-danger">{$errors['body_error']|default:''}</span>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Создать</button>
                    </div>
                </form>
            </div>
        {/block}


    </div>
</main>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>