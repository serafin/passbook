<!DOCTYPE html>
<html>
    <head>
        <?=
                $this->_c->head
                ->charset('utf8')
                ->js('/lib/jquery/jquery-1.8.3.min.js')
                ->js('/lib/bootstrap/js/bootstrap.min.js')
                ->js('/lib/jquery/jquery.dataTables.min.js')
                ->js('/lib/CryptoJS/aes.js')
                ->css('/lib/bootstrap/css/bootstrap.min.css')
                ->title('PassBook/' . $this->book->param('book_workspace'))
        ?>
        <style type="text/css">
            
th      { cursor: default; }
td      { cursor: text; }
.sorting_asc:after   { content: '▲'; } 
.sorting_desc:after  {  content: '▼'; }
td .protect {visibility: hidden; }
td:hover .protect {visibility: visible; }
            
.typeahead.dropdown-menu {
 z-index: 1051;
 }
 .modal {
    -webkit-transition: none;
    -moz-transition: none;
    -ms-transition: none;
    -o-transition: none;
    transition: none;
}
        </style>
        <script type="text/javascript">
var cipher = '<?= addslashes(h((string)$_SESSION['cipher'])) ?>'; 
<? $_SESSION['cipher'] = '' ?>
var start  = function() {
    
    // sort table
    var oTable = $('#table').dataTable({
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bSort": true,
        "bInfo": false,
        "bAutoWidth": true,
        "sDom": 't'
    });
    
    // filter table
    $("#search").bind('change keyup',  function () {
        oTable.fnFilter( this.value );
    });
    
    
    // show edit form
    $('#table tbody tr').dblclick(function(){
        
        $('#book_id')   .val($(this).find('.js-data-book-id')   .text());
        $('#book_type') .val($(this).find('.js-data-book-type') .text());
        $('#book_group').val($(this).find('.js-data-book-group').text());
        $('#book_uri')  .val($(this).find('.js-data-book-uri')  .text());
        $('#book_name') .val($(this).find('.js-data-book-name') .text());
        $('#book_user') .val($(this).find('.js-data-book-user') .text());
        $('#book_pass') .val($(this).find('.js-data-book-pass') .text());
        $('#book_info') .val($(this).find('.js-data-book-info') .text());
        
        $('#form-title').text('#' + $(this).find('.js-data-book-id').text());
        
        $('#table tr.info').removeClass('info');
        
        // delete
        $('#form-del').show();
        $('#del-checkbox').attr('checked', false);
        $('#form input[name=save]').show();
        $('#form input[name=del]').hide();
        
        $('#form').modal('show');
    });
    
    // show add form
    $('#add').click(function(){
        
        $('#book_id, #book_type, #book_group, #book_uri, #book_name, #book_user, #book_info, #book_info').val('');
        $('#book_pass').val(generatePassword());
        
        $('#form-title').text('Add');
        
        $('#table tr.info').removeClass('info');
        
        $('#form-del').hide();
        $('#form input[name=save]').show();
        $('#form input[name=del]').hide();
        
        
        
        $('#form').modal('show');
    });
    
    // encrypt form before send
    $('#form form').submit(function() {
        $('#form').modal('hide');
        $('#form .js-encrypt').each(function(){
            $(this).val(encrypt($(this).val()));
        });
        return true;
    });
    
    // delete
    $('#del-checkbox').change(function(){
        if ($(this).attr('checked')) {
            $('#form input[name=save]').hide();
            $('#form input[name=del]').show();
        }
        else {
            $('#form input[name=save]').show();
            $('#form input[name=del]').hide();
        }
    });
    
    // fix modal width
    $('#form').css({
        width: 'auto',
        'margin-left': function () {
            return -($(this).width() / 2);
        }
    });    
    
    // typeahead
        var source = [];
        $('#table tbody td.js-typeahead-type').each(function(){
            source[source.length] = $(this).text();
        });
        $('#book_type').typeahead({'source': unique(source)});
    
        source = [];
        $('#table tbody td.js-typeahead-group').each(function(){
            source[source.length] = $(this).text();
        });
        $('#book_group').typeahead({'source': unique(source)});
};

function generatePassword() {
    var length  = 24,
        charset = "abcdefghijklnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
        retVal  = "";
    for (var i = 0, n = charset.length; i < length; ++i) {
        retVal += charset.charAt(Math.floor(Math.random() * n));
    }
    return retVal;
}

function unique(arr) { 
    var a = []; 
    var l = arr.length; 
    for(var i=0; i<l; i++) { 
        for(var j=i+1; j<l; j++) { 
            if (arr[i] === arr[j]) j = ++i; 
        } 
        a.push(arr[i]); 
    } 
    return a; 
}

function encrypt(s)
{
    return CryptoJS.AES.encrypt(s, cipher)
}

function decrypt(s)
{
    return CryptoJS.AES.decrypt(s, cipher).toString(CryptoJS.enc.Utf8);
}

$(function(){
    if (cipher.length == 0) {
        cipher = window.prompt('Enter the key', '');
    }
    
    if (cipher.length == 0) {
        return;   
    }
    
    $('#cipher').val(cipher);
    
    $('.navbar .nav, .navbar .navbar-search, #table').show();
    
    $('#table .js-decrypt').each(function(){
        $(this).text(decrypt($(this).text()));
    });
    
    start();
});

        </script> 



    </head>
    <body style="padding-top:60px;">
        <div class="navbar navbar-fixed-top navbar-inverse">
            <div class="navbar-inner">
                <div class="container-fluid">
                    
                    <a class="brand">PassBook/<?= h($this->book->param('book_workspace')) ?></a>
                    
                    <ul class="nav" style="display: none;">
                        <li><a href="#" id="add">Add</a></li>
                        <li class="hide"><a href="#">Export</a></li>
                    </ul>

                    <span class="navbar-search pull-right" style="display: none;">
                        <input type="text" id="search" class="search-query" placeholder="Search">
                    </span>        

                </div>
            </div>
        </div>

        <div class="container-fluid">

            <? if ($this->_c->c->flash->is()) : ?>
                <? foreach ($this->_c->c->flash->get() as $i) : ?>
                    <div class="alert <?= $i['status'] == 'error' ? 'alert-error' : 'alert-info' ?>">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <?= h($i['msg'])?>
                    </div>
                    <? $modified = $i['param']['id'] ?>
                <? endforeach ?>
            <? endif ?>
            
            <? if (count($this->book)) : ?>
                <table id="table" class="table table-bordered table-condensed table-hover table-striped tablesorter" style="display: none;">
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
                            <tr 
                                class="<?= $modified == $book['book_id'] ? 'info' : '' ?>"
                            >
                                <td class="js-data-book-id"><?= h($book['book_id']) ?></td>
                                <td class="js-data-book-type js-decrypt js-typeahead-type"><?= h($book['book_type']) ?></td>
                                <td class="js-data-book-group js-decrypt js-typeahead-group"><?= h($book['book_group']) ?></td>
                                <td class="js-data-book-uri js-decrypt"><?= h($book['book_uri']) ?></td>
                                <td class="js-data-book-name js-decrypt"><?= h($book['book_name']) ?></td>
                                <td class="js-data-book-user js-decrypt"><?= h($book['book_user']) ?></td>
                                <td><span class="js-data-book-pass protect js-decrypt"><?= h($book['book_pass']) ?></span></td>
                                <td class="js-data-book-info js-decrypt"><?= h($book['book_info']) ?></td>
                            </tr>
                        <? endforeach ?>
                    </tbody>
                </table>
            <? endif ?>
        </div>
        
        <!-- #form -->
        <div id="form" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="form-title" aria-hidden="true">
            <form class="form-horizontal" method="post" action="" style="margin:0;">

                <div class="modal-header">
                    <a class="close" data-dismiss="modal">&times;</a>
                    <h3 id="form-title"></h3>
                </div>
                <div class="modal-body">
                
                    
                    <input type="hidden" name="cipher" id="cipher" value="" />
                    <input type="hidden" name="book_id" id="book_id" value="" />
                    <input type="hidden" name="book_workspace" value="<?= h($this->book->param('book_workspace')) ?>" />
                    
                    <div class="control-group">
                        <label class="control-label" for="book_type">type</label>
                        <div class="controls"><input type="text" id="book_type" name="book_type" class="span4 js-encrypt" autocomplete="off"></div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label" for="book_group">group</label>
                        <div class="controls"><input type="text" id="book_group" name="book_group" class="span4 js-encrypt" autocomplete="off"></div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label" for="book_uri">uri</label>
                        <div class="controls"><input type="text" id="book_uri" name="book_uri" class="span4 js-encrypt"></div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label" for="book_name">name</label>
                        <div class="controls"><input type="text" id="book_name" name="book_name" class="span4 js-encrypt"></div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label" for="book_user">user</label>
                        <div class="controls"><input type="text" id="book_user" name="book_user" class="span4 js-encrypt"></div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label" for="book_pass">pass</label>
                        <div class="controls"><input type="text" id="book_pass" name="book_pass" class="span4 js-encrypt"></div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label" for="book_info">info</label>
                        <div class="controls"><input type="text" id="book_info" name="book_info" class="span4 js-encrypt"></div>
                    </div>
                    
                    <div id="form-del" class="control-group error">
                        <div class="controls"><label><input type="checkbox" id="del-checkbox" />  <span class="help-inline">delete this record</span></label></div>
                    </div>
                    
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                    <input type="submit" name="save" class="btn btn-primary" value="Save">
                    <input type="submit" name="del" class="btn btn-danger" value="Delete">
                </div>
            </form>
        </div>        
    </body>
</html>
