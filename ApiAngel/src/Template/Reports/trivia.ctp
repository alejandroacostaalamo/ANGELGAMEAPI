<div class="div-container">
    <div class="row">
        <div class="col-sm-12">
            <div id="div-menu-col"></div>
            <!-- BOOTSTRAP TABLE -->
            <table class="table table-striped info-table" id="table-pagination" data-url="" data-toggle="table" data-show-columns="true" data-search="true" data-show-export="true" data-pagination="true">
                <thead>
                    <tr>
                       <th data-field="Name" data-align="left" data-halign="left" data-sortable="true">Usuario</th>
                       <th data-field="Score" data-align="left" data-halign="left" data-sortable="true">Score</th>
                       <th data-field="Created" data-align="left" data-halign="left" data-sortable="true">Fecha</th>
                       <th data-field="Game" data-align="left" data-halign="left" data-sortable="true">Juego</th>
                       <th data-field="Level" data-align="left" data-halign="left" data-sortable="true">Nivel</th>
                       <th data-formatter="actionFormatter" data-align="Center" data-halign="Center" data-sortable="true">Acciones</th>
                    </tr>
                </thead>
            </table>
            <!-- BOOTSTRAP TABLE -->
            
        </div>
    </div>   
</div>

<script language='javascript'>
       function ListRep(){
        $.ajax({
            type: "GET",
            url: "getranking/5.json",
            cache: false,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            data: "",
            success: function(data) {			
				$('#table-pagination').bootstrapTable('load', data.Pubs);
            }
        });

    }
	
    function actionFormatter(value, row, index) {
                return [
            /*'<a href="/Pubs/editpub/' + row["PubId"] + '" title="Editar">',
                '<img style="width:15px;margin:5px;" src="/ApiAngel/img/icons/icon_edit.png" alt="Editar">',
            '</a>',
            '<a href="/Pubs/viewpub/' + row["PubId"] + '" title="Detalle">',
                '<img style="width:15px;margin:5px;" src="/ApiAngel/img/icons/icon_view.png" alt="Detalle">',
            '</a>'*/
        ].join('');
    }

    function showDrop(){
        $('.btn-group,span.dropup').click(function(){
           $(this).toggleClass('open');
           //$(this).find('button:first-child').attr('aria-expanded','true');  
        })
        $('span.dropup').click(function(){
            //$(this).find('button:first-child').addClass('open'); 
            $(this).addClass('open'); 
        })  
    }
    
    $(document).ready(function(){
        // $('#div-menu-col').append('<button id="btn-menu-col">button</button>');
        ListRep();
        showDrop();
        $('#btn-span').click(function(){
            $(this).addClass('open')
        })
    });    
</script>