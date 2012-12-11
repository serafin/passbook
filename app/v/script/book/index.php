<!DOCTYPE html>
<html>
    <head>
        <?=
                $this->_c->head
                ->charset('utf8')
                ->js('/lib/jquery/jquery-1.8.3.min.js')
                ->js('/lib/bootstrap/js/bootstrap.min.js')
                ->js('/lib/jquery.tablesorter/jquery.tablesorter.min.js')
                ->css('/lib/bootstrap/css/bootstrap.min.css')
                ->title('PassBook/' . $this->book->param('book_workspace'))
                ->csscode('.protect{color:white} .protect:hover{color:#000;}')
        ?>
        <script type="text/javascript">
$(function() {
  $("table").tablesorter({ sortList: [[1,0]] });
});
        </script>        
    </head>
    <body style="padding-top:60px;">
        <div class="navbar navbar-fixed-top navbar-inverse">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="brand">PassBook/<?= $this->book->param('book_workspace') ?></a>
                    <ul class="nav">
                        <li><a href="#">Add</a></li>
                        <li><a href="#">Export</a></li>
                    </ul>

                    <form class="navbar-search pull-right">
                        <input type="text" class="search-query" placeholder="Search">
                    </form>        

                </div>
            </div>
        </div>

        <div class="container-fluid">

            <? if (count($this->book)) : ?>
                <table class="table table-bordered table-condensed table-hover table-striped tablesorter">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>type</th>
                            <th>group</th>
                            <th>uri</th>
                            <th>name</th>
                            <th>user</th>
                            <th>pass</th>
                            <th>info</th>
                        </tr>
                    </thead>
                    <tbody>
                        <? foreach ($this->book as $book) : ?>
                            <tr>
                                <td><?= h($book['book_id']) ?></td>
                                <td><?= h($book['book_type']) ?></td>
                                <td><?= h($book['book_group']) ?></td>
                                <td><?= h($book['book_uri']) ?></td>
                                <td><?= h($book['book_name']) ?></td>
                                <td><?= h($book['book_user']) ?></td>
                                <td class="protect"><?= h($book['book_pass']) ?></td>
                                <td><?= h($book['book_info']) ?></td>
                            </tr>
                        <? endforeach ?>
                    </tbody>
                </table>
            <? endif ?>
        </div>        
    </body>
</html>
